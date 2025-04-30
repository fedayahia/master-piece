<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;

use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    
    public function showCourseStudents($courseId)
    {
        $course = Course::findOrFail($courseId);
    
        if ($course->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    
        $enrollments = Enrollment::with('user')
            ->where('course_id', $courseId)
            ->get();
    
        return view('instructor.courses.students', compact('course', 'enrollments'));
    }
    
}
