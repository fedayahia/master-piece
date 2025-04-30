<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Coupon;
use App\Models\PrivateSession;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class CheckoutController extends Controller
{
    public function billing(Request $request)
    {

        session()->forget(['coupon_discount', 'coupon_code', 'coupon_applied']);

        $type = $request->query('type');
        $item_id = $request->query('item_id');
    
        if ($type === 'private') {
            $booking = session('current_booking');
    
            if (empty($booking) || !isset($booking['step_completed'])) {
                \Log::warning('Incomplete booking attempt', [
                    'has_session' => !empty($booking),
                    'step_completed' => $booking['step_completed'] ?? false,
                    'all_session' => session()->all() 
                ]);
                
                return redirect()->route('private-sessions.book', $item_id)
                       ->with('error', 'Please complete the booking form first');
            }
        }
    
        try {
            $item = $type === 'course' 
                ? Course::with('instructor')->findOrFail($item_id)
                : PrivateSession::with('instructor')->findOrFail($item_id);
    
            $sessionData = [
                'item_type' => $type,
                'item_id' => $item->id,
                'item_title' => $item->title,
                'item_price' => $item->price,
                'item_duration' => $type === 'course' 
                    ? $item->duration . ' hours' 
                    : $item->duration . ' minutes',
                'item_image' => $item->image,
                'instructor_name' => $item->instructor->name ?? 'Multiple Instructors'
            ];
    
            if ($type === 'private' && session('current_booking')) {
                $sessionData = array_merge($sessionData, [
                    'current_booking' => session('current_booking')
                ]);
            }
    
            session($sessionData);
    
            return view('checkout.billing', [
                'item' => $item,
                'type' => $type,
                'session_time' => $type === 'private' 
                    ? session('current_booking.session_time') 
                    : null,
                'special_requests' => $type === 'private'
                    ? session('current_booking.special_requests')
                    : null
            ]);
    
        } catch (\Exception $e) {
            \Log::error('Checkout error', [
                'error' => $e->getMessage(),
                'type' => $type,
                'item_id' => $item_id
            ]);
            
            return redirect()->route($type === 'course' ? 'courses.index' : 'private-sessions.index')
                   ->with('error', 'The requested item was not found.');
        }
    }
    public function processBilling(Request $request)
    {
        $validated = $request->validate([
            'billing_name' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'billing_phone' => 'required|string|max:20',
            'booking_type' => 'required|in:course,private',
            'item_id' => 'required|integer'
        ]);
    
        if ($validated['booking_type'] === 'course') {
            $item = Course::findOrFail($validated['item_id']);
        } else {
            $item = PrivateSession::findOrFail($validated['item_id']);
        }
    
        session([
            'billing_details' => $validated,
            'billing_completed' => true,
            'booking_type' => $validated['booking_type'],
            'item_id' => $item->id,
            'item_title' => $item->title,
            'item_price' => $item->price,
            'instructor_name' => $item->instructor->name ?? 'Multiple Instructors',
            'session_time' => $validated['booking_type'] === 'private' ? $request->session_time : null,
            'special_requests' => $validated['booking_type'] === 'private' ? $request->special_requests : null
        ]);
    
        return response()->json(['success' => true]);

        \Log::info('Billing Data:', [
            'billing_completed' => session('billing_completed'),
            'item_id' => session('item_id'),
            'all_session' => session()->all()
        ]);
    }
    public function payment()
    {
        if (!session('booking_type')) {
            return redirect()->route('courses.index')
                   ->with('error', 'Please select a booking type first!');
        }
    
        if (!session('item_id')) {
            return redirect()->route('courses.index')
                   ->with('error', 'Please select an item first!');
        }
    
        if (!session('billing_completed')) {
            return redirect()->route('courses.index')
                   ->with('error', 'يرجى إكمال معلومات الفاتورة أولاً!');
        }
    
        $itemId = session('item_id');
        $bookingType = session('booking_type');
    
        $item = $bookingType === 'course'
            ? Course::find($itemId)
            : PrivateSession::find($itemId);
    
        if (!$item) {
            return redirect()->route('courses.index')
                   ->with('error', 'العنصر المطلوب غير موجود!');
        }
    
        $price = session('item_price', 0);
        $couponDiscount = session('coupon_discount', 0);
        $total = $price - $couponDiscount;
    
        return view('checkout.payment', [
            'item' => $item, 
            'total' => $total
        ]);
    }
    

  
    
    public function complete()
    {
        // التحقق من وجود حجز مكتمل
        if (!session('current_booking_id')) {
            return redirect()->route('courses.index')
                   ->with('error', 'No completed booking found');
        }
    
        $booking = Booking::with('course')->findOrFail(session('current_booking_id'));
        
        // تنظيف الجلسة
        session()->forget([
            'current_booking_id',
            'course_id',
            'course_title',
            'course_price',
            'billing_details',
            'billing_completed',
            'applied_coupon',
            'coupon_discount'
        ]);
        
        return view('checkout.complete', compact('booking'));
    }


    public function scopeValidFor($query, $item)
    {
        return $query->where('applicable_type', get_class($item))  // تأكد من استخدام الكلاس الصحيح
                     ->where('applicable_id', $item->id)
                     ->where('status', 'active');
    }
    
    public function applyCoupon(Request $request)
    {
        // Validate the required input fields
        $request->validate([
            'coupon_code' => 'required|string',
            'item_id' => 'required',
            'booking_type' => 'required|in:course,private'
        ]);
    
        // 🔒 Check coupon usage count in the current session
        $usedCoupons = session()->get('used_coupons', []);
        $code = strtoupper(trim($request->coupon_code));
    
        // Prevent using the same coupon more than once in a single session
        if (isset($usedCoupons[$code]) && $usedCoupons[$code] >= 1) {
            return response()->json([
                'success' => false,
                'message' => 'You have already used this coupon.'
            ], 403);
        }
    
        // Clear any previous coupon session data
        session()->forget(['coupon_discount', 'coupon_code', 'coupon_applied']);
    
        // Retrieve the coupon if it exists and is active
        $coupon = Coupon::where('code', $code)
                        ->where('status', 'active')
                        ->first();
    
        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'The coupon is invalid or does not exist.'
            ], 404);
        }
    
        // Find the item (course or private session) to apply the discount on
        $item = $request->booking_type === 'course' 
            ? Course::find($request->item_id)
            : PrivateSession::find($request->item_id);
    
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'The selected item was not found.'
            ], 404);
        }
    
        // Calculate discount amount
        $discount = $coupon->discount_type === 'percentage'
            ? ($item->price * $coupon->discount_amount) / 100
            : $coupon->discount_amount;
    
        // ✅ Store coupon info in session
        session([
            'coupon_discount' => $discount,
            'coupon_code' => $coupon->code,
            'coupon_applied' => true,
        ]);
    
        // ✅ Track that this coupon was used in the session
        $usedCoupons[$code] = ($usedCoupons[$code] ?? 0) + 1;
        session()->put('used_coupons', $usedCoupons);
    
        // Return success response with discount and total price after discount
        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully.',
            'discount' => $discount,
            'total' => $item->price - $discount
        ]);
    }
    
private function calculateTotalAmount(Course $course)
{
    $coursePrice = session('course_price', $course->price);
    $discount = session('coupon_discount', 0);
    
    return max($coursePrice - $discount, 0);
}
public function handleStripe(Request $request)
{
    if (!session()->has('item_id') || !session()->has('booking_type')) {
        return response()->json(['error' => 'No item selected'], 400);
    }

    $itemId = session('item_id');
    $bookingType = session('booking_type');
    $totalAmount = session('item_price') - (session('coupon_discount') ?? 0);
    $currentBooking = session('current_booking');

    // تسجيل بيانات الجلسة للتحقق
    \Log::info('Session data:', [
        'item_id' => $itemId,
        'booking_type' => $bookingType,
        'current_booking' => $currentBooking
    ]);

    try {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $charge = \Stripe\Charge::create([
            'amount' => $totalAmount * 100,
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Payment for ' . $bookingType . ': ' . session('item_title'),
        ]);

        \DB::beginTransaction();
        \Log::info('Database transaction started');

        // تعريف أنواع الحجوزات المسموحة
        $validBookingTypes = [
            'private' => [
                'model' => 'PrivateSession', // حفظ النوع فقط
                'require_time' => true
            ],
            'course' => [
                'model' => 'Course', // حفظ النوع فقط
                'require_time' => false
            ]
        ];

        // التحقق من نوع الحجز
        if (!array_key_exists($bookingType, $validBookingTypes)) {
            throw new \Exception('Invalid booking type: ' . $bookingType);
        }

        $bookingConfig = $validBookingTypes[$bookingType];
        $bookingForType = $bookingConfig['model'];  // حفظ النوع فقط
        $bookingForId = $itemId;
        $availableTime = null;

        // معالجة الجلسات الخاصة
        if ($bookingType === 'private') {
            if (empty($currentBooking['available_time_id'])) {
                throw new \Exception('Time slot is required for private sessions');
            }

            $availableTime = \App\Models\AvailableTime::findOrFail($currentBooking['available_time_id']);
            $bookingForId = $currentBooking['available_time_id'];

            // تأكد من أن الوقت المتاح ليس محجوزاً بالفعل
            if ($availableTime->is_available == false) {
                throw new \Exception('Time slot is no longer available');
            }

            // تحديث حالة الوقت للجلسات الخاصة
            $availableTime->update(['is_available' => false]);

            \Log::info('Time slot marked as unavailable', ['id' => $availableTime->id]);
        }

        // إنشاء بيانات الحجز
        $bookingData = [
            'user_id' => auth()->id(),
            'booking_for_type' => $bookingForType,  // حفظ النوع فقط
            'booking_for_id' => $bookingForId,
            'status' => 'enrolled',
            'seat_number' => 'BOOK-' . strtoupper(Str::random(8)),
        ];

        // إضافة بيانات الوقت للجلسات الخاصة
        if ($availableTime) {
            $bookingData['available_time_id'] = $availableTime->id;
            $bookingData['booking_date'] = $availableTime->available_date;
        }

        $booking = Booking::create($bookingData);
        \Log::info('Booking created', ['id' => $booking->id]);

        // تحديث الكورس لتقليل عدد المقاعد المتاحة
        if ($bookingForType === 'Course') {
            $course = \App\Models\Course::findOrFail($bookingForId);
            if ($course->seats_available > 0) {
                $course->decrement('seats_available');
                \Log::info('Seats available for course updated', ['course_id' => $course->id, 'seats_available' => $course->seats_available]);
            } else {
                throw new \Exception('No seats available for this course');
            }
        }

        // تسجيل الدفع
        Payment::create([
            'method' => 'stripe',
            'user_id' => auth()->id(),
            'payment_for_type' => $bookingForType,  // حفظ النوع فقط
            'payment_for_id' => $bookingForId,
            'amount' => $totalAmount,
            'booking_id' => $booking->id,
            'transaction_id' => $charge->id,
            'paid_at' => now()
        ]);

        \DB::commit();
        \Log::info('Transaction committed successfully');

        // تنظيف الجلسة
        session()->forget([
            'current_booking',
            'coupon_discount',
            'coupon_code'
        ]);

        return response()->json([
            'success' => true,
            'booking_id' => $booking->id,
            'receipt_url' => $charge->receipt_url
        ]);

    } catch (\Exception $e) {
        \DB::rollBack();
        \Log::error('Error: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


// دالة لمعالجة الدفع الناجح
private function processSuccessfulPayment($charge, $course)
{
    \DB::transaction(function () use ($charge, $course) {
        // سجّل تفاصيل الدفع
        Log::info("Processing payment for course: " . $course->title);

        // إنشاء الحجز
        $booking = $this->createBooking($course);

        // سجّل الحجز الذي تم إنشاؤه
        Log::info("Booking created with ID: " . $booking->id);

        // إنشاء الدفع
        Payment::create([
            'method' => 'credit_card',
            'payment_date' => now(),
            'user_id' => auth()->id(),
            'payment_for_type' => 'Course',  // تحديد نوع الدفع كـ 'Course'
            'payment_for_id' => $course->id,
            'amount' => $this->calculateTotalAmount($course),
            'booking_id' => $booking->id,
            'payment_method' => 'credit_card',
            'status' => 'completed',
            'transaction_id' => $charge->id,
            'paid_at' => now(),
        ]);

        // تقليص عدد المقاعد المتاحة
        $course->decrement('seats_available');
        $course->save();

        // حفظ ID الحجز في الجلسة
        session(['current_booking_id' => $booking->id]);

        // حفظ رابط الإيصال
        $this->receiptUrl = $charge->receipt_url;

        // سجّل نجاح عملية الدفع
        Log::info("Payment completed successfully for course: " . $course->title);
        Log::info("Transaction ID: " . $charge->id);
        Log::info("Receipt URL: " . $this->receiptUrl);
    });

    return response()->json([
        'success' => true,
        'message' => 'Payment successful!',
        'booking_id' => session('current_booking_id'),
        'receipt_url' => $this->receiptUrl
    ]);
}

// دالة لمعالجة الأخطاء و إضافة سجلات عند حدوث أخطاء في الدفع
private function getFriendlyErrorMessage(\Exception $e)
{
    // إذا كانت هناك مشكلة في بطاقة الدفع
    if ($e instanceof \Stripe\Exception\CardException) {
        $errorMessage = 'Card payment failed: ' . $e->getError()->message;
        Log::error("Card payment failed: " . $errorMessage);
        return $errorMessage;
    }

    // إذا كانت هناك مشكلة في الاتصال بـ Stripe
    if (str_contains($e->getMessage(), 'Could not connect to Stripe')) {
        $errorMessage = 'Could not connect to payment service. Please try again later.';
        Log::error($errorMessage);
        return $errorMessage;
    }

    // إذا كان هناك خطأ عام
    Log::error("Unexpected payment error: " . $e->getMessage());
    return 'An unexpected error occurred during payment processing.';
}

}