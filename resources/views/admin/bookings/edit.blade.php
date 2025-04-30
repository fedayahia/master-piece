@extends('admin.layouts.app')

@section('title', 'Edit Booking')

@section('content')
<style>
    .container {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-top: 20px;
        max-width: 100%;
        overflow-x: hidden;
    }
    
    h2 {
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
    
    select.form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23393D72' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
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
        h2 {
            font-size: 1.4rem;
        }
        
        .action-buttons {
            gap: 0.8rem;
        }
    }
    
    @media (max-width: 767.98px) {
        .container {
            padding: 15px;
            margin-top: 15px;
        }
        
        h2 {
            font-size: 1.3rem;
            margin-bottom: 15px;
        }
        
        .form-control, .form-select {
            padding: 8px 12px;
        }
        
        .btn {
            padding: 8px 15px;
            font-size: 0.9rem;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .action-buttons .btn {
            width: 100%;
        }
    }
    
    @media (max-width: 575.98px) {
        .container {
            padding: 12px;
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
            padding: 7px 10px;
            font-size: 0.9rem;
        }
        
        .btn {
            padding: 7px 12px;
            font-size: 0.85rem;
        }
        
        .btn i {
            margin-right: 5px !important;
        }
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4">Edit Booking</h2>

    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="user_id" class="form-label">User</label>
            <select name="user_id" id="user_id" class="form-select" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $booking->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="course_id" class="form-label">Course</label>
            <select name="course_id" id="course_id" class="form-select" required>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" {{ $booking->course_id == $course->id ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="session_id" class="form-label">Session</label>
            <select name="session_id" id="session_id" class="form-select">
                @foreach ($sessions as $session)
                    <option value="{{ $session->id }}" {{ $booking->session_id == $session->id ? 'selected' : '' }}>
                        {{ $session->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="booking_date" class="form-label">Booking Date</label>
            <input type="date" name="booking_date" id="booking_date" class="form-control"
                value="{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}" required>
        </div>

        <div class="form-group">
            <label for="seat_number" class="form-label">Seat Number</label>
            <input type="text" name="seat_number" class="form-control" value="{{ $booking->seat_number }}">
        </div>

        <div class="form-group">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select">
                @foreach(['pending', 'confirmed', 'cancelled', 'completed'] as $status)
                    <option value="{{ $status }}" {{ $booking->status === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="action-buttons">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> <span class="btn-text">Update Booking</span>
            </button>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                <i class="fas fa-times me-1"></i> <span class="btn-text">Cancel</span>
            </a>
        </div>
    </form>
</div>

<script>
    // Make date inputs work better on mobile
    document.addEventListener('DOMContentLoaded', function() {
        // Adjust date input type based on device
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            const dateInput = document.getElementById('booking_date');
            if (dateInput) {
                dateInput.type = 'datetime-local';
            }
        }
    });
</script>
@endsection