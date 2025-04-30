@extends('instructor.layouts.app')

@section('content')
<style>
    /* Main Container */
    .container {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        margin: 1.5rem auto;
        max-width: 800px;
    }

    /* Header Section */
    h2 {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--secondary);
        position: relative;
    }

    h2::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -2px;
        width: 50px;
        height: 3px;
        background-color: var(--dark);
    }

    /* Alert Styles */
    .alert {
        padding: 0.75rem 1.25rem;
        border-radius: 0.375rem;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background-color: #e8f5e9;
        border-color: #c8e6c9;
        color: #2e7d32;
    }

    /* Form Styles */
    .mb-3 {
        margin-bottom: 1.5rem !important;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--primary);
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 0.375rem;
        font-size: 1rem;
        height: auto;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(57, 61, 114, 0.25);
        background-color: white;
        outline: none;
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23393D72' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
    }

    /* Button Styles */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background-color: #2a2d55;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(57, 61, 114, 0.2);
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
    }

    .btn i {
        margin-right: 0.5rem;
    }

    /* Button Group */
    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    /* Date Input Styling */
    input[type="datetime-local"]::-webkit-calendar-picker-indicator {
        filter: invert(0.5);
    }

    /* Radio Button Styles */
    .radio-group {
        display: flex;
        gap: 1.5rem;
        margin-top: 0.5rem;
    }

    .radio-option {
        display: flex;
        align-items: center;
    }

    .radio-option input {
        margin-right: 0.5rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .container {
            padding: 1.5rem;
        }
        
        h2 {
            font-size: 1.5rem;
        }

        .radio-group {
            flex-direction: column;
            gap: 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .container {
            padding: 1rem;
        }
        
        h2 {
            font-size: 1.25rem;
        }
        
        .form-control {
            padding: 0.65rem;
        }
        
        .button-group {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
    }

    /* Animation for form elements */
    .mb-3 {
        animation: fadeInUp 0.5s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Validation Styles */
    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>
<div class="container">
    <h2>Edit Course Session</h2>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('instructor.course_sessions.update', $session->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Session Title</label>
            <input type="text" class="form-control" name="title" value="{{ old('title', $session->title) }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="course_id" class="form-label">Course</label>
            <select name="course_id" id="course_id" class="form-control" required>
                <option value="">Select Course</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id', $session->course_id) == $course->id ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                @endforeach
            </select>
            @error('course_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="datetime-local" class="form-control" name="start_date" 
                       value="{{ old('start_date', \Carbon\Carbon::parse($session->start_date)->format('Y-m-d\TH:i')) }}" required>
                @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="datetime-local" class="form-control" name="end_date" 
                       value="{{ old('end_date', \Carbon\Carbon::parse($session->end_date)->format('Y-m-d\TH:i')) }}" required>
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="duration" class="form-label">Duration (minutes)</label>
            <input type="number" class="form-control" name="duration" value="{{ old('duration', $session->duration) }}" required min="1">
            @error('duration')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="max_seats" class="form-label">Max Seats</label>
            <input type="number" class="form-control" name="max_seats" value="{{ old('max_seats', $session->max_seats) }}" min="1">
            @error('max_seats')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Session Mode</label>
            <div class="radio-group">
                <div class="radio-option">
                    <input type="radio" id="online" name="session_mode" value="online" {{ old('session_mode', $session->session_mode) == 'online' ? 'checked' : '' }}>
                    <label for="online">Online</label>
                </div>
                <div class="radio-option">
                    <input type="radio" id="offline" name="session_mode" value="offline" {{ old('session_mode', $session->session_mode) == 'offline' ? 'checked' : '' }}>
                    <label for="offline">Offline</label>
                </div>
            </div>
            @error('session_mode')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="button-group">
            <a href="{{ route('instructor.course_sessions.index') }}" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Update Session
            </button>
        </div>
    </form>
</div>
@endsection