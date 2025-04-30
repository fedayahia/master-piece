<?php
namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Review;
use App\Models\Instructor;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $instructor = auth()->user();
        
        $courses = $instructor->managedCourses()
                    ->with(['reviews.user', 'reviews' => function($query) {
                        $query->latest();
                    }])
                    ->get();
        
        $reviews = Review::whereIn('course_id', $courses->pluck('id'))
                    ->with(['user', 'course'])
                    ->latest()
                    ->get();
    
        $courseIds = $courses->pluck('id');
        $totalReviews = Review::whereIn('course_id', $courseIds)->count();
        $averageRating = Review::whereIn('course_id', $courseIds)->avg('rating') ?? 0;
    
        return view('instructor.reviews.index', compact(
            'instructor',
            'courses',
            'reviews',
            'totalReviews',
            'averageRating'
        ));
    }
    
    public function showReviews($instructorId)
    {
        $instructor = Instructor::findOrFail($instructorId);
        
        $courses = $instructor->managedCourses()
                            ->with(['reviews.user', 'reviews' => function($query) {
                                $query->latest();
                            }])
                            ->get();
        
        $reviews = Review::whereIn('course_id', $courses->pluck('id'))
                        ->with(['user', 'course'])
                        ->latest()
                        ->get();
        
        return view('instructor.reviews.index', compact('instructor', 'courses', 'reviews'));
    }
}