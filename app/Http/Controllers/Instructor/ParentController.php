<?php
namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
    public function parentCourses()
    {
        $instructorId = Auth::id();
        
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
        $coursesCount = $bookings->where('item_type', 'Course')->pluck('item_title')->unique()->count();
        $sessionsCount = $bookings->where('item_type', 'Private Session')->pluck('item_title')->unique()->count();

        $courseBookings = $bookings->where('item_type', 'Course')->groupBy('item_title');
        $sessionBookings = $bookings->where('item_type', 'Private Session')->groupBy('item_title');

        return view('instructor.parents.index', [
            'totalParents' => $totalParents,
            'coursesCount' => $coursesCount,
            'sessionsCount' => $sessionsCount,
            'courseBookings' => $courseBookings,
            'sessionBookings' => $sessionBookings,
            'allBookings' => $bookings
        ]);
    }
}
