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
        // Validate the incoming request data
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:500'
        ]);

        $user = auth()->user();
        $course = Course::find($request->course_id);

        // 1. Ensure the user has booked the course
        if (!$user->bookings()->where('course_id', $course->id)->exists()) {
            return back()->with('error', 'You must book this course before submitting a review.');
        }

        // 2. Prevent the user from reviewing the same course more than once
        if ($user->reviews()->where('course_id', $course->id)->exists()) {
            return back()->with('error', 'You have already reviewed this course.');
        }

        // 3. Ensure all course sessions have ended before allowing a review
        $hasUpcomingSessions = CourseSession::where('course_id', $course->id)
            ->where('end_date', '>', now())
            ->exists();

        if ($hasUpcomingSessions) {
            return back()
                ->with('error', 'You cannot review the course before all sessions have ended.')
                ->withInput();
        }

        // Create the review
        $review = $user->reviews()->create([
            'course_id' => $course->id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        // Update the course's average rating
        $this->updateCourseRating($course);

        return back()
            ->with('success', 'Thank you for reviewing the course!')
            ->with('scroll_to', 'reviews-section');
    }

    protected function updateCourseRating(Course $course)
    {
        // Recalculate and update the average course rating
        $averageRating = Review::avg('rating'); 
        $course->update(['average_rating' => round($averageRating, 1)]);
    }
}
