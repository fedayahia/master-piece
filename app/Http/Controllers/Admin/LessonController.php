<?php
namespace App\Http\Controllers\Admin;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::with('course')->paginate(10);
    
        return view('admin.lessons.index', compact('lessons'));
    }
    

    public function create()
    {
        $courses = Course::all(); 
        return view('admin.lessons.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'content' => 'required|string',
            'video_url' => 'nullable|url',
        ]);

        $lesson = new Lesson([
            'title' => $request->title,
            'course_id' => $request->course_id,
            'content' => $request->content,
            'video_url' => $request->video_url,
        ]);

        $lesson->save();

        return redirect()->route('admin.lessons.index')->with('success', 'Lesson created successfully');
    }

    public function edit($id)
    {
        $lesson = Lesson::findOrFail($id);
        $courses = Course::all();
        return view('admin.lessons.edit', compact('lesson', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'content' => 'required|string',
            'video_url' => 'nullable|url',
        ]);

        $lesson = Lesson::findOrFail($id);
        $lesson->update([
            'title' => $request->title,
            'course_id' => $request->course_id,
            'content' => $request->content,
            'video_url' => $request->video_url,
        ]);

        return redirect()->route('admin.lessons.index')->with('success', 'Lesson updated successfully');
    }

    public function destroy($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();
        
        return redirect()->route('admin.lessons.index')->with('success', 'Lesson deleted successfully');
    }
}
