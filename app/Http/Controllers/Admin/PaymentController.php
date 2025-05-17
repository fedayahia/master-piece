<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use App\Models\Course;
use App\Models\PrivateSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = DB::table('payments')
            ->leftJoin('courses', function($join) {
                $join->on('payments.payment_for_type', '=', DB::raw("'Course'"))
                     ->on('payments.payment_for_id', '=', 'courses.id');
            })
            ->leftJoin('private_sessions', function($join) {
                $join->on('payments.payment_for_type', '=', DB::raw("'PrivateSession'"))
                     ->on('payments.payment_for_id', '=', 'private_sessions.id');
            })
            ->leftJoin('users', 'payments.user_id', '=', 'users.id')
            ->select(
                'payments.*',
                'users.name as user_name', 
                DB::raw("CASE 
                    WHEN payments.payment_for_type = 'Course' THEN courses.title
                    WHEN payments.payment_for_type = 'PrivateSession' THEN private_sessions.title
                    ELSE 'Unknown'
                END AS item_name")
            )
            ->latest('payments.created_at')
            ->paginate(10);
    
        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        $users = User::where('role', '!=', 'admin')->get();
        $courses = Course::all();
        $sessions = PrivateSession::all();
        
        return view('admin.payments.create', compact('users', 'courses', 'sessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'payment_for_type' => 'required|in:Course,PrivateSession',
            'payment_for_id' => 'required',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string|max:255',
            'status' => 'required|in:pending,completed,failed',
        ]);

        if ($validated['payment_for_type'] === 'Course') {
            $request->validate(['payment_for_id' => 'exists:courses,id']);
        } else {
            $request->validate(['payment_for_id' => 'exists:private_sessions,id']);
        }

        Payment::create([
            'user_id' => $validated['user_id'],
            'payment_for_type' => $validated['payment_for_type'],
            'payment_for_id' => $validated['payment_for_id'],
            'amount' => $validated['amount'],
            'method' => $validated['method'],
            'status' => $validated['status'],
            'transaction_id' => 'PAY-' . uniqid(),
            'paid_at' => now(),
        ]);

        return redirect()->route('admin.payments.index')->with('success', 'Payment added successfully');
    }
    public function show($id)
    {
        $payment = DB::table('payments')
            ->leftJoin('courses', function($join) {
                $join->on('payments.payment_for_type', '=', DB::raw("'Course'"))
                     ->on('payments.payment_for_id', '=', 'courses.id');
            })
            ->leftJoin('private_sessions', function($join) {
                $join->on('payments.payment_for_type', '=', DB::raw("'PrivateSession'"))
                     ->on('payments.payment_for_id', '=', 'private_sessions.id');
            })
            ->leftJoin('users', 'payments.user_id', '=', 'users.id')
            ->select(
                'payments.*',
                'users.name as user_name',
                'users.email as user_email',
                'users.phone_number as user_phone',
                DB::raw("CASE 
                    WHEN payments.payment_for_type = 'Course' THEN 'Course'
                    WHEN payments.payment_for_type = 'PrivateSession' THEN 'Private Session'
                    ELSE payments.payment_for_type
                END AS payment_type"),
                DB::raw("CASE 
                    WHEN payments.payment_for_type = 'Course' THEN courses.title
                    WHEN payments.payment_for_type = 'PrivateSession' THEN private_sessions.title
                    ELSE 'Unknown'
                END AS item_name"),
                DB::raw("CASE 
                    WHEN payments.payment_for_type = 'Course' THEN courses.description
                    WHEN payments.payment_for_type = 'PrivateSession' THEN private_sessions.description
                    ELSE NULL
                END AS item_description") 
            )
            ->where('payments.id', $id)
            ->first();
    
        if (!$payment) {
            abort(404);
        }
    
        return view('admin.payments.show', compact('payment'));
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        $users = User::where('role', '!=', 'admin')->get();
        
        return view('admin.payments.edit', compact('payment', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string|max:255',
            'status' => 'required|in:pending,completed,failed',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->update($validated);

        return redirect()->route('admin.payments.index')->with('success', 'Payment updated successfully');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->route('admin.payments.index')->with('success', 'Payment deleted successfully');
    }

    public function print($id)
    {
        $payment = Payment::with(['user', 'paymentable'])->findOrFail($id);
        return view('admin.payments.print', compact('payment'));
    }
}
