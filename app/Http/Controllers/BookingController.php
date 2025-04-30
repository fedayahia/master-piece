<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Course;
use App\Models\PrivateSession;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['bookingFor'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function create($course_id)
    {
        $course = Course::findOrFail($course_id);
        return view('courses.show', compact('course'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'nullable|exists:courses,id',
            'session_id' => 'nullable|exists:private_sessions,id',
            'available_time_id' => 'nullable|exists:available_times,id', 
        ]);
    
        if ($request->course_id) {
            $course = Course::findOrFail($request->course_id);
    
            if ($course->seats_available <= 0) {
                return back()->with('error', 'No available seats for this course.');
            }
    
            session([
                'booking_for_type' => 'course',
                'booking_for_id' => $course->id,
                'item_title' => $course->title,
                'item_price' => $course->price,
            ]);
        }
    
        if ($request->session_id) {
            $session = PrivateSession::findOrFail($request->session_id);
    
            session([
                'booking_for_type' => 'private',
                'booking_for_id' => $session->id,
                'item_title' => $session->title,
                'item_price' => $session->price,
            ]);
        }
    
        if ($request->available_time_id) {
            session(['available_time_id' => $request->available_time_id]);
        }
    
        $paymentSuccessful = $this->processPayment($request);
    
        if ($paymentSuccessful) {
            $type = session('booking_for_type');
            $id = session('booking_for_id');
            $availableTimeId = session('available_time_id'); 
    
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'course_id' => $type === 'course' ? $id : null,
                'session_id' => $type === 'private' ? $id : null,
                'booking_for_type' => $type,
                'booking_for_id' => $id,
                'seat_number' => 'SEAT-' . rand(1000, 9999),
                'status' => 'enrolled',
                'booking_date' => now(),
                'available_time_id' => $availableTimeId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            if ($type === 'course') {
                $course = Course::find($id);
                if ($course) {
                    $course->decrement('seats_available');
                }
            }
    
            return redirect()->route('booking.success', ['booking_id' => $booking->id])
                ->with('success', 'Booking successful!');
        }
    
        return back()->with('error', 'Payment failed, please try again.');
    }
    

    private function processPayment(Request $request)
    {
        
        return true; 
    }
}
