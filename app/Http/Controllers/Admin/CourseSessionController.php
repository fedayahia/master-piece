<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseSession;
use App\Models\Course;
use App\Models\User;

class CourseSessionController extends Controller
{
    public function index(Request $request)
    {
        $query = CourseSession::with(['course', 'instructor']);
    
        // Filter by course title
        if ($request->filled('course_title')) {
            $query->whereHas('course', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->course_title . '%');
            });
        }
    
        $sessions = $query->paginate(10)->appends($request->query());
    
        return view('admin.Course Sessions.index', compact('sessions'));
    }
    
    public function show($id)
    {
        $session = CourseSession::with(['course', 'instructor'])->findOrFail($id);
        return view('admin.course sessions.show', compact('session'));
    }

    public function create()
    {
        $courses = Course::all();
        $instructors = User::where('role', 'instructor')->get();
        return view('admin.Course Sessions.create', compact('courses', 'instructors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'duration' => 'required|integer|min:1',
            'session_mode' => 'required|in:online,offline',
            'max_seats' => 'required|integer|min:1|max:100',
        ]);

        // Check for overlapping sessions
        $overlappingSession = CourseSession::where('course_id', $data['course_id'])
            ->where(function($query) use ($data) {
                $query->whereBetween('start_date', [$data['start_date'], $data['end_date']])
                      ->orWhereBetween('end_date', [$data['start_date'], $data['end_date']]);
            })
            ->exists();

        if ($overlappingSession) {
            return back()->withErrors(['start_date' => 'There is already a session scheduled for this course during this time period.']);
        }

        CourseSession::create($data);

        return redirect()->route('admin.course-sessions.index')->with('success', 'Session created successfully!');
    }

    public function edit($id)
    {
        $courseSession = CourseSession::findOrFail($id);
        $courses = Course::all();
        $instructors = User::where('role', 'instructor')->get();

        return view('admin.Course Sessions.edit', compact('courseSession', 'courses', 'instructors'));
    }

    public function update(Request $request, $id)
    {
        $courseSession = CourseSession::findOrFail($id);

        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'duration' => 'required|integer|min:1',
            'session_mode' => 'required|in:online,offline',
            'max_seats' => 'required|integer|min:1|max:100',
        ]);

        // Check for overlapping sessions excluding current session
        $overlappingSession = CourseSession::where('course_id', $data['course_id'])
            ->where('id', '!=', $id)
            ->where(function($query) use ($data) {
                $query->whereBetween('start_date', [$data['start_date'], $data['end_date']])
                      ->orWhereBetween('end_date', [$data['start_date'], $data['end_date']]);
            })
            ->exists();

        if ($overlappingSession) {
            return back()->withErrors(['start_date' => 'There is already a session scheduled for this course during this time period.']);
        }

        $courseSession->update($data);

        return redirect()->route('admin.course-sessions.index')->with('success', 'Session updated successfully.');
    }

    public function destroy($id)
    {
        $courseSession = CourseSession::findOrFail($id);
        $courseSession->delete();

        return redirect()->route('admin.course-sessions.index')->with('success', 'Session deleted successfully.');
    }
}