<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::query()
            ->leftJoin('courses', function($join) {
                $join->on('bookings.booking_for_type', '=', DB::raw("'Course'"))
                     ->on('bookings.booking_for_id', '=', 'courses.id');
            })
            ->leftJoin('private_sessions', function($join) {
                $join->on('bookings.booking_for_type', '=', DB::raw("'PrivateSession'"))
                     ->on('bookings.booking_for_id', '=', 'private_sessions.id');
            })
            ->select(
                'bookings.*',
                DB::raw("CASE 
                            WHEN bookings.booking_for_type = 'Course' THEN courses.title
                            WHEN bookings.booking_for_type = 'PrivateSession' THEN private_sessions.title
                            ELSE 'Unknown'
                        END AS item_name")
            );

        // فلترة البيانات
        if ($request->has('booking_for_type') && $request->booking_for_type != '') {
            $query->where('bookings.booking_for_type', $request->booking_for_type);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('bookings.status', $request->status);
        }

        if ($request->has('booking_date') && $request->booking_date != '') {
            $query->whereDate('bookings.booking_date', $request->booking_date);
        }

        if ($request->has('seat_number') && $request->seat_number != '') {
            $query->where('bookings.seat_number', $request->seat_number);
        }

        if ($request->has('course_id') && $request->course_id != '') {
            $query->where('bookings.course_id', $request->course_id);
        }

        $bookings = $query->with('user')->get();

        return view('admin.bookings.index', compact('bookings'));
    }
    public function show($id)
    {
        $booking = DB::table('bookings')
            ->leftJoin('courses', function($join) {
                $join->on('bookings.booking_for_type', '=', DB::raw("'Course'"))
                    ->on('bookings.booking_for_id', '=', 'courses.id');
            })
            ->leftJoin('private_sessions', function($join) {
                $join->on('bookings.booking_for_type', '=', DB::raw("'PrivateSession'"))
                    ->on('bookings.booking_for_id', '=', 'private_sessions.id');
            })
            ->select(
                'bookings.*',
                'courses.title as course_title',
                'private_sessions.title as session_title',
                DB::raw("CASE 
                            WHEN bookings.booking_for_type = 'Course' THEN 'Course'
                            WHEN bookings.booking_for_type = 'PrivateSession' THEN 'PrivateSession'
                            ELSE 'Unknown'
                        END AS booking_for_type")
            )
            ->where('bookings.id', $id)
            ->first();
    
        $booking->user = User::find($booking->user_id);
    
        return view('admin.bookings.show', compact('booking'));
    }
    

    public function create()
    {
        return view('admin.bookings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_date' => 'required|date',
            'seat_number' => 'nullable|integer',
            'status' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'booking_for_type' => 'required|string',
            'booking_for_id' => 'required|integer',
        ]);

        Booking::create($request->all());

        return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully.');
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'booking_date' => 'required|date',
            'seat_number' => 'nullable|integer',
            'status' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'booking_for_type' => 'required|string',
            'booking_for_id' => 'required|integer',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update($request->all());

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
    }
}
