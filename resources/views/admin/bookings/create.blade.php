@extends('admin.layouts.app')

@section('title', 'Create New Booking')

@section('content')
<style>
    .container {
        background-color: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-top: 20px;
        max-width: 100%;
    }
    
    h2 {
        color: var(--primary);
        margin-bottom: 25px;
        font-weight: 600;
        border-bottom: 2px solid var(--secondary);
        padding-bottom: 10px;
        font-size: 1.5rem;
    }
    
    .form-label {
        font-weight: 500;
        color: var(--accent);
        margin-bottom: 8px;
    }
    
    .form-control, .form-select {
        border-radius: 6px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        transition: all 0.3s ease;
        width: 100%;
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
        margin: 5px 0;
    }
    
    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    
    .btn-primary:hover {
        background-color: #2c3060;
        border-color: #2c3060;
        transform: translateY(-2px);
    }
    
    .btn-secondary {
        background-color: var(--light);
        border-color: var(--light);
        color: var(--accent);
    }
    
    .btn-secondary:hover {
        background-color: #e8e9ea;
        border-color: #e8e9ea;
        color: var(--accent);
        transform: translateY(-2px);
    }
    
    .alert-danger {
        background-color: #ffebee;
        border-left: 4px solid #f44336;
        color: #d32f2f;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 25px;
        flex-wrap: wrap;
    }
    
    /* Responsive adjustments */
    @media (max-width: 1199.98px) {
        .container {
            padding: 20px;
        }
    }
    
    @media (max-width: 991.98px) {
        h2 {
            font-size: 1.4rem;
        }
        
        .action-buttons {
            gap: 10px;
        }
    }
    
    @media (max-width: 767.98px) {
        .container {
            padding: 15px;
            margin-top: 15px;
        }
        
        h2 {
            font-size: 1.3rem;
            margin-bottom: 20px;
        }
        
        .form-control, .form-select {
            padding: 8px 12px;
            font-size: 0.95rem;
        }
        
        .btn {
            padding: 8px 16px;
            font-size: 0.9rem;
            width: 100%;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 8px;
        }
    }
    
    @media (max-width: 575.98px) {
        .container {
            padding: 15px;
            border-radius: 8px;
        }
        
        h2 {
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
            font-size: 0.85rem;
        }
    }
    
    /* Date input mobile optimization */
    @media (max-width: 767.98px) {
        input[type="date"] {
            min-height: 40px;
        }
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4">Create New Booking</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some errors:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.bookings.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">-- Select User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="course_id" class="form-label">Course</label>
            <select name="course_id" id="course_id" class="form-control" required>
                <option value="">-- Select Course --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="session_id" class="form-label">Session (Optional)</label>
            <select name="session_id" id="session_id" class="form-control">
                <option value="">-- Select Session --</option>
                @foreach($sessions as $session)
                    <option value="{{ $session->id }}" {{ old('session_id') == $session->id ? 'selected' : '' }}>
                        {{ $session->title ?? 'Session #' . $session->id }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="booking_date" class="form-label">Booking Date</label>
            <input type="date" name="booking_date" id="booking_date" class="form-control" 
                   value="{{ old('booking_date') }}" required>
        </div>

        <div class="mb-3">
            <label for="seat_number" class="form-label">Seat Number (Optional)</label>
            <input type="text" name="seat_number" id="seat_number" class="form-control" 
                   value="{{ old('seat_number') }}" placeholder="Enter seat number">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <div class="action-buttons">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Save Booking
            </button>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i> Cancel
            </a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enhance date input for mobile devices
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            const dateInput = document.getElementById('booking_date');
            if (dateInput) {
                // Set default date to today if not already set
                if (!dateInput.value) {
                    const today = new Date();
                    const formattedDate = today.toISOString().substr(0, 10);
                    dateInput.value = formattedDate;
                }
                
                // Change type to datetime-local for better mobile support
                dateInput.type = 'datetime-local';
            }
        }
        
        // Preserve form data on page refresh
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function() {
                localStorage.removeItem('bookingFormData');
            });
        }
    });
</script>
@endsection