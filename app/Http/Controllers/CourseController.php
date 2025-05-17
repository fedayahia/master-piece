<?php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\CourseSe;



class CourseController extends Controller
{

    public function index(Request $request)
{
    $query = Course::with('instructor');

    $categories = [
        'Newborn Care',
        'Child Safety',
        'Sleep Training',
        'Breastfeeding',
        'Parenting Skills',
        'General Parenting',
        'Prenatal Care',
        'Mental & Emotional Health',
        'Parent-Child Relationship',
        'Child Healthcare'
    ];
    
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
    $course = Course::with(['sessions' => function ($query) {
        $query->withCount('bookings');
    }])->findOrFail($id);

    $hasBooking = Booking::where('user_id', auth()->id())
        ->where('booking_for_type', 'Course') 
        ->where('booking_for_id', $id)
        ->exists();

    if (!$hasBooking) {
        $course->setRelation('sessions', $course->sessions->take(1));
    }

    return view('courses.show', compact('course'));
}


public function bookCourse(Request $request, $course_id) {
    $course = Course::findOrFail($course_id);
    
    if($course->seats_available <= 0) {
        return back()->with('error', 'No seats available for this course');
    }

    // $booking = Booking::create([
    //     'user_id' => auth()->id(),
    //     'booking_for_type' => 'App\Models\Course', 
    //     'booking_for_id' => $course_id,
    //     'status' => 'pending_payment',
    //     'booking_date' => now(),
    // ]);

    session()->put('current_booking_id', $booking->id);
    session()->put('course_id', $course_id);
    session()->put('course_title', $course->title);
    session()->put('course_price', $course->price);



    return redirect()->route('checkout.billing');
}
}
