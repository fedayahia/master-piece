@extends('layouts.master')

@section('title', 'Booking Details')

@section('content')
<style>
    .booking-container {
        background-color: #f5f5f5;
        min-height: 100vh;
        padding: 2rem 0;
    }

    .booking-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .booking-title {
        background-color: #4d65f9;
        color: #fff;
        padding: 1rem;
        border-radius: 6px 6px 0 0;
        margin-bottom: 1rem;
        font-size: 1.25rem;
    }

    .detail-item {
        margin-bottom: 1rem;
    }

    .detail-label {
        font-weight: bold;
        color: #555;
    }

    .status-badge {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        border-radius: 50px;
        background-color: #e0f2f1;
        color: #00796b;
        font-size: 0.85rem;
    }

    .btn-view-course {
        background: #ff4880;
        color: white;
        padding: 0.6rem 1.2rem;
        border: none;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.3s ease;
    }

    .btn-view-course:hover {
        background: #e04170;
    }
</style>

<div class="booking-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="booking-card">
                    <div class="booking-title">Booking Confirmation</div>

                    <div class="detail-item">
                        <div class="detail-label">Course:</div>
                        <div>{{ $course->title ?? 'Course Title Unavailable' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Student:</div>
                        <div>{{ $booking->user->name ?? 'Unavailable' }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Booking Date:</div>
                        <div>{{ \Carbon\Carbon::parse($booking->created_at)->format('F j, Y \a\t h:i A') }}</div>
                    </div>

                    @if($booking->start_date)
                    <div class="detail-item">
                        <div class="detail-label">Start Date:</div>
                        <div>{{ \Carbon\Carbon::parse($booking->start_date)->format('F j, Y') }}</div>
                    </div>
                    @endif

                    @if($booking->end_date)
                    <div class="detail-item">
                        <div class="detail-label">End Date:</div>
                        <div>{{ \Carbon\Carbon::parse($booking->end_date)->format('F j, Y') }}</div>
                    </div>
                    @endif

                    <div class="detail-item">
                        <div class="detail-label">Status:</div>
                        <div class="status-badge">
                            {{ $booking->status ?? 'Not specified' }}
                        </div>
                    </div>
                    <a href="{{ route('checkout.processBilling') }}" class="btn-view-course">
                        Go to Checkout
                    </a>
                    
                    
                    
                    

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
