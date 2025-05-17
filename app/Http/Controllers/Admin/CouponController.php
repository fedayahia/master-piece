<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\PrivateSession;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
            'status' => 'required|in:active,inactive',
            'applicable_type' => 'nullable|in:App\Models\Course,App\Models\PrivateSession',
            'applicable_id' => 'nullable|numeric|exists:' . $this->resolveTable($request->applicable_type) . ',id',
        ]);
    
        $validated['discount_type'] = 'percentage';
    
        if ($validated['discount_amount'] < 0 || $validated['discount_amount'] > 100) {
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
        $coupon = Coupon::with(['applicable'])->findOrFail($id);
        $courses = Course::all();
        $privateSessions = PrivateSession::all();
        
        return view('admin.coupons.edit', compact('coupon', 'courses', 'privateSessions'));
    }

    
    public function update(Request $request, Coupon $coupon)
    {
        Log::info('Starting coupon update', [
            'coupon_id' => $coupon->id,
            'request_data' => $request->all()
        ]);
    
        try {
            $validated = $request->validate([
                'code' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('coupons')->ignore($coupon->id)
                ],
      'discount_amount' => [
    'required',
    'numeric',
    function ($attribute, $value, $fail) use ($request) {
        if ($request->discount_type == 'percentage') {
            if ($value <= 0 || $value > 100) {
                $fail('The discount percentage must be greater than 0 and less than or equal to 100.');
            }
        } elseif ($request->discount_type == 'fixed') {
            if ($value < 0) {
                $fail('The discount amount must be positive.');
            }
        }
    }
],

                'discount_type' => 'required|in:percentage,fixed',
                'applicable_id' => [
                    'nullable',
                    'required_with:applicable_type',
                    'numeric',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->applicable_type) {
                            $model = $request->applicable_type;
                            if (!class_exists($model) || !$model::find($value)) {
                                $fail('The selected applicable item is invalid.');
                            }
                        }
                    }
                ],
                'applicable_type' => 'nullable|in:App\Models\Course,App\Models\PrivateSession',
                'status' => 'required|in:active,inactive',
                'expires_at' => 'nullable|date|after:today',
                'usage_limit' => 'nullable|integer|min:1'
            ]);
    
            Log::info('Validation successful', ['validated' => $validated]);
    
            DB::beginTransaction();
    
            $coupon->update($validated);
    
            Log::info('Coupon updated successfully', ['coupon_id' => $coupon->id]);
    
            DB::commit();
    
            return redirect()
                ->route('admin.coupons.index')
                ->with('success', 'Coupon updated successfully.');
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return back()
                ->withErrors($e->errors())
                ->withInput();
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            Log::error('Coupon update failed', [
                'error' => $e->getMessage(),
                'coupon_id' => $coupon->id,
                'request_data' => $request->all()
            ]);
    
            return back()
                ->withInput()
                ->with('error', 'Failed to update coupon. Please try again.');
        }
    }
    
    
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully.');
    }
}
