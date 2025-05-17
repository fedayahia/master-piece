<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Course;
use App\Models\PrivateSession;


class MessageController extends Controller
{

    public function index()
    {
        $authUser = Auth::user();  
        $courses = collect();  

        if ($authUser->role === 'parent') {

            $courseBookings = Booking::where('user_id', $authUser->id)
                ->where('booking_for_type', 'Course')
                ->pluck('booking_for_id'); 

            $sessionBookings = Booking::where('user_id', $authUser->id)
                ->where('booking_for_type', 'PrivateSession')
                ->pluck('booking_for_id'); 

            $courses = Course::whereIn('id', $courseBookings)->get();

            $courseInstructorIds = Course::whereIn('id', $courseBookings)
                ->pluck('instructor_id');
            $sessionInstructorIds = PrivateSession::whereIn('id', $sessionBookings)
                ->pluck('instructor_id');

            $instructorIds = $courseInstructorIds->merge($sessionInstructorIds)->unique();

            $users = User::whereIn('id', $instructorIds)
                ->where('role', 'instructor')
                ->get();

        } elseif ($authUser->role === 'instructor') {
            $courseIds = Course::where('instructor_id', $authUser->id)->pluck('id');
            $sessionIds = PrivateSession::where('instructor_id', $authUser->id)->pluck('id');

            $parentIdsFromCourses = Booking::where('booking_for_type', 'Course')
                ->whereIn('booking_for_id', $courseIds)
                ->pluck('user_id');

            $parentIdsFromSessions = Booking::where('booking_for_type', 'PrivateSession')
                ->whereIn('booking_for_id', $sessionIds)
                ->pluck('user_id');

            $parentIds = $parentIdsFromCourses->merge($parentIdsFromSessions)->unique();

            $users = User::whereIn('id', $parentIds)
                ->where('role', 'parent')
                ->get();

            $courses = Course::whereIn('id', $courseIds)->get();
        } else {
            $users = collect();
        }

        return view('chat.index', compact('users', 'courses', 'authUser'));
    }
public function show($userId)
{
    $receiver = User::findOrFail($userId);

    Message::where('sender_id', $userId)
        ->where('receiver_id', Auth::id())
        ->where('is_read', false)
        ->update(['is_read' => true]);

    $messages = Message::where(function ($query) use ($userId) {
        $query->where('sender_id', Auth::id())->where('receiver_id', $userId);
    })->orWhere(function ($query) use ($userId) {
        $query->where('sender_id', $userId)->where('receiver_id', Auth::id());
    })->orderBy('created_at')->get();

    return view('chat.chatbox', compact('receiver', 'messages'));
}

public function store(Request $request)
{
    $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'message' => 'nullable|string|max:1000',
        'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,jpeg|max:10240',
    ]);

    $filePath = null;

    if ($request->hasFile('file')) {
        $filePath = $request->file('file')->store('chat_files', 'public');
    }

    if (!$request->message && !$filePath) {
        return back()->withErrors(['message' => 'Please enter a message or attach a file.']);
    }

    Message::create([
        'sender_id' => Auth::id(),
        'receiver_id' => $request->receiver_id,
        'message' => $request->message ?? '',
        'course_id' => $request->course_id,
        'file_path' => $filePath,
    ]);

    return back();
}

public function groupChat(Course $course)
{
    $authUser = Auth::user();

    $isEnrolled = Booking::where('user_id', $authUser->id)
        ->where('booking_for_type', 'Course')
        ->where('booking_for_id', $course->id)
        ->exists();

    if (!$isEnrolled && $authUser->id !== $course->instructor_id) {
        abort(403, 'Unauthorized');
    }

    $messages = Message::where('course_id', $course->id)
    ->whereNull('receiver_id')
    ->with('sender')
    ->orderBy('created_at', 'asc')
    ->get();


    return view('chat.group', compact('course', 'messages'));
}


public function sendGroupMessage(Request $request, $courseId)
{
    $request->validate([
        'message' => 'nullable|string|max:1000',
        'file' => 'nullable|file|mimes:pdf|max:10240',
    ]);

    if (!$request->message && !$request->hasFile('file')) {
        return back()->withErrors(['message' => 'Please enter a message or attach a PDF.']);
    }

    $filePath = null;

    if ($request->hasFile('file')) {
        $filePath = $request->file('file')->store('chat_files', 'public');
    }

    Message::create([
        'sender_id' => Auth::id(),
        'course_id' => $courseId,
        'message' => $request->message ?? '',
        'receiver_id' => null,
        'file_path' => $filePath,
    ]);

    return redirect()->route('chat.group', $courseId)->with('success', 'Message sent');
}






    
    }
