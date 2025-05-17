<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\PrivateSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrivateSessionController extends Controller
{
    // Display all private sessions for the current instructor
    public function index()
    {
        $privateSessions = PrivateSession::where('instructor_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('instructor.private-sessions.index', compact('privateSessions'));
    }

    // Show the form to create a new private session
    public function create()
    {
        return view('instructor.private-sessions.create');
    }

    // Store the newly created private session
  
public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'duration' => 'required|integer|min:15',
        'price' => 'required|numeric|min:0',
        'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'description' => 'required|string',
        'is_online' => 'nullable|boolean',
    ]);

    $imageName = null;
    if ($request->hasFile('img')) {
        $imageName = time().'_'.$request->file('img')->getClientOriginalName();
        $request->file('img')->storeAs('private_sessions', $imageName, 'public');
    }

    PrivateSession::create([
        'title' => $validated['title'],
        'duration' => $validated['duration'],
        'price' => $validated['price'],
        'description' => $validated['description'],
        'img' => $imageName,
        'instructor_id' => Auth::id(),
        'is_online' => $request->has('is_online'),
    ]);

    return redirect()->route('instructor.private-sessions.index')
        ->with('success', 'Session created successfully.');
}

    // Show the details of a specific private session
    public function show(PrivateSession $privateSession)
    {
        $this->authorize('view', $privateSession);
        return view('instructor.private-sessions.show', compact('privateSession'));
    }

    // Show the form to edit an existing private session
    public function edit(PrivateSession $privateSession)
    {
        $this->authorize('update', $privateSession);
        return view('instructor.private-sessions.edit', compact('privateSession'));
    }

    // Update the specified private session
    public function update(Request $request, PrivateSession $privateSession)
    {
        $this->authorize('update', $privateSession);
    
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:15',
            'price' => 'required|numeric|min:0',
            'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'required|string',
            'is_online' => 'nullable|boolean',
        ]);
    
        if ($request->hasFile('img')) {
            if ($privateSession->img) {
                Storage::disk('public')->delete('private_sessions/'.$privateSession->img);
            }
    
            $imageName = time().'_'.$request->file('img')->getClientOriginalName();
            $request->file('img')->storeAs('private_sessions', $imageName, 'public');
            $validated['img'] = $imageName;
        }
    
        $validated['is_online'] = $request->has('is_online');
    
        $privateSession->update($validated);
    
        return redirect()->route('instructor.private-sessions.index')
            ->with('success', 'Session updated successfully.');
    }
    
    // Delete the specified private session
    public function destroy(PrivateSession $privateSession)
    {
        $this->authorize('delete', $privateSession);

        // Delete associated image
        if ($privateSession->img) {
            Storage::disk('public')->delete('private_sessions/'.$privateSession->img);
        }

        $privateSession->delete();

        return redirect()->route('instructor.private-sessions.index')
            ->with('success', 'Session deleted successfully.');
    }
}