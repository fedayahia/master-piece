@extends('admin.layouts.app')

@section('title', 'Create Course Session')

@section('content')
<style>
    .container {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        max-width: 1200px;
        margin: 2rem auto;
    }

    h2 {
        color: var(--primary);
        margin-bottom: 1.5rem;
        font-weight: 600;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--secondary);
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: block;
        color: #495057;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        font-size: 1rem;
        line-height: 1.5;
        height: auto; 
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus {
        border-color: var(--primary);
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(57, 61, 114, 0.25);
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-success {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .btn-success:hover {
        background-color: #2a2d55;
        border-color: #2a2d55;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(57, 61, 114, 0.3);
    }

    .btn-secondary {
        background-color: var(--secondary);
        border-color: var(--secondary);
        color: white;
    }

    .btn-secondary:hover {
        background-color: #3a3d5d;
        border-color: #3a3d5d;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(58, 61, 93, 0.3);
    }

    .btn i {
        margin-right: 0.5rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    /* Grid layout for larger screens */
    @media (min-width: 768px) {
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
    }

    /* Error message styling */
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .is-invalid {
        border-color: #dc3545;
    }

    .is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }
</style>

<div class="container">
    <h2>Add New Course Session</h2>

    <form action="{{ route('admin.course-sessions.store') }}" method="POST">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label for="course_id">Course</label>
                <select name="course_id" id="course_id" class="form-control @error('course_id') is-invalid @enderror" required>
                    <option value="">Select Course</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="user_id">Instructor</label>
                <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                    <option value="">Select Instructor</option>
                    @foreach ($instructors as $instructor)
                        <option value="{{ $instructor->id }}" {{ old('user_id') == $instructor->id ? 'selected' : '' }}>
                            {{ $instructor->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="title">Session Title</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="session_mode">Session Mode</label>
                <select name="session_mode" id="session_mode" class="form-control @error('session_mode') is-invalid @enderror" required>
                    <option value="">Select Mode</option>
                    <option value="online" {{ old('session_mode') == 'online' ? 'selected' : '' }}>Online</option>
                    <option value="offline" {{ old('session_mode') == 'offline' ? 'selected' : '' }}>Offline</option>
                </select>
                @error('session_mode')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="duration">Duration (in hours)</label>
                <input type="number" name="duration" id="duration" class="form-control @error('duration') is-invalid @enderror" value="{{ old('duration') }}" required>
                @error('duration')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="datetime-local" name="start_date" id="start_date" 
                       class="form-control @error('start_date') is-invalid @enderror" 
                       value="{{ old('start_date') }}" 
                       required 
                       min="{{ now()->format('Y-m-d\TH:i') }}" 
                       max="{{ now()->addYear()->format('Y-m-d\TH:i') }}"                        >
                @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="datetime-local" name="end_date" id="end_date" 
                       class="form-control @error('end_date') is-invalid @enderror" 
                       value="{{ old('end_date') }}" 
                       required 
                       min="{{ now()->format('Y-m-d\TH:i') }}" 
                       max="{{ now()->addYear()->format('Y-m-d\TH:i') }}">
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            


            <div class="form-group">
                <label for="max_seats">Max Seats</label>
                <input type="number" name="max_seats" id="max_seats" class="form-control @error('max_seats') is-invalid @enderror" value="{{ old('max_seats') }}" required>
                @error('max_seats')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="action-buttons">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save mr-2"></i> Create Session
            </button>
            <a href="{{ route('admin.course-sessions.index') }}" class="btn btn-secondary">
                <i class="fas fa-times mr-2"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection