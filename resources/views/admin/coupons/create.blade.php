@extends('admin.layouts.app')

@section('title', 'Create Coupon')

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
        color: var(--accent);
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
    }

    .form-control, .form-select {
        border: 1px solid #ddd;
        border-radius: 6px;
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
        border: none;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background-color: #2c3060;
        transform: translateY(-2px);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    /* Responsive adjustments */
    @media (max-width: 1199.98px) {
        .container {
            padding: 20px;
        }
    }

    @media (max-width: 991.98px) {
        h1 {
            font-size: 1.4rem;
        }
    }

    @media (max-width: 767.98px) {
        .container {
            padding: 15px;
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

    /* Custom select dropdown arrow */
    select.form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23393D72' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
    }
</style>

<div class="container">
    <h1>Create Coupon</h1>

    <form action="{{ route('admin.coupons.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="code" class="form-label">Coupon Code</label>
            <input type="text" name="code" class="form-control" required
                   placeholder="Enter coupon code (e.g. SUMMER20)">
            <small class="text-muted">Unique code customers will enter at checkout</small>
        </div>

        <div class="form-group">
            <label for="discount_amount" class="form-label">Discount Amount</label>
            <input type="number" step="0.01" name="discount_amount" class="form-control" required
                   placeholder="Enter discount amount">
        </div>

        <div class="form-group">
            <label for="discount_type" class="form-label">Discount Type</label>
            <select name="discount_type" class="form-select" required>
                <option value="percentage">Percentage</option>
                <option value="fixed">Fixed Amount</option>
            </select>
        </div>

  

        <div class="form-group">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Applicable To</label>
            <select name="applicable_type" class="form-select" id="applicable_type_select">
                <option value="">All Type</option>
                <option value="App\Models\Course">Course</option>
                <option value="App\Models\PrivateSession">Private Session</option>
            </select>
        </div>
        
        <div class="form-group" id="applicable_id_group" style="display: none;">
            <label class="form-label">Select Applicable Item</label>
            <select name="applicable_id" class="form-select" id="applicable_id_select">
                <option value="">Select...</option>
                @foreach($courses as $course)
                    <option data-type="App\Models\Course" value="{{ $course->id }}">{{ $course->title }}</option>
                @endforeach
                @foreach($privateSessions as $session)
                    <option data-type="App\Models\PrivateSession" value="{{ $session->id }}">{{ $session->title }}</option>
                @endforeach
            </select>
        </div>
        
    
        
        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Create Coupon
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('applicable_type_select').addEventListener('change', function () {
        const value = this.value;
        const idGroup = document.getElementById('applicable_id_group');
        const idSelect = document.getElementById('applicable_id_select');

        if (value) {
            idGroup.style.display = 'block';
            Array.from(idSelect.options).forEach(opt => {
                opt.style.display = opt.dataset.type === value || opt.value === "" ? 'block' : 'none';
            });
        } else {
            idGroup.style.display = 'none';
            idSelect.value = '';
        }
    });
</script>
<script>
    // Enhance date input for mobile devices
    document.addEventListener('DOMContentLoaded', function() {
        // Set default date to today + 30 days if not already set
        const dateInput = document.querySelector('input[type="date"]');
        if (dateInput) {
            const today = new Date();
            const futureDate = new Date(today);
            futureDate.setDate(today.getDate() + 30);
            
            // Format as YYYY-MM-DD
            const formattedDate = futureDate.toISOString().split('T')[0];
            dateInput.min = today.toISOString().split('T')[0];
            dateInput.value = formattedDate;
            
            // Change type to datetime-local for better mobile support
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                dateInput.type = 'datetime-local';
            }
        }
    });
</script>
@endsection