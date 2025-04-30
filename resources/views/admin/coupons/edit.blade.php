@extends('admin.layouts.app')

@section('title', 'Edit Coupon')

@section('content')
<style>
    .container {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-top: 20px;
        max-width: 100%;
    }
    
    h1 {
        color: var(--primary);
        margin-bottom: 20px;
        font-weight: 600;
        border-bottom: 2px solid var(--secondary);
        padding-bottom: 10px;
        font-size: 1.5rem;
    }
    
    .form-label {
        font-weight: 500;
        color: var(--accent);
        margin-bottom: 8px;
        display: block;
    }
    
    .form-control, .form-select {
        border-radius: 6px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        width: 100%;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.25rem rgba(57, 61, 114, 0.25);
    }
    
    .btn {
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
    }
    
    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
    }
    
    .btn-primary:hover {
        background-color: #2c3060;
        border-color: #2c3060;
        transform: translateY(-2px);
    }
    
    .btn-outline-secondary {
        border-color: #6c757d;
        color: #6c757d;
    }
    
    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .action-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    /* Custom select dropdown arrow */
    select.form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23393D72' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 1199.98px) {
        .container {
            padding: 25px;
        }
    }
    
    @media (max-width: 991.98px) {
        h1 {
            font-size: 1.4rem;
        }
    }
    
    @media (max-width: 767.98px) {
        .container {
            padding: 20px;
        }
        
        h1 {
            font-size: 1.3rem;
            margin-bottom: 15px;
        }
        
        .form-control, .form-select {
            padding: 8px 12px;
        }
        
        .btn {
            padding: 8px 16px;
            width: 100%;
        }
        
        .action-buttons {
            flex-direction: column-reverse;
        }
    }
    
    @media (max-width: 575.98px) {
        .container {
            padding: 15px;
        }
        
        h1 {
            font-size: 1.25rem;
            padding-bottom: 8px;
        }
        
        .form-label {
            font-size: 0.9rem;
        }
        
        .form-control, .form-select {
            padding: 8px 12px;
            font-size: 0.9rem;
        }
        
        .btn {
            padding: 8px 12px;
            font-size: 0.9rem;
        }
    }
</style>

<div class="container">
    <h1>Edit Coupon: {{ $coupon->code }}</h1>

    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="code" class="form-label">Coupon Code</label>
            <input type="text" name="code" class="form-control" 
                   value="{{ old('code', $coupon->code) }}" required
                   placeholder="Enter unique coupon code">
        </div>

        <div class="form-group">
            <label for="discount_amount" class="form-label">Discount Amount</label>
            <input type="number" step="0.01" name="discount_amount" class="form-control" 
                   value="{{ old('discount_amount', $coupon->discount_amount) }}" required
                   placeholder="Enter discount amount">
        </div>

        <div class="form-group">
            <label for="discount_type" class="form-label">Discount Type</label>
            <select name="discount_type" class="form-select" required>
                <option value="percentage" {{ old('discount_type', $coupon->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                <option value="fixed" {{ old('discount_type', $coupon->discount_type) == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
            </select>
        </div>
{{-- 
        <div class="form-group">
            <label for="applicable_type" class="form-label">Applicable To</label>
            <select name="applicable_type" class="form-select" required>
                <option value="App\Models\Course" {{ old('applicable_type', $coupon->applicable_type) == 'App\Models\Course' ? 'selected' : '' }}>Course</option>
                <option value="App\Models\PrivateSession" {{ old('applicable_type', $coupon->applicable_type) == 'App\Models\PrivateSession' ? 'selected' : '' }}>Private Session</option>
            </select>
        </div> --}}

        <div class="form-group">
            <label for="applicable_id" class="form-label">Applicable Item</label>
            <select name="applicable_id" class="form-select" required>
                <option value="">Select an item</option>
                @if($coupon->applicable_type == 'App\Models\Course')
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('applicable_id', $coupon->applicable_id) == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                @elseif($coupon->applicable_type == 'App\Models\PrivateSession')
                    @foreach($sessions as $session)
                        <option value="{{ $session->id }}" {{ old('applicable_id', $coupon->applicable_id) == $session->id ? 'selected' : '' }}>
                            {{ $session->title }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="form-group">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="active" {{ old('status', $coupon->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $coupon->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="action-buttons">
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Update Coupon
            </button>
        </div>
    </form>
</div>
@endsection
