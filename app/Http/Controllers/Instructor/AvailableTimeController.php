<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\AvailableTime;
use Illuminate\Http\Request;
use App\Models\PrivateSession;

class AvailableTimeController extends Controller
{
    public function index()
    {
        // Get private session IDs that belong to the current instructor
        $myPrivateSessionIds = PrivateSession::where('instructor_id', auth()->id())
            ->pluck('id')
            ->toArray();
    
        // Get available times assigned to these private sessions
        $availableTimes = AvailableTime::whereIn('private_session_id', $myPrivateSessionIds)
            ->orWhereNull('private_session_id') // Include unassigned slots if needed
            ->with('privateSession')
            ->orderBy('available_date', 'asc')
            ->get();
    
        return view('instructor.available_times.index', compact('availableTimes'));
    }
    
    public function destroy(AvailableTime $availableTime)
    {
        if (!$availableTime->is_available || $availableTime->private_session_id !== null) {
            return back()->with('error', 'Cannot delete a booked or assigned session!');
        }
    
        $availableTime->delete();
    
        return redirect()->route('instructor.available_times.index')
               ->with('success', 'Time slot deleted successfully!');
    }
    
    public function create()
    {
        $privateSessions = PrivateSession::with('user') // Eager load user
            ->where('instructor_id', auth()->id()) // Or your condition
            ->get();
    
        return view('instructor.available_times.create', compact('privateSessions'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'available_date' => [
                'required',
                'date_format:Y-m-d\TH:i',
                function ($attribute, $value, $fail) {
                    $exists = AvailableTime::where('available_date', $value)->exists();
                    if ($exists) {
                        $fail('This time slot already exists.');
                    }
                }
            ],
            'private_session_id' => [
                'nullable',
                'exists:private_sessions,id',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value) {
                        $exists = AvailableTime::where('private_session_id', $value)
                            ->where('available_date', $request->available_date)
                            ->exists();
                        
                        if ($exists) {
                            $fail('This private session already has the same date and time.');
                        }
                    }
                }
            ],
        ]);
    
        AvailableTime::create([
            'available_date' => $validated['available_date'],
            'private_session_id' => $validated['private_session_id'],
            'is_available' => true,
        ]);
    
        return redirect()->route('instructor.available_times.index')
               ->with('success', 'Time slot added successfully!');
    }
}
