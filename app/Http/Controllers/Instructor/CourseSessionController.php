<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $data = $request->validate([
            'course_id'     => 'required|exists:courses,id',
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'start_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if (\Carbon\Carbon::parse($value)->lt(now())) {
                        $fail('The start date must not be in the past.');
                    }
                }
            ],
            'end_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $start = \Carbon\Carbon::parse($request->start_date);
                    $end = \Carbon\Carbon::parse($value);
        
                    if ($end->lt(now())) {
                        $fail('The end date must not be in the past.');
                    }
        
                    if ($end->lte($start)) {
                        $fail('The end date must be after the start date.');
                    }
                }
            ],
        
            'duration'      => 'required|integer|min:1',
            'session_mode'  => 'required|in:online,offline',
            'max_seats'     => 'required|integer|min:1|max:100',
        ]);
    
        $data['user_id'] = Auth::id();
    
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
    
        return redirect()->route('instructor.course_sessions.index')->with('success', 'Session created successfully!');
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
