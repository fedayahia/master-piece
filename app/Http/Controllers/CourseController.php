<?php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function index(Request $request)
{
    $query = Course::with('instructor');

    // Get all unique categories
    $categories = Course::select('category')->distinct()->pluck('category');

    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('category')) {
        $query->whereRaw('LOWER(category) = ?', [strtolower($request->category)]);
    }

    $courses = $query->paginate(2)->withQueryString();

    return view('course', compact('courses', 'categories'));
}

    
    
public function show($id)
{
    $course = Course::with(['instructor', 'sessions' => function($query) {
        $query->withCount(['bookings as bookings_count']);
    }])->findOrFail($id);

    return view('courses.show', compact('course'));
}

public function bookCourse(Request $request, $course_id) {
    $course = Course::findOrFail($course_id);
    
    if($course->seats_available <= 0) {
        return back()->with('error', 'No seats available for this course');
    }

    $booking = Booking::create([
        'user_id' => auth()->id(),
        'booking_for_type' => 'App\Models\Course', // or just 'Course' depending on your setup
        'booking_for_id' => $course_id,
        'status' => 'pending_payment',
        'booking_date' => now(),
    ]);

    session()->put('current_booking_id', $booking->id);
    session()->put('course_id', $course_id);
    session()->put('course_title', $course->title);
    session()->put('course_price', $course->price);

    if($request->has('session_id')) {
        $session = CourseSession::find($request->session_id);
        $booking->update(['session_id' => $session->id]);
        session()->put('session_id', $session->id);
    }

    return redirect()->route('checkout.billing');
}
}
