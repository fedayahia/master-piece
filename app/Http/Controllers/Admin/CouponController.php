<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\PrivateSession;
use App\Models\Course;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    
    public function create()
    {
        $courses = Course::all();
        $privateSessions = PrivateSession::all(); 
    
        return view('admin.coupons.create', compact('courses', 'privateSessions'));
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:coupons,code',
            'discount_amount' => 'required|numeric',
            'discount_type' => 'required|in:percentage,fixed',
            'status' => 'required|in:active,inactive',
            'applicable_type' => 'nullable|in:App\Models\Course,App\Models\PrivateSession',
            'applicable_id' => 'nullable|numeric|exists:' . $this->resolveTable($request->applicable_type) . ',id',
        ]);
    
        if (
            $validated['discount_type'] === 'percentage' &&
            ($validated['discount_amount'] < 0 || $validated['discount_amount'] > 100)
        ) {
            return back()->withErrors(['discount_amount' => 'The discount percentage must be between 0 and 100.']);
        }
    
        Coupon::create($validated);
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully.');
    }
    
    private function resolveTable($model)
    {
        return match ($model) {
            'App\Models\Course' => 'courses',
            'App\Models\PrivateSession' => 'private_sessions',
            default => 'courses',
        };
    }
    
    

    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show', compact('coupon'));
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        $courses = Course::all();
        $privateSessions = PrivateSession::all(); 
    
        return view('admin.coupons.edit', compact('coupon', 'courses', 'privateSessions'));
    }
    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'discount_amount' => 'required|numeric',
            'discount_type' => 'required|in:percentage,fixed',
            'applicable_id' => 'required|numeric',
            'applicable_type' => 'required|in:App\Models\Course,App\Models\PrivateSession', 
            'status' => 'required|in:active,inactive',
        ]);
    
        if (
            $validated['discount_type'] === 'percentage' &&
            ($validated['discount_amount'] < 0 || $validated['discount_amount'] > 100)
        ) {
            return back()->withErrors(['discount_amount' => 'The discount percentage must be between 0 and 100.']);
        }
    
        $coupon->update($validated);
    
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully.');
    }
    

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully.');
    }
}
