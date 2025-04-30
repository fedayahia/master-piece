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

    /* Card Styles */
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .card-body {
        padding: 2rem;
    }

    .card-title {
        color: var(--primary);
        font-weight: 600;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #eee;
    }

    /* Detail Items */
    .card-body p {
        margin-bottom: 1rem;
        font-size: 1rem;
        line-height: 1.6;
    }

    .card-body strong {
        color: var(--primary);
        font-weight: 500;
        min-width: 120px;
        display: inline-block;
    }

    /* Button Styles */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: none;
        margin-right: 0.75rem;
        margin-top: 1rem;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.2);
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.2);
    }

    /* Button Icons */
    .btn i {
        margin-right: 0.5rem;
    }

    /* Delete Form Styling */
    form.d-inline {
        display: inline-block;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .container {
            padding: 1.5rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .card-title {
            font-size: 1.25rem;
        }
    }

    @media (max-width: 576px) {
        .container {
            padding: 1rem;
        }
        
        h2 {
            font-size: 1.25rem;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .btn {
            width: 100%;
            margin-right: 0;
            margin-bottom: 0.75rem;
        }
        
        .card-body strong {
            display: block;
            margin-bottom: 0.25rem;
        }
    }

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeIn 0.5s ease-out;
    }
</style>
<div class="container">
    <h2>Session Details</h2>

    <div class="card mt-4">
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $session->title }}</h5>
                    <div class="session-details">
                        <p class="detail-item">
                            <span class="detail-label"><i class="fas fa-book me-2"></i>Course:</span>
                            <span class="detail-value">{{ $session->course->title }}</span>
                        </p>
                        <p class="detail-item">
                            <span class="detail-label"><i class="fas fa-user-tie me-2"></i>Instructor:</span>
                            <span class="detail-value">{{ $session->user ? $session->user->name : 'No instructor assigned' }}</span>
                        </p>
                        <p class="detail-item">
                            <span class="detail-label"><i class="fas fa-play-circle me-2"></i>Start:</span>
                            <span class="detail-value">{{ \Carbon\Carbon::parse($session->start_date)->format('M d, Y H:i') }}</span>
                        </p>
                        <p class="detail-item">
                            <span class="detail-label"><i class="fas fa-stop-circle me-2"></i>End:</span>
                            <span class="detail-value">{{ \Carbon\Carbon::parse($session->end_date)->format('M d, Y H:i') }}</span>
                        </p>
                        <p class="detail-item">
                            <span class="detail-label"><i class="fas fa-clock me-2"></i>Duration:</span>
                            <span class="detail-value">{{ $session->duration }} minutes</span>
                        </p>
                        <p class="detail-item">
                            <span class="detail-label"><i class="fas fa-users me-2"></i>Max Seats:</span>
                            <span class="detail-value">{{ $session->max_seats }}</span>
                        </p>
                        <p class="detail-item">
                            <span class="detail-label"><i class="fas fa-laptop-house me-2"></i>Session Mode:</span>
                            <span class="detail-value">
                                @if($session->session_mode == 'online')
                                    <span class="badge bg-primary">Online</span>
                                @else
                                    <span class="badge bg-secondary">Offline</span>
                                @endif
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                {{-- <a href="{{ route('instructor.course_sessions.edit', $session->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>

                <form action="{{ route('instructor.course_sessions.destroy', $session->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this session?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form> --}}

                <a href="{{ route('instructor.course_sessions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to list
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
