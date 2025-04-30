@extends('admin.layouts.app')

@section('title', 'Booking Details')

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

    .section-header {
        color: var(--primary);
        margin-bottom: 20px;
        font-weight: 600;
        border-bottom: 2px solid var(--secondary);
        padding-bottom: 10px;
    }

    .booking-card {
        border-radius: 8px;
        overflow: hidden;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .detail-item {
        border-left: none;
        border-right: none;
        padding: 1rem;
        display: flex;
        flex-wrap: wrap;
    }

    .detail-item:first-child {
        border-top: none;
    }

    .detail-label {
        font-weight: 600;
        color: #495057;
        min-width: 120px;
        margin-bottom: 5px;
    }

    .detail-value {
        color: #212529;
        flex: 1;
        min-width: 0;
    }

    .status-badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        border-radius: 0.25rem;
        display: inline-block;
    }

    .status-pending {
        background-color: #ffc107;
        color: #212529;
    }

    .status-confirmed {
        background-color: var(--primary);
        color: white;
    }

    .status-cancelled {
        background-color: var(--danger);
        color: white;
    }

    .status-completed {
        background-color: var(--success);
        color: white;
    }

    .btn {
        padding: 0.5rem 1rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .action-buttons {
        margin-top: 1.5rem;
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .user-avatar {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
    }

    /* Responsive adjustments */
    @media (max-width: 1199.98px) {
        .container {
            padding: 20px;
        }
    }

    @media (max-width: 991.98px) {
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        
        .detail-label {
            min-width: 100px;
        }
    }

    @media (max-width: 767.98px) {
        .container {
            padding: 15px;
        }
        
        .detail-item {
            flex-direction: column;
            padding: 0.75rem;
        }
        
        .detail-label {
            min-width: 100%;
            margin-bottom: 5px;
        }
        
        .detail-value {
            min-width: 100%;
            padding-left: 0;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .action-buttons .btn {
            width: 100%;
            justify-content: center;
        }
        
        .user-avatar {
            width: 70px;
            height: 70px;
        }
    }

    @media (max-width: 575.98px) {
        .container {
            padding: 15px;
        }
        
        .section-header h2 {
            font-size: 1.3rem;
        }
        
        .detail-item {
            padding: 0.75rem 0.5rem;
        }
        
        .btn {
            padding: 0.5rem;
            font-size: 0.9rem;
        }
        
        .btn i {
            margin-right: 5px !important;
        }
    }
</style>
<div class="container">
    <!-- Header Section -->
    <div class="section-header d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div>
            <h2 class="mb-1">Booking Details #{{ $booking->id }}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Bookings</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Details</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

 <!-- Booking Details Card -->
 <div class="card detail-card mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Booking Information</h5>
    </div>
    <div class="card-body p-0">
        <ul class="list-group list-group-flush">
            <li class="list-group-item detail-item">
                <span class="detail-label">Booking ID:</span>
                <span class="detail-value">#{{ $booking->id }}</span>
            </li>
            <li class="list-group-item detail-item">
                <span class="detail-label">User:</span>
                <span class="detail-value">
                    {{ $booking->user->name ?? 'Not available' }}
                    @if($booking->user)
                    ({{ $booking->user->email }})
                    @endif
                </span>
            </li>
            <li class="list-group-item detail-item">
                <span class="detail-label">Booking For:</span>
                <span class="detail-value">
                    @if($booking->booking_for_type === 'Course')
                        Course - {{ $booking->course_title ?? 'Not available' }}
                    @elseif($booking->booking_for_type === 'PrivateSession')
                        Private Session - {{ $booking->session_title ?? 'Not available' }}
                    @else
                        Not available
                    @endif
                </span>
            </li>
            <li class="list-group-item detail-item">
                <span class="detail-label">Seat Number:</span>
                <span class="detail-value">
                    {{ $booking->seat_number ?? 'Not specified' }}
                </span>
            </li>
            <li class="list-group-item detail-item">
                <span class="detail-label">Status:</span>
                <span class="detail-value">
                    <span class="status-badge status-{{ $booking->status }}">
                        {{ $booking->status == 'enrolled' ? 'Enrolled' : 'Not Enrolled' }}
                    </span>
                </span>
            </li>
            <li class="list-group-item detail-item">
                <span class="detail-label">Booking Date:</span>
                <span class="detail-value">
                    <i class="far fa-clock me-1"></i>
                    {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d H:i') : 'Not available' }}
                </span>
            </li>
        </ul>
    </div>
</div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-between mt-4">
  
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list me-1"></i> All Bookings
        </a>
    </div>
</div>
@endsection