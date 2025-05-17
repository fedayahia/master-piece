@extends('instructor.layouts.app')

@section('content')
<style>
    :root {
        --primary: #393D72;
        --secondary: rgba(254, 56, 115, 0.3);
        --accent: #1A1C2E;
        --dark: #ff2f6e;
        --light: #F8F9FA;
        --border: #e0e0e0;
        --text-light: #6c757d;
    }

    /* Main Container */
    .container {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        margin: 2rem auto;
        max-width: 800px;
    }

    /* Header Section */
    .section-header {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--secondary);
    }

    @media (min-width: 768px) {
        .section-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    .section-header h1 {
        color: var(--primary);
        font-weight: 600;
        margin: 0;
        font-size: 1.75rem;
    }

    /* Form Styling */
    form {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    /* Form Input Groups */
    .mb-3 {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--primary);
    }

    .form-control {
        width: 100%;
        height: auto;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus {
        border-color: var(--primary);
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(57, 61, 114, 0.25);
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23393D72' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
        padding-right: 2.5rem;
    }

    /* Buttons */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
        border: none;
        cursor: pointer;
        font-size: 1rem;
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

    /* Alert Styling */
    .alert {
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-radius: 0.5rem;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .alert ul {
        margin-bottom: 0;
        padding-left: 1.5rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 767px) {
        .container {
            padding: 1.5rem;
        }
        
        form {
            padding: 1.5rem;
        }
    }

    @media (max-width: 575px) {
        .container {
            padding: 1.25rem;
        }
        
        .section-header h1 {
            font-size: 1.5rem;
        }
        
        .btn {
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
        }
        
        .form-control {
            padding: 0.65rem 0.75rem;
        }
    }

    /* Date/Time Picker Customization */
    input[type="datetime-local"] {
        position: relative;
    }

    input[type="datetime-local"]::-webkit-calendar-picker-indicator {
        background: transparent;
        bottom: 0;
        color: transparent;
        cursor: pointer;
        height: auto;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        width: auto;
    }

    /* Form Group Focus Effect */
    .form-group:focus-within .form-label {
        color: var(--dark);
    }
</style>
    <div class="container">
        <div class="section-header">
            <h1>Add Available Time</h1>
            <a href="{{ route('instructor.available_times.index') }}" class="btn btn-primary">Back</a>
        </div>

        {{-- Display Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Create Available Time Form --}}
        <form action="{{ route('instructor.available_times.store') }}" method="POST">
            @csrf

            {{-- Select Private Session --}}
            <div class="mb-3">
                <label for="private_session_id" class="form-label">Select Private Session:</label>
                <select name="private_session_id" id="private_session_id" class="form-control" required>
                    <option value="">-- Select --</option>
                    @foreach ($privateSessions as $session)
                        <option value="{{ $session->id }}">
                            {{ $session->title ?? 'Unknown User' }}  
                        </option>
                    @endforeach
                </select>                
            </div>

            {{-- Available Date & Time --}}
            <div class="mb-3">
                <label for="available_date" class="form-label">Available Date & Time:</label>
                <input type="datetime-local" name="available_date" id="available_date" class="form-control" required>
            </div>

            {{-- Availability Status --}}
            <div class="mb-3">
                <label for="is_available" class="form-label">Is Available?</label>
                <select name="is_available" id="is_available" class="form-control" required>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection