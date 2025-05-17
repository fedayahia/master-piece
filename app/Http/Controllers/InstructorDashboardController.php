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
{public function index()
    {
        $instructor = Auth::user();
        $instructorId = $instructor->id;
    
        // 1. Get instructor's courses with statistics
        $courses = Course::where('instructor_id', $instructorId)
            ->withCount([
                'bookings as students_count' => function($query) {
                    $query->where('status', 'enrolled');
                }
            ])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->get();
    
        $totalCourses = $courses->count();
    
        // 2. Get reviews statistics for instructor's courses
        $reviewsStats = DB::table('reviews')
            ->join('courses', 'reviews.course_id', '=', 'courses.id')
            ->where('courses.instructor_id', $instructorId)
            ->select(
                DB::raw('COUNT(reviews.id) as my_total_reviews'),
                DB::raw('AVG(reviews.rating) as my_avg_rating')
            )
            ->first();
    
        // 3. Get private sessions statistics
        $privateSessionsStats = DB::table('bookings')
            ->join('private_sessions', 'bookings.booking_for_id', '=', 'private_sessions.id')
            ->where('bookings.booking_for_type', 'App\\Models\\PrivateSession')
            ->where('private_sessions.instructor_id', $instructorId)
            ->where('bookings.status', 'enrolled')
            ->select(DB::raw('COUNT(DISTINCT user_id) as private_students_count'))
            ->first();
    
        // 4. Get parent bookings
        $bookings = DB::select("
            SELECT 
                u.id AS user_id,
                u.name AS user_name,
                u.email AS user_email,
                u.phone_number AS phone,
                u.image,
                b.id AS booking_id,
                b.booking_date,
                CASE 
                    WHEN b.booking_for_type = 'course' THEN c.title
                    WHEN b.booking_for_type = 'PrivateSession' THEN ps.title
                    ELSE 'Unknown'
                END AS item_title,
                CASE 
                    WHEN b.booking_for_type = 'course' THEN 'Course'
                    WHEN b.booking_for_type = 'PrivateSession' THEN 'Private Session'
                    ELSE 'Unknown'
                END AS item_type
            FROM 
                bookings b
            JOIN 
                users u ON b.user_id = u.id 
            LEFT JOIN 
                courses c ON b.booking_for_type = 'course' AND b.booking_for_id = c.id
            LEFT JOIN 
                private_sessions ps ON b.booking_for_type = 'PrivateSession' AND b.booking_for_id = ps.id
            WHERE 
                b.status = 'enrolled'
                AND u.role = 'parent'
                AND (
                    (b.booking_for_type = 'course' AND c.instructor_id = ?)
                    OR
                    (b.booking_for_type = 'PrivateSession' AND ps.instructor_id = ?)
                )
            ORDER BY 
                u.name, b.booking_date DESC
        ", [$instructorId, $instructorId]);
    
        $bookings = collect($bookings);
        $totalParents = $bookings->pluck('user_id')->unique()->count();
    
        // 5. Get latest private bookings
        $latestPrivateBookings = DB::table('bookings as b')
            ->join('users as u', 'b.user_id', '=', 'u.id')
            ->join('available_times as at', 'b.available_time_id', '=', 'at.id')
            ->join('private_sessions as ps', 'at.private_session_id', '=', 'ps.id')
            ->where('b.booking_for_type', 'PrivateSession')
            ->where('ps.instructor_id', $instructorId)
            ->select(
                'u.name as student_name',
                'ps.title as session_title',
                'at.available_date as selected_time',
                'ps.duration'
            )
            ->orderByDesc('b.booking_date')
            ->get();
    
        // 6. Get top courses
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
    
        // 7. Count parents (alternative method)
        $parentsCount = DB::table('bookings as b')
            ->join('users as u', 'b.user_id', '=', 'u.id')
            ->leftJoin('courses as c', function($join) use ($instructorId) {
                $join->on('b.booking_for_type', '=', DB::raw("'course'"))
                     ->on('b.booking_for_id', '=', 'c.id')
                     ->where('c.instructor_id', $instructorId);
            })
            ->leftJoin('private_sessions as ps', function($join) use ($instructorId) {
                $join->on('b.booking_for_type', '=', DB::raw("'PrivateSession'"))
                     ->on('b.booking_for_id', '=', 'ps.id')
                     ->where('ps.instructor_id', $instructorId);
            })
            ->where('b.status', 'enrolled')
            ->where('u.role', 'parent')
            ->where(function($query) {
                $query->whereNotNull('c.id')
                      ->orWhereNotNull('ps.id');
            })
            ->distinct('u.id')
            ->count('u.id');
    
        return view('instructor.dashboard', [
            'totalParents' => $totalParents,
            'totalCourses' => $totalCourses,
            'avgRating' => round($reviewsStats->my_avg_rating ?? 0, 1),
            'totalReviews' => $reviewsStats->my_total_reviews ?? 0,
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
        ->limit(20)
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
