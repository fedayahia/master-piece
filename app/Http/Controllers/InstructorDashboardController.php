<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Review;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

use App\Models\CourseSession;


use Illuminate\Support\Facades\Auth;

class InstructorDashboardController extends Controller
{
    public function index()
    {
        $instructor = Auth::user();
        
        $courses = Course::where('instructor_id', $instructor->id)
            ->withCount(['bookings as students_count' => function($query) {
                $query->where('status', 'enrolled');
            }])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->get();
        
        $totalStudents = $courses->sum('students_count');
        $totalCourses = $courses->count();
        $avgRating = $courses->avg('reviews_avg_rating') ?? 0;
        $totalReviews = $courses->sum('reviews_count');
    
        $latestPrivateBookings = DB::table('bookings as b')
            ->join('users as u', 'b.user_id', '=', 'u.id')
            ->join('available_times as at', 'b.available_time_id', '=', 'at.id')
            ->join('private_sessions as ps', 'at.private_session_id', '=', 'ps.id')
            ->where('b.booking_for_type', 'App\\Models\\PrivateSession')
            ->where('ps.instructor_id', $instructor->id)
            ->select(
                'u.name as student_name',
                'ps.title as session_title',
                'at.available_date as selected_time',
                'ps.duration'
            )
            ->orderByDesc('b.booking_date')
            ->limit(10)
            ->get();
        
        $topCourses = $courses->sortByDesc('students_count')
            ->take(5)
            ->map(function($course) {
                return (object)[
                    'title' => $course->title,
                    'students_count' => $course->students_count,
                    'avg_rating' => $course->reviews_avg_rating ?? 0,
                    'is_published' => $course->seats_available > 0,
                ];
            });
        
        $parentIds = \DB::select("
            SELECT DISTINCT u.id
            FROM bookings b
            JOIN users u ON b.user_id = u.id
            LEFT JOIN courses c ON b.booking_for_type = 'course' AND b.booking_for_id = c.id
            LEFT JOIN private_sessions ps ON b.booking_for_type = 'PrivateSession' AND b.booking_for_id = ps.id
            WHERE b.status = 'enrolled'
                AND u.role = 'parent'
                AND (
                    (b.booking_for_type = 'course' AND c.instructor_id = ?)
                    OR
                    (b.booking_for_type = 'PrivateSession' AND ps.instructor_id = ?)
                )
        ", [$instructor->id, $instructor->id]);
        
        $parentsCount = count($parentIds); 
        
        return view('instructor.dashboard', [
            'totalStudents' => $totalStudents,
            'totalCourses' => $totalCourses,
            'avgRating' => round($avgRating, 1),
            'totalReviews' => $totalReviews,
            'topCourses' => $topCourses,
            'parentsCount' => $parentsCount, 
            'latestPrivateBookings' => $latestPrivateBookings,
        ]);
    }
    
    

    public function showDashboard()
    {
        $instructor = Auth::user();
    
        $parentsCount = User::where('role', 'parent')->count();
    
        $studentsCount = Booking::where('status', 'enrolled')
                                ->whereIn('booking_for_type', ['App\Models\Course', 'App\Models\PrivateSession'])
                                ->count();
    
        $coursesCount = Course::count();    
        $averageRating = Review::avg('rating');  
    
        $latestSessions = Booking::where('user_id', auth()->id())
        ->whereIn('booking_for_type', ['App\Models\Course', 'App\Models\PrivateSession'])
        ->with('availableTime') 
        ->latest()
        ->limit(5)
        ->get();
    
        $latestPrivateBookings = DB::table('bookings as b')
        ->join('users as u', 'b.user_id', '=', 'u.id')
        ->join('available_times as at', 'b.available_time_id', '=', 'at.id')
        ->join('private_sessions as ps', 'at.private_session_id', '=', 'ps.id')
        ->where('b.booking_for_type', 'PrivateSession')
        ->where('ps.instructor_id', $instructor->id) 
        ->select(
            'u.name as student_name',
            'ps.title as session_title',
            'at.available_date as selected_time',
            'ps.duration'
        )
        ->orderByDesc('b.booking_date')
        ->get();
    
        return view('instructor.dashboard', compact('studentsCount', 'coursesCount', 'averageRating', 'latestSessions', 'parentsCount', 'latestPrivateBookings'));
    }
    

}
