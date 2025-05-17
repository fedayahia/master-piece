<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseSession;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Review;
use App\Models\PrivateSession;
use App\Models\Event;
use App\Models\AvailableTime;
use Carbon\Carbon;
use App\Models\ContactMessage;
use App\Models\Message;
use App\Models\Coupon;

class DatabaseSeeder extends Seeder
{
    private function getCourseDetails($title)
    {
        $details = [
            'Newborn Care Essentials' => [
                'description' => "Covers basics like diapering, bathing, feeding, and safety with hands-on training and nurse guidance.",
                'online' => false,
                'classroom' => 'Room 101 - Pediatric Training Center',
                'price' => 150,
                'duration' => 8,
                'category' => 'Newborn Care'
            ],
            'Infant CPR and Safety' => [
                'description' => "Certified course on infant CPR, choking rescue, and first aid, with hands-on practice and a final exam.",
                'online' => false,
                'classroom' => 'Room 205 - Emergency Training Lab',
                'price' => 200,
                'duration' => 6,
                'category' => 'Child Safety'
            ],
            'Baby Sleep Solutions' => [
                'description' => "Practical baby sleep tips with video lessons and weekly live Zoom consultations.",
                'online' => true,
                'classroom' => null,
                'price' => 120,
                'duration' => 4,
                'category' => 'Sleep Training'
            ],
            'Breastfeeding Basics' => [
                'description' => "Complete course with certified consultants on proper breastfeeding and solving common issues.",
                'online' => false,
                'classroom' => 'Room 150 - Maternal Health Wing',
                'price' => 180,
                'duration' => 5,
                'category' => 'Breastfeeding'
            ],
            'Positive Parenting Techniques' => [
                'description' => "Interactive workshop on positive discipline and effective communication with toddlers.",
                'online' => true,
                'classroom' => null,
                'price' => 100,
                'duration' => 6,
                'category' => 'Parenting Skills'
            ]
        ];
    
    
        return $details[$title] ?? [
            'description' => 'Comprehensive parenting course with expert instruction.',
            'online' => rand(0, 1) === 1,
            'classroom' => 'Room ' . rand(100, 300),
            'price' => rand(100, 200),
            'duration' => rand(4, 8),
            'category' => 'General Parenting'
        ];
    }

    private function getPrivateSessionTypes()
    {
        return [
            'Parenting Consultation',
            'Breastfeeding Support',
            'Sleep Training Guidance',
            'Child Nutrition Advice',
            'Behavioral Counseling'
        ];
    }

    private function getPrivateSessionDescription($title)
    {
        $descriptions = [
            'Parenting Consultation' => "One-on-one session to discuss your specific parenting challenges and get personalized advice.",
            'Breastfeeding Support' => "Private consultation with a lactation expert to address your breastfeeding concerns.",
            'Sleep Training Guidance' => "Customized sleep training plan tailored to your child's needs and your parenting style.",
            'Child Nutrition Advice' => "Personalized nutrition consultation for your child with meal planning and dietary recommendations.",
            'Behavioral Counseling' => "Expert guidance on managing challenging behaviors and promoting positive development."
        ];

        return $descriptions[$title] ?? "Private one-on-one session with an expert.";
    }

    private function getRandomLocation()
    {
        $locations = [
            'Room 301 - Consultation Suite',
            'Room 205 - Health Center',
            'Online via Zoom',
            'Room 150 - Family Center'
        ];

        return $locations[array_rand($locations)];
    }

    private function getCourseImage($title)
    {
        $images = [
            'Newborn Care Essentials' => 'newborn_care.jpg',
            'Infant CPR and Safety' => 'cpr_training.jpg',
            'Baby Sleep Solutions' => 'baby_sleep.jpg',
            'Breastfeeding Basics' => 'breastfeeding.jpg',
            'Positive Parenting Techniques' => 'parenting.jpg'
        ];

        return 'images/courses/' . ($images[$title] ?? 'default_course.jpg');
    }

    private function getRandomReviewText($courseTitle)
    {
        $reviews = [
            'Very informative and practical. The instructor was knowledgeable and engaging.',
            'Loved the hands-on approach. I feel much more confident now.',
            'Great course! Would recommend to all new parents.',
            'The online platform worked perfectly. Content was well-organized.',
            'Excellent facilities and teaching materials. Worth every penny!'
        ];

        return "Review for $courseTitle: " . $reviews[array_rand($reviews)];
    }

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Truncate tables
        $tables = [
            'reviews', 'payments', 'bookings', 'course_sessions',
            'courses', 'private_sessions', 'events', 'available_times',
            'contact_us', 'messages', 'coupons', 'users'
        ];
        
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Create Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now()
        ]);
        // Create Instructors
        $instructors = [
            [
                'name' => 'Dr. Sarah Johnson',
                'email' => 's.johnson@example.com',
                'credentials' => 'MD, Pediatric Specialist'
            ],
            [
                'name' => 'Lisa Chen',
                'email' => 'l.chen@example.com',
                'credentials' => 'Certified Lactation Consultant'
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'm.brown@example.com',
                'credentials' => 'Child Psychologist, PhD'
            ]
        ];

        foreach ($instructors as $instructor) {
            User::create([
                'name' => $instructor['name'],
                'email' => $instructor['email'],
                'password' => Hash::make('instructor123'),
                'role' => 'instructor',
                'email_verified_at' => now()
            ]);
        }

        // Create Parents (20 parents)
        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'name' => 'Parent ' . $i,
                'email' => 'parent' . $i . '@example.com',
                'password' => Hash::make('parent123'),
                'role' => 'parent',
                'email_verified_at' => now()
            ]);
        }

        $instructors = User::where('role', 'instructor')->get();
        $parents = User::where('role', 'parent')->get();

        // Create Courses
        $courseTitles = [
            'Newborn Care Essentials',
            'Infant CPR and Safety', 
            'Baby Sleep Solutions',
            'Breastfeeding Basics',
            'Positive Parenting Techniques'
        ];

        $courses = [];
        foreach ($courseTitles as $index => $title) {
            $details = $this->getCourseDetails($title);
            $instructor = $instructors[$index % count($instructors)];
            
            $courses[] = Course::create([
                'title' => $title,
                'description' => $details['description'] . 
                    ($details['online'] ? 
                    "\n\nONLINE COURSE - All sessions conducted via Zoom" :
                    "\n\nIN-PERSON COURSE - Location: " . $details['classroom']),
                'price' => $details['price'],
                'duration' => $details['duration'],
                'instructor_id' => $instructor->id,
                'category' => $details['category'],
                'image' => $this->getCourseImage($title),
                'seats_available' => $details['online'] ? 50 : 15,
                'is_online' => $details['online']
            ]);
        }

        // Create Course Sessions
        foreach ($courses as $course) {
            $sessionType = $course->is_online ? 'online' : 'offline';
            
            // Orientation Session
            CourseSession::create([
                'course_id' => $course->id,
                'user_id' => $course->instructor_id,
                'title' => $course->title . " Orientation",
                'description' => $sessionType === 'online' ?
                    "Live Zoom orientation session" :
                    "In-person orientation at " . $this->getCourseDetails($course->title)['classroom'],
                'start_date' => Carbon::now()->addDays(3),
                'end_date' => Carbon::now()->addDays(20)->addHours(2),
                'duration' => 2,
                'session_mode' => $sessionType,
                'max_seats' => $course->seats_available
            ]);
            
            // Weekly Sessions
            for ($i = 1; $i <= 4; $i++) {
                CourseSession::create([
                    'course_id' => $course->id,
                    'user_id' => $course->instructor_id,
                    'title' => $course->title . " Week " . $i,
                    'description' => $sessionType === 'online' ?
                        "Live interactive online session" :
                        "Hands-on practice session at " . $this->getCourseDetails($course->title)['classroom'],
                    'start_date' => Carbon::now()->addDays(7 + ($i * 7)),
                    'end_date' => Carbon::now()->addDays(7 + ($i * 7))->addHours(1.5),
                    'duration' => 1.5,
                    'session_mode' => $sessionType,
                    'max_seats' => $course->seats_available
                ]);
            }
        }

        // Create Private Sessions
        $privateSessions = [];
        foreach ($instructors as $instructor) {
            for ($i = 0; $i < 2; $i++) { // Each instructor has 2 private sessions
                $title = "Private " . $this->getPrivateSessionTypes()[array_rand($this->getPrivateSessionTypes())];
                $isOnline = rand(0, 1) === 1;
                
                $privateSessions[] = PrivateSession::create([
                    'instructor_id' => $instructor->id,
                    'title' => $title,
                    'description' => $this->getPrivateSessionDescription($title),
                    'duration' => 60,
                    'price' => rand(80, 150),
                ]);
            }
        }

        // Create Available Times for Private Sessions
        foreach ($privateSessions as $session) {
            for ($i = 0; $i < 5; $i++) { // 5 available times per session
                $date = Carbon::now()->addDays(rand(1, 14))->setTime(rand(9, 17), 0);
                
                AvailableTime::create([
                    'private_session_id' => $session->id,
                    'available_date' => $date,
                    'is_available' => true
                ]);
            }
        }

        // Create Bookings for Courses
        foreach ($parents as $parent) {
            $course = $courses[array_rand($courses)];
            
            Booking::create([
                'booking_date' => Carbon::now()->subDays(rand(1, 3)),
                'seat_number' => 'CRS-' . Str::upper(Str::random(6)),
                'status' => 'enrolled',
                'user_id' => $parent->id,
                'booking_for_type' => 'Course',
                'booking_for_id' => $course->id,
                'available_time_id' => null
            ]);
        }

        // Create Bookings for Private Sessions
        foreach ($parents as $parent) {
            $session = $privateSessions[array_rand($privateSessions)];
            $availableTime = $session->availableTimes()
                                  ->where('is_available', true)
                                  ->inRandomOrder()
                                  ->first();

            if ($availableTime) {
                $booking = Booking::create([
                    'booking_date' => Carbon::now(),
                    'seat_number' => 'PRV-' . Str::upper(Str::random(6)),
                    'status' => 'enrolled',
                    'user_id' => $parent->id,
                    'booking_for_type' => 'PrivateSession',
                    'booking_for_id' => $session->id,
                    'available_time_id' => $availableTime->id
                ]);

                $availableTime->update(['is_available' => false]);
            }
        }

        $bookings = Booking::all();

        // Create Payments
        foreach ($bookings as $booking) {
            $amount = $booking->booking_for_type === 'Course' 
                ? Course::find($booking->booking_for_id)->price
                : PrivateSession::find($booking->booking_for_id)->price;
            
            Payment::create([
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
                'method' => ['credit_card', 'paypal'][rand(0, 1)],
                'status' => 'completed',
                'amount' => $amount,
                'transaction_id' => $booking->booking_for_type === 'Course' 
                    ? 'CRS-' . Str::upper(Str::random(8))
                    : 'PRV-' . Str::upper(Str::random(8)),
                'payment_date' => $booking->booking_date,
                'payment_for_type' => $booking->booking_for_type,
                'payment_for_id' => $booking->booking_for_id
            ]);
        }

        // Create Reviews
        foreach ($courses as $course) {
            foreach ($parents->random(5) as $parent) {
                Review::create([
                    'course_id' => $course->id,
                    'user_id' => $parent->id,
                    'rating' => rand(4, 5),
                    'comment' => $this->getRandomReviewText($course->title),
                    'created_at' => Carbon::now()->subDays(rand(1, 30))
                ]);
            }
        }

        // Create Events
        $events = [
            [
                'title' => 'Parenting Workshop: Managing Toddler Tantrums',
                'description' => 'Learn effective strategies to handle tantrums and challenging behaviors',
                'date' => Carbon::now()->addDays(14),
                'location' => 'Main Auditorium'
            ],
            [
                'title' => 'Baby Nutrition Seminar',
                'description' => 'Expert advice on introducing solids and healthy eating habits',
                'date' => Carbon::now()->addDays(21),
                'location' => 'Conference Room B'
            ]
        ];

        foreach ($events as $event) {
            Event::create([
                'title' => $event['title'],
                'description' => $event['description'],
                'event_date' => $event['date'],
                'start_time' => '10:00:00',
                'end_time' => '12:00:00',
                'location' => $event['location'],
                'instructor' => $instructors->random()->name,
                'is_free' => true
            ]);
        }

        // Create Coupon
        Coupon::create([
            'code' => 'FIRSTTIME20',
            'discount_amount' => 20,
            'discount_type' => 'percentage',
            'applicable_id' => $courses[0]->id,
            'applicable_type' => 'App\Models\Course',
        ]);

        // Create Contact Messages
        ContactMessage::create([
            'name' => 'Fatima Ahmed',
            'email' => 'fatima@example.com',
            'phone_number' => '0799123456',
            'message' => 'I have questions about the breastfeeding course schedule.',
            'status' => 'pending'
        ]);

        // Create Messages
        Message::create([
            'sender_id' => $parents[0]->id,
            'receiver_id' => $instructors[0]->id,
            'message' => 'Hello, I need some clarification about the course materials.',
            'is_read' => false,
            'created_at' => Carbon::now()->subHours(2)
        ]);

        Message::create([
            'sender_id' => $instructors[0]->id,
            'receiver_id' => $parents[0]->id,
            'message' => 'Sure, what would you like to know?',
            'is_read' => false,
            'created_at' => Carbon::now()->subHour()
        ]);
    }
}