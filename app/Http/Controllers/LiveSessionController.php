<?php

namespace App\Http\Controllers;

use App\Models\LiveSession;
use Illuminate\Http\Request;

class LiveSessionController extends Controller
{
    /**
     * Display a listing of the live sessions.
     */
    public function index()
    {
        $sessions = LiveSession::latest()->get();
        return view('live_sessions.index', compact('sessions'));
    }

    /**
     * Show the form for creating a new live session.
     */
    public function create()
    {
        return view('live_sessions.create');
    }
    public function join($id)
{
    $session = LiveSession::findOrFail($id);
    $user = auth()->user();

    if (!$session->participants->contains($user->id)) {
        $session->participants()->attach($user->id);
    }

    return redirect()->back()->with('success', 'Session joined successfully');
}


    /**
     * Store a newly created live session in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'meeting_link' => 'required|url',
            'platform' => 'nullable|string',
        ]);

        LiveSession::create($request->all());

        return redirect()->route('live_sessions.index')
                         ->with('success', 'Live session created successfully.');
    }

    /**
     * Display the specified live session.
     */
    public function show(LiveSession $liveSession)
    {
        return view('live_sessions.show', compact('liveSession'));
    }

    /**
     * Show the form for editing the specified live session.
     */
    public function edit(LiveSession $liveSession)
    {
        return view('live_sessions.edit', compact('liveSession'));
    }

    /**
     * Update the specified live session in storage.
     */
    public function update(Request $request, LiveSession $liveSession)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'meeting_link' => 'required|url',
            'platform' => 'nullable|string',
        ]);

        $liveSession->update($request->all());

        return redirect()->route('live_sessions.index')
                         ->with('success', 'Live session updated successfully.');
    }

    /**
     * Remove the specified live session from storage.
     */
    public function destroy(LiveSession $liveSession)
    {
        $liveSession->delete();

        return redirect()->route('live_sessions.index')
                         ->with('success', 'Live session deleted successfully.');
    }
}
