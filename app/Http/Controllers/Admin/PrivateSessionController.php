<?php

namespace App\Http\Controllers\Admin;

use App\Models\PrivateSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class PrivateSessionController extends Controller
{
    public function index()
    {
        $sessions = PrivateSession::all();
        return view('admin.private_sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('admin.private_sessions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'instructor_id' => 'required|exists:users,id',
            'session_date' => 'required|date',
            'duration' => 'required|integer',
            'status' => 'required|in:pending,approved,completed,canceled',
            'description' => 'nullable|string',
            'is_online' => 'nullable|boolean',
        ]);
    
        $data = $request->all();
        $data['is_online'] = $request->has('is_online');
    
        PrivateSession::create($data);
    
        return redirect()->route('admin.private_sessions.index')->with('success', 'Private session created successfully');
    }
    
    public function edit($id)
    {
        $session = PrivateSession::findOrFail($id);
        return view('admin.private_sessions.edit', compact('session'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'instructor_id' => 'required|exists:users,id',
            'session_date' => 'required|date',
            'duration' => 'required|integer',
            'status' => 'required|in:pending,approved,completed,canceled',
            'description' => 'nullable|string',
            'is_online' => 'nullable|boolean',
        ]);
    
        $session = PrivateSession::findOrFail($id);
        $data = $request->all();
        $data['is_online'] = $request->has('is_online');
    
        $session->update($data);
    
        return redirect()->route('admin.private_sessions.index')->with('success', 'Private session updated successfully');
    }

    public function destroy($id)
    {
        $session = PrivateSession::findOrFail($id);
        $session->delete();
        return redirect()->route('admin.private_sessions.index')->with('success', 'Private session deleted successfully');
    }
}