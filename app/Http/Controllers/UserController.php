<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Models\PrivateSession;




class UserController extends Controller
{
  
    public function show()
    {
        $user = Auth::user();
        
        $bookings = $user->bookings()->with('bookingable')->get();
        
        $bookedItems = $bookings->map(function ($booking) {
            $bookingItem = $booking->bookingable;
        
            if ($bookingItem) {
                if ($bookingItem instanceof \App\Models\PrivateSession) {
                    $bookingItem->type = 'Private Session';
                    
                    $availableTime = $bookingItem->availableTimes()->first();
                    if ($availableTime) {
                        $bookingItem->selected_time = $availableTime->available_date;
                    }
                } elseif ($bookingItem instanceof \App\Models\Course) {
                    $bookingItem->type = 'Course';
                    
                    $upcomingSession = $bookingItem->sessions()
                        ->where('start_date', '>', now()) 
                        ->orderBy('start_date', 'asc') 
                        ->first();
                    
                    if ($upcomingSession) {
                        $bookingItem->selected_time = $upcomingSession->start_date;
                        $bookingItem->session_title = $upcomingSession->title;
                    }
                }
            }
        
            return $bookingItem;
        })->filter();
        
        return view('profile', [
            'user' => $user,
            'bookedItems' => $bookedItems
        ]);
    }
    
    
    
    
    
    
    

    public function edit()
    {
        $user = Auth::user();
        return view('edit', compact('user'));
    }

    // تحديث البيانات
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:25',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        $user = Auth::user();
    
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_images', 'public');
            $user->image = $imagePath;
        }
        
        $user->save();
    
        return redirect()->route('user.profile')->with('success', 'The profile has been updated successfully.');
    }
    
    
    public function team()
    {
        $privateSessions = PrivateSession::with('user')->latest()->take(6)->get(); 

        $users = User::where('role', 'instructor')->get();
        
        $courses = Course::orderBy('created_at', 'desc')->take(3)->get();
        
        $reviews = Review::with('user', 'course')->get();
    
        return view('home', compact('users', 'courses', 'reviews','privateSessions'));
    }
    
    
    // app/Models/User.php

    public function courseReviews()
    {
        return $this->hasManyThrough(
            \App\Models\Review::class,
            \App\Models\Course::class,
            'instructor_id', // Foreign key on courses table
            'course_id',     // Foreign key on reviews table
            'id',            // Local key on users table
            'id'             // Local key on courses table
        );
    }   

}

