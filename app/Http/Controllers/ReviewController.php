<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Course;
use App\Models\CourseSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:500'
        ]);
    
        $user = auth()->user();
        $course = Course::findOrFail($request->course_id);
    
        $hasBooking = $user->bookings()
            ->where('booking_for_type', 'course')
            ->where('booking_for_id', $course->id)
            ->exists();
    
        if (!$hasBooking) {
            return back()->with('error', 'You must book this course before submitting a review.');
        }
    
        $user->reviews()->create([
            'course_id' => $course->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
    
        return back()->with('success', 'Your review has been submitted successfully.');
    }
    

    protected function updateCourseRating(Course $course)
    {
        // Recalculate and update the average course rating
        $averageRating = Review::avg('rating'); 
        $course->update(['average_rating' => round($averageRating, 1)]);
    }
}
