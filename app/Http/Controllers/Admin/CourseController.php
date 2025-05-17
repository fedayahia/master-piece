<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Course;
use App\Models\User; 
use Illuminate\Http\Request;

class CourseController extends Controller
{



    public function index(Request $request)
    {
        $query = Course::query();
        
        $instructors = User::where('role', 'instructor')->get();
    
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
    
        $courses = $query->paginate(10)->appends($request->query());
    
        return view('admin.courses.index', compact('courses', 'instructors', 'request'));
    }
    
    

    public function show($id)
    {
        $course = Course::findOrFail($id);
        $instructors = User::where('role', 'instructor')->get(); 
    
        return view('admin.courses.show', compact('course', 'instructors'));
    }
    
    

  
    public function create()
    {
        $instructors = User::where('role', 'instructor')->get();  
        return view('admin.courses.create', compact('instructors'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructor_id' => 'required|exists:users,id',
            'price' => 'required|numeric|min:0.01',
            'duration' => 'required|integer|min:1',
            'category' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'seats_available' => 'required|integer|min:0',
            'is_online' => 'nullable|boolean',
        ]);
        
        $validated['is_online'] = $request->has('is_online');
        
        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->store('courses', 'public'); 
            $validated['image'] = basename($imageName); 
        }
        
        Course::create($validated);
        
        session()->flash('success', '✅ Course created successfully!');
        
        return redirect()->route('admin.courses.index');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $instructors = User::where('role', 'instructor')->get(); 
        return view('admin.courses.edit', compact('course', 'instructors'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructor_id' => 'required|exists:users,id',
            'price' => 'required|numeric|min:0.01', 
            'duration' => 'required|integer|min:1',
            'category' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'seats_available' => 'required|integer|min:0',
            'is_online' => 'nullable|boolean',
        ]);
    
        $validated['is_online'] = $request->has('is_online');
        
        $course = Course::findOrFail($id);
    
        if ($request->hasFile('image')) {
            if ($course->image) {
                Storage::delete('public/courses/' . $course->image); 
            }
            $imageName = $request->file('image')->store('courses', 'public');
            $validated['image'] = basename($imageName); 
        }
    
        $course->update($validated);
    
        session()->flash('success', '🔄 Course updated successfully!');
    
        return redirect()->route('admin.courses.index');
    }
    

    
   
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
    
        if ($course->image) {
            Storage::delete('public/' . $course->image);
        }
    
        $course->delete(); 
    
        session()->flash('success', '✅Course soft deleted successfully!');
    
        return redirect()->route('admin.courses.index');
    }
    public function restore($id)
{
    $course = Course::onlyTrashed()->findOrFail($id);
    $course->restore();

    session()->flash('success', '✅ Course restored successfully!');
    return redirect()->route('admin.courses.index');
}

    
}
