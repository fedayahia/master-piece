<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\PrivateSession;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Carbon\Carbon;
use App\Models\AvailableTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;



class PrivateSessionController extends Controller
{
    public function index()
    {
        $sessions = PrivateSession::with('instructor')
                    ->latest()
                    ->paginate(3);
    
        return view('private_sessions', compact('sessions'));
    }
    

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'instructor_id' => 'required|exists:users,id',
    //         'session_id' => 'required|exists:private_sessions,id',
    //         'price' => 'required|numeric',
    //         'session_date' => 'required|date|after:now'
    //     ]);
    
    //     try {
    //         // Create temporary booking in session
    //         $session = PrivateSession::find($request->session_id);
            
    //         session([
    //             'current_booking' => [
    //                 'type' => 'private',
    //                 'session_id' => $session->id,
    //                 'instructor_id' => $request->instructor_id,
    //                 'price' => $session->price,
    //                 'session_date' => $request->session_date,
    //                 'user_id' => auth()->id()
    //             ]
    //         ]);
    
    //         // Mark the time slot as booked
    //         AvailableTime::where('session_id', $session->id)
    //                     ->where('available_date', $request->session_date)
    //                     ->update(['is_available' => false]);
    
    //         return redirect()->route('checkout');
    
    //     } catch (\Exception $e) {
    //         Log::error('Booking failed: '.$e->getMessage());
    //         return back()->with('error', 'Booking failed. Please try again.');
    //     }
    // }


//     public function showSessionBooking($sessionId)
// {
//     $session = PrivateSession::findOrFail($sessionId);
    
//     $availableSlots = AvailableTime::where('session_id', $sessionId)
//                    ->where('is_available', true)
//                    ->get()
//                    ->map(function ($slot) {
//                        return [
//                            'datetime' => $slot->available_date,
//                            'display' => Carbon::parse($slot->available_date)->format('l, F j, Y h:i A')
//                        ];
//                    });

//     return view('session.booking', compact('session', 'availableSlots'));
// }

public function showBookingForm($sessionId) {
    $session = PrivateSession::findOrFail($sessionId);
    
    $availableSlots = AvailableTime::where('private_session_id', $sessionId)
                   ->where('is_available', true)
                   ->get()
                   ->map(function ($slot) use ($session) {
                       return [
                           'id' => $slot->id,
                           'datetime' => $slot->available_date,
                           'end_time' => Carbon::parse($slot->available_date)
                                             ->addMinutes($session->duration)
                                             ->format('h:i A'),
                           'is_available' => $slot->is_available
                       ];
                   });

                   return view('private-sessions.booking', compact('session', 'availableSlots'));

}
    
    

    // public function showBilling()
    // {
    //     $bookingData = session('current_booking');
        
    //     if (!$bookingData || !isset($bookingData['step_completed'])) {
    //         return redirect()->route('private-sessions.index')
    //                ->with('error', 'Please complete the booking form first');
    //     }
    
    //     $session = PrivateSession::findOrFail($bookingData['session_id']);
    
    //     return view('checkout.billing', [
    //         'booking' => (object)$bookingData,
    //         'session' => $session
    //     ]);
    // }
    

    // private function generateAvailableSlots($session)
    // {
    //     $query = AvailableTime::where('private_session_id', $session->id);
        
    //     // Only add this condition if column exists
    //     if (Schema::hasColumn('available_times', 'is_available')) {
    //         $query->where('is_available', true);
    //     }
    
    //     return $query->get()
    //                 ->map(function ($slot) use ($session) {
    //                     return [
    //                         'datetime' => $slot->available_date,
    //                         'display' => Carbon::parse($slot->available_date)
    //                                          ->format('l, F j, Y h:i A'),
    //                         'end_time' => Carbon::parse($slot->available_date)
    //                                          ->addMinutes($session->duration)
    //                                          ->format('h:i A')
    //                     ];
    //                 });
    // }

//     public function processBooking(Request $request)
// {
//     $validated = $request->validate([
//         'instructor_id' => 'required|exists:users,id',
//         'session_id' => 'required|exists:private_sessions,id',
//         'price' => 'required|numeric',
//         'session_date' => 'required|date|after:now'
//     ]);

//     try {
//         $session = PrivateSession::find($validated['session_id']);

//         // Save booking data in session with step completion marker
//         session([
//             'current_booking' => [
//                 'type' => 'private',
//                 'session_id' => $session->id,
//                 'instructor_id' => $session->instructor_id,
//                 'price' => $session->price,
//                 'session_date' => $validated['session_date'],
//                 'duration' => $session->duration,
//                 'user_id' => auth()->id(),
//                 'step_completed' => true // Add this flag
//             ]
//         ]);

//         return redirect()->route('checkout.billing', [
//             'type' => 'private',
//             'item_id' => $session->id
//         ]);

//     } catch (\Exception $e) {
//         Log::error('Booking failed: ' . $e->getMessage());
//         return back()->with('error', 'Booking failed. Please try again.');
//     }
// }
//     private function isSlotAvailable($sessionId, $requestedTime)
//     {
//         $session = PrivateSession::find($sessionId);
//         $requestedDateTime = Carbon::parse($requestedTime);
        
//         // Add your actual availability logic here
//         return $requestedDateTime->greaterThan(now());
//     }


 
//     public function showPaymentForm()
//     {
//         if (!session('current_booking.id')) {
//             return redirect()->route('private-sessions.index')
//                    ->with('error', 'No booking found. Please start a new booking.');
//         }

//         $bookingData = session('current_booking');
//         $session = PrivateSession::findOrFail($bookingData['session_id']);

//         return view('private-sessions.payment', [
//             'booking' => (object)$bookingData,
//             'session' => $session,
//             'stripeKey' => config('services.stripe.key')
//         ]);
//     }
    public function storeSelectedTime(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:private_sessions,id',
            'available_time_id' => 'required|exists:available_times,id',
        ]);
    
        $timeSlot = AvailableTime::findOrFail($validated['available_time_id']);
        $selectedDate = Carbon::parse($timeSlot->available_date)->toDateString();
    
        $duplicateBooking = DB::table('bookings')
            ->join('available_times', 'bookings.available_time_id', '=', 'available_times.id')
            ->where('bookings.booking_for_id', $validated['session_id'])
            ->where('bookings.booking_for_type', 'PrivateSession') 
            ->where('bookings.user_id', auth()->id())
            ->whereDate('available_times.available_date', $selectedDate)
            ->exists();
    
        if ($duplicateBooking) {
            return back()->with('error', 'You pre-booked this session on the same day.');
        }
    
        session([
            'current_booking' => [
                'type' => 'private',
                'session_id' => $validated['session_id'],
                'available_time_id' => $timeSlot->id,
                'session_date' => $timeSlot->available_date,
                'time_slot_data' => $timeSlot->toArray(),
                'step_completed' => true
            ],
            'booking_type' => 'private'
        ]);
    
        return redirect()->route('checkout.billing', [
            'type' => 'private',
            'item_id' => $validated['session_id']
        ]);
    }
    
    // public function processPayment(Request $request)
    // {
    //     $bookingData = session('current_booking');
        
    //     if (!$bookingData) {
    //         return redirect()->route('private-sessions.index')
    //                ->with('error', 'Booking session expired. Please start again.');
    //     }

    //     try {
    //         $session = PrivateSession::findOrFail($bookingData['session_id']);
            
    //         Stripe::setApiKey(config('services.stripe.secret'));

    //         $charge = Charge::create([
    //             'amount' => round($session->price * 100),
    //             'currency' => 'usd',
    //             'source' => $request->stripeToken,
    //             'description' => 'Private Session Booking for ' . $session->title,
    //         ]);

    //         $booking = Booking::create([
    //             'user_id' => auth()->id(),
    //             'bookable_type' => PrivateSession::class,
    //             'bookable_id' => $session->id,
    //             'status' => 'confirmed',
    //             'booking_time' => $bookingData['session_time'],
    //             'special_requests' => $bookingData['special_requests'],
    //             'price' => $session->price,
    //             'payment_status' => 'paid'
    //         ]);

    //         $booking->payment()->create([
    //             'user_id' => auth()->id(),
    //             'amount' => $session->price,
    //             'payment_method' => 'stripe',
    //             'status' => 'completed',
    //             'transaction_id' => $charge->id,
    //             'paid_at' => now(),
    //         ]);

    //         session()->forget('current_booking');

    //         return redirect()->route('private-sessions.confirmation')
    //                ->with('success', 'Your booking has been confirmed!');

    //     } catch (\Exception $e) {
    //         Log::error('Payment failed: '.$e->getMessage(), [
    //             'booking_data' => $bookingData,
    //             'exception' => $e
    //         ]);
            
    //         return back()->with('error', 'Payment failed: ' . $e->getMessage());
    //     }
    // }
}