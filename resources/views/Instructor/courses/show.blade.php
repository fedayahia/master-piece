@extends('instructor.layouts.app')

@section('content')
<style>
    /* Main Container */
    .container {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        margin: 2rem auto;
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

    /* Card Styling */
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .card-header {
        background-color: var(--primary);
        color: white;
        padding: 1.25rem 1.5rem;
        border-bottom: none;
    }

    .card-header h3 {
        margin: 0;
        font-weight: 500;
        font-size: 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .detail-item {
        margin-bottom: 1.25rem;
        display: flex;
        flex-wrap: wrap;
    }

    .detail-label {
        color: var(--primary);
        font-weight: 500;
        min-width: 180px;
        margin-bottom: 0.5rem;
    }

    .detail-value {
        flex: 1;
        min-width: 0;
    }

    .card-footer {
        background-color: rgba(57, 61, 114, 0.05);
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1rem 1.5rem;
        text-align: right;
    }

    /* Buttons */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-secondary {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .btn-secondary:hover {
        background-color: #2a2d55;
        border-color: #2a2d55;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(57, 61, 114, 0.3);
    }

    /* Image Styling */
    .course-image {
        border-radius: 8px;
        margin-top: 1rem;
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.1);
        max-width: 100%;
        height: auto;
        object-fit: cover;
    }

    /* Instructor Info */
    .instructor-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .instructor-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .container {
            padding: 1.5rem;
        }
        
        .detail-item {
            flex-direction: column;
        }
        
        .detail-label {
            min-width: 100%;
            margin-bottom: 0.25rem;
        }
    }

    @media (max-width: 576px) {
        .card-body, .card-header, .card-footer {
            padding: 1rem;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container">
    <h1>Course Details</h1>

    <div class="card">
        <div class="card-header">
            <h3>{{ $course->title }}</h3>
        </div>
        
        <div class="card-body">
            <div class="detail-item">
                <span class="detail-label">Description:</span>
                <span class="detail-value">{{ $course->description }}</span>
            </div>
            
            <div class="detail-item">
                <span class="detail-label">Price:</span>
                <span class="detail-value">JOD{{ number_format($course->price, 2) }}</span>
            </div>
            
            <div class="detail-item">
                <span class="detail-label">Duration:</span>
                <span class="detail-value">{{ $course->duration }} hours</span>
            </div>
            
            <div class="detail-item">
                <span class="detail-label">Category:</span>
                <span class="detail-value">
                    <span class="badge bg-secondary">{{ $course->category }}</span>
                </span>
            </div>
            
            <div class="detail-item">
                <span class="detail-label">Seats Available:</span>
                <span class="detail-value">
                    {{ $course->seats_available }} / {{ $course->max_seats ?? '∞' }}
                    @php
                        $maxSeats = $course->max_seats ?? 100;
                        $availableSeats = $course->seats_available;
                        $percentage = ($maxSeats > 0) ? ($availableSeats / $maxSeats) * 100 : 100;
                    @endphp
                    <div class="progress mt-2" style="height: 6px;">
                        <div class="progress-bar bg-{{ $percentage > 70 ? 'success' : ($percentage > 30 ? 'warning' : 'danger') }}"
                             role="progressbar"
                             style="width: {{ $percentage }}%"
                             aria-valuenow="{{ $availableSeats }}"
                             aria-valuemin="0"
                             aria-valuemax="{{ $maxSeats }}">
                        </div>
                    </div>
                </span>
            </div>
            
            
            @if($course->image)
            <div class="detail-item">
                <span class="detail-label">Course Image:</span>
                <span class="detail-value">
                    <img src="{{ asset('storage/' . $course->image) }}" alt="Course Image" class="course-image" style="max-width: 300px;">
                </span>
            </div>
            @endif
            
            <div class="detail-item">
                <span class="detail-label">Instructor:</span>
                <span class="detail-value">
                    <div class="instructor-info">
                        @if($course->instructor->profile_photo)
                            <img src="{{ asset('storage/' . $course->instructor->profile_photo) }}" alt="{{ $course->instructor->name }}" class="instructor-avatar">
                        @else
                            <div class="instructor-avatar bg-secondary d-flex align-items-center justify-content-center text-white">
                                {{ substr($course->instructor->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h5 class="mb-0">{{ $course->instructor->name }}</h5>
                            <small class="text-muted">{{ $course->instructor->email }}</small>
                        </div>
                    </div>
                </span>
            </div>
            
     
            
            <div class="detail-item">
                <span class="detail-label">Created At:</span>
                <span class="detail-value">{{ $course->created_at->format('M d, Y h:i A') }}</span>
            </div>
            
            <div class="detail-item">
                <span class="detail-label">Last Updated:</span>
                <span class="detail-value">{{ $course->updated_at->format('M d, Y h:i A') }}</span>
            </div>
        </div>
        
   
    </div>
</div>
@endsection