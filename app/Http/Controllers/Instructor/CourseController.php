<?php

namespace App\Http\Controllers\Instructor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Course;
use App\Models\User; 
use Illuminate\Http\Request;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{


    public function index(Request $request)
    {
        $query = Course::where('instructor_id', auth()->id());
    
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%'.$searchTerm.'%')
                  ->orWhere('description', 'LIKE', '%'.$searchTerm.'%');
            });
        }
    
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
    
        $courses = $query->paginate(10);
    
        return view('instructor.courses.index', compact('courses'));
    }
    

    public function show($id)
    {
        $course = Course::with(['instructor', 'sessions'])->findOrFail($id);
    
        $session = $course->sessions->first();
    
        return view('instructor.courses.show', compact('course', 'session'));
    }
    
    

  
    public function create()
    {
        $instructors = User::where('role', 'instructor')->get();  
        return view('instructor.courses.create', compact('instructors'));
    }
    public function store(Request $request)
    {
        Log::info('Received request data for creating course', $request->all());
    
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'category' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'seats_available' => 'required|integer|min:0',
        ]);
    
        Log::info('Validation passed for course creation', $validated);
    
        $validated['instructor_id'] = auth()->user()->id;
    
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('courses', 'public');
            $validated['image'] = basename($path);
            Log::info('Image uploaded successfully', ['image_path' => $path]);
        } else {
            Log::info('No image uploaded');
        }
    
        try {
            Course::create($validated);
            Log::info('Course created successfully', ['course_data' => $validated]);
            
            session()->flash('success', '✅ Course created successfully!');
            return redirect()->route('instructor.courses.index');
        } catch (\Exception $e) {
            Log::error('Error creating course', ['error' => $e->getMessage()]);
            session()->flash('error', '❌ Failed to create course. Please try again.');
            return redirect()->route('instructor.courses.index');
        }
    }
    
    public function edit($id)
    {
        $course = Course::where('instructor_id', auth()->user()->id)->findOrFail($id);
        return view('instructor.courses.edit', compact('course'));
    }
    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'category' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'seats_available' => 'required|integer|min:0',
        ]);
    
        $course = Course::where('instructor_id', auth()->user()->id)->findOrFail($id);
    
        if ($request->hasFile('image')) {
            if ($course->image) {
                Storage::delete('public/courses/' . $course->image); 
            }
            $path = $request->file('image')->store('courses', 'public');
            $validated['image'] = basename($path);
        }
    
        $course->update($validated);
    
        session()->flash('success', '🔄 Course updated successfully!');
        return redirect()->route('instructor.courses.index');
    }
    

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
    
        if ($course->image) {
            Storage::delete('public/' . $course->image);
        }
    
        $course->delete();
    
        session()->flash('success', '❌ Course deleted successfully!');
    
        return redirect()->route('instructor.courses.index');
    }




public function students($id)
{
    $course = Course::where('instructor_id', auth()->user()->id)->findOrFail($id);
    $enrollments = $course->enrollments()->with('user')->get();

    return view('instructor.courses.students', compact('course', 'enrollments'));
}

    
}
