<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InstructorController extends Controller
{
    public function index()
    {
        $courses = Course::where('instructor_id', auth()->id())->get();
        return view('instructor.courses.index', compact('courses'));
    }

    public function showEnrolledStudents($courseId)
    {
        $course = Course::findOrFail($courseId);

        if ($course->instructor_id != auth()->id()) {
            return redirect()->back()->with('error', 'You are not authorized to view this course.');
        }

        $students = Booking::where('course_id', $courseId)
                           ->where('status', 'enrolled')  
                           ->with('user') 
                           ->get();

        return view('instructor.students', compact('course', 'students'));
    }
}
