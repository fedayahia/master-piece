<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseSessionController extends Controller
{
    public function index()
    {
        $sessions = CourseSession::with('course')
            ->where('user_id', Auth::id())
            ->get();

        return view('instructor.course_sessions.index', compact('sessions'));
    }

    public function create()
    {
        $courses = Course::where('instructor_id', Auth::id())->get();
        return view('instructor.course_sessions.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'duration' => 'required|integer',
            'session_mode' => 'required|in:online,offline',
            'max_seats' => 'required|integer|min:1',
        ]);

        CourseSession::create([
            'course_id' => $request->course_id,
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'duration' => $request->duration,
            'session_mode' => $request->session_mode,
            'max_seats' => $request->max_seats,
        ]);

        return redirect()->route('instructor.course_sessions.index')->with('success', 'Session created successfully.');
    }

    public function edit($id)
    {
        $session = CourseSession::where('user_id', Auth::id())->findOrFail($id);
        $courses = Course::where('instructor_id', Auth::id())->get();
        return view('instructor.course_sessions.edit', compact('session', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'duration' => 'required|integer',
            'session_mode' => 'required|in:online,offline',
            'max_seats' => 'required|integer|min:1',
        ]);

        $session = CourseSession::where('user_id', Auth::id())->findOrFail($id);

        $session->update($request->all());

        return redirect()->route('instructor.course_sessions.index')->with('success', 'Session updated successfully.');
    }

    public function destroy($id)
    {
        $session = CourseSession::where('user_id', Auth::id())->findOrFail($id);
        $session->delete();

        return redirect()->route('instructor.course_sessions.index')->with('success', 'Session deleted successfully.');
    }

    public function show($id)
    {
        $session = CourseSession::with('course')->where('user_id', Auth::id())->findOrFail($id);
        return view('instructor.course_sessions.show', compact('session'));
    }
}
