<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\CourseSession;
use App\Models\Booking;
use App\Models\Attendance;
use App\Models\Payment;
use App\Models\Review;
use App\Models\PrivateSession;
use App\Models\Event;  // استيراد موديل الـ Event
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('reviews')->truncate();
        DB::table('payments')->truncate();
        DB::table('bookings')->truncate();
        DB::table('course_sessions')->truncate();
        DB::table('lessons')->truncate();
        DB::table('courses')->truncate();
        DB::table('users')->truncate();
        DB::table('private_sessions')->truncate();
        DB::table('events')->truncate();  // إضافة الترايك لأحداث الـ Events

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // USERS
        $instructors = [];
        for ($i = 1; $i <= 2; $i++) {
            $instructors[] = User::create([
                'name' => "Instructor $i",
                'email' => "instructor$i@example.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'instructor',
            ]);
        }

        $parents = [];
        for ($i = 1; $i <= 3; $i++) {
            $parents[] = User::create([
                'name' => "Parent $i",
                'email' => "parent$i@example.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'parent',
            ]);
        }

        User::create([
            'name' => "Admin User",
            'email' => "admin@example.com",
            'email_verified_at' => now(),
            'password' => Hash::make('adminpass'),
            'role' => 'admin',
        ]);

        // COURSES
        $courses = [];
        foreach ($instructors as $index => $instructor) {
            $courses[] = Course::create([
                'title' => "Course " . ($index + 1),
                'description' => "Course " . ($index + 1) . " description",
                'price' => 100 + $index * 20,
                'duration' => 5 + $index,
                'instructor_id' => $instructor->id,
            ]);
        }

        // LESSONS
        foreach ($courses as $course) {
            for ($i = 1; $i <= 2; $i++) {
                Lesson::create([
                    'course_id' => $course->id,
                    'title' => "Lesson $i for Course {$course->id}",
                    'content' => "This is the content of lesson $i.",
                ]);
            }
        }

        // COURSE SESSIONS
        $sessions = [];
        foreach ($courses as $course) {
            $mode = rand(0, 1) ? 'online' : 'offline';
            $start = Carbon::now()->addDays(rand(1, 10))->setTime(rand(9, 14), 0);
            $end = (clone $start)->addMinutes(90);

            $sessions[] = CourseSession::create([
                'course_id'    => $course->id,
                'user_id'      => $course->instructor_id,
                'title'        => "Session for {$course->title}",
                'description'  => "This is a detailed session for course {$course->id}",
                'start_date'   => $start,
                'end_date'     => $end,
                'duration'     => 90,
                'session_mode' => $mode,
                'max_seats'    => $mode === 'offline' ? rand(10, 30) : 99,
            ]);
        }

        // BOOKINGS (Polymorphic)
        $bookings = [];
        foreach ($sessions as $session) {
            foreach ($parents as $parent) {
                $status = rand(1, 100) <= 70 ? 'enrolled' : 'not_enrolled';
                $bookings[] = Booking::create([
                    'user_id'          => $parent->id,
                    'booking_for_type' => 'Course',
                    'booking_for_id'   => $session->course_id,
                    'status'           => $status,
                ]);
            }
        }


        // PAYMENTS (Polymorphic)
        foreach ($bookings as $booking) {
            if ($booking->status === 'enrolled') {
                Payment::create([
                    'booking_id'     => $booking->id,
                    'amount'         => 100,
                    'user_id'        => $booking->user_id,
                    'method'         => 'credit_card',
                    'status'         => 'completed',
                    'transaction_id' => 'TXN' . uniqid(),
                    'payment_for_type' => 'Course',
                    'payment_for_id'   => $booking->booking_for_id,
                    'payment_date'   => now(),
                ]);
            }
        }

        // REVIEWS
        foreach ($courses as $course) {
            foreach ($parents as $parent) {
                Review::create([
                    'course_id' => $course->id,
                    'user_id'   => $parent->id,
                    'rating'    => rand(3, 5),
                    'comment'   => 'Great course!',
                ]);
            }
        }

        // PRIVATE SESSIONS (Polymorphic)
        foreach ($courses as $index => $course) {
            $privateSession = PrivateSession::create([
                'instructor_id' => $course->instructor_id,
                'title'         => "Private Session for " . $course->title,
                'description'   => "Private session description for " . $course->title,
                'duration'      => 60,
                'price'         => 150.00,
            ]);

            Booking::create([
                'user_id'          => $parents[0]->id, 
                'booking_for_type' => 'private_session',
                'booking_for_id'   => $privateSession->id,
                'status'           => 'enrolled',
            ]);
        }

        // EVENTS 
        $events = [];
        for ($i = 1; $i <= 3; $i++) {
            $events[] = Event::create([
                'title' => "Free Event " . $i,
                'description' => "Description for Free Event $i",
                'event_date' => Carbon::now()->addDays(rand(1, 7))->toDateString(),
                'start_time' => '10:00:00',
                'end_time' => '12:00:00',
                'location' => "Online",
                'is_free' => true,
            ]);
        }
    }
}
