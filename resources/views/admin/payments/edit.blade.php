@extends('admin.layouts.app')

@section('title', 'Edit Payment')

@section('content')
<style>
    /* Main Container */
    .container {
        background-color: white;
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        margin: 1.5rem auto;
        max-width: 100%;
    }

    /* Header */
    h1 {
        color: var(--primary);
        margin-bottom: 1.5rem;
        font-weight: 600;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--secondary);
    }

    /* Form Groups */
    .form-group {
        margin-bottom: 1.25rem;
    }

    /* Labels */
    .form-label {
        display: block;
        font-weight: 500;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    /* Form Controls */
    .form-control, 
    .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        font-size: 1rem;
        line-height: 1.5;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus, 
    .form-select:focus {
        border-color: var(--primary);
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(57, 61, 114, 0.25);
    }

    /* Select Dropdown Styling */
    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23393D72' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
    }

    /* Input Group */
    .input-group {
        display: flex;
        align-items: stretch;
    }
    
    .input-group-text {
        padding: 0.75rem 1rem;
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-radius: 0.375rem 0 0 0.375rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        text-align: center;
        white-space: nowrap;
    }

    /* Buttons */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background-color: #2a2d55;
        border-color: #2a2d55;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(57, 61, 114, 0.3);
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #5a6268;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
    }

    /* Textarea */
    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    /* Status Badges */
    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 500;
        border-radius: 0.25rem;
        text-transform: capitalize;
    }

    .badge-pending {
        background-color: #ffc107;
        color: #212529;
    }

    .badge-completed {
        background-color: #28a745;
        color: white;
    }

    .badge-failed {
        background-color: #dc3545;
        color: white;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .container {
            padding: 1.25rem;
        }
        
        .form-actions {
            flex-direction: column-reverse;
            gap: 0.75rem;
        }
        
        .btn {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        h1 {
            font-size: 1.5rem;
        }
        
        .form-control, 
        .form-select {
            padding: 0.65rem 0.75rem;
            font-size: 0.875rem;
        }
    }
</style>

<div class="container">
    <h1>Edit Payment #{{ $payment->id }}</h1>

    <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="user_id" class="form-label">User</label>
            <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $payment->user_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="course_id" class="form-label">Course</label>
            <select name="course_id" id="course_id" class="form-select @error('course_id') is-invalid @enderror" required>
                <option value="">Select Course</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id', $payment->course_id) == $course->id ? 'selected' : '' }}>
                        {{ $course->title }} (${{ number_format($course->price, 2) }})
                    </option>
                @endforeach
            </select>
            @error('course_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="amount" class="form-label">Amount</label>
            <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" 
                       step="0.01" min="0" value="{{ old('amount', $payment->amount) }}" required>
            </div>
            @error('amount')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="payment_method" class="form-label">Payment Method</label>
            <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                <option value="">Select Payment Method</option>
                @foreach(['credit_card' => 'Credit Card', 'paypal' => 'PayPal', 'bank_transfer' => 'Bank Transfer'] as $value => $label)
                    <option value="{{ $value }}" {{ old('payment_method', $payment->payment_method) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('payment_method')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                @foreach(['pending' => 'Pending', 'completed' => 'Completed', 'failed' => 'Failed'] as $value => $label)
                    <option value="{{ $value }}" {{ old('status', $payment->status) == $value ? 'selected' : '' }}>
                        <span class="badge badge-{{ $value }}">{{ $label }}</span>
                    </option>
                @endforeach
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="transaction_id" class="form-label">Transaction ID</label>
            <input type="text" name="transaction_id" id="transaction_id" class="form-control @error('transaction_id') is-invalid @enderror" 
                   value="{{ old('transaction_id', $payment->transaction_id) }}" required>
            @error('transaction_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="paid_at" class="form-label">Payment Date</label>
            <input type="datetime-local" name="paid_at" id="paid_at" class="form-control @error('paid_at') is-invalid @enderror" 
                   value="{{ old('paid_at', $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('Y-m-d\TH:i') : '') }}">
            @error('paid_at')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $payment->notes) }}</textarea>
            @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Payment
            </button>
        </div>
    </form>
</div>

<script>
    // Auto-fill amount when course is selected
    document.getElementById('course_id').addEventListener('change', function() {
        const courseId = this.value;
        if (courseId) {
            // You would typically fetch the course price from your data
            // This is just a placeholder - implement based on your actual data structure
            const courses = @json($courses->keyBy('id'));
            const selectedCourse = courses[courseId];
            if (selectedCourse) {
                document.getElementById('amount').value = selectedCourse.price.toFixed(2);
            }
        }
    });
</script>
@endsection