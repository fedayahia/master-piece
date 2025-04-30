@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#28a745" class="bi bi-check-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                        </svg>
                    </div>
                    
                    <h2 class="mb-3">Booking Confirmed!</h2>
                    
                    <p class="lead mb-4">
                        Thank you for booking your private session. We've sent the details to your email.
                    </p>
                    
                    <div class="border p-4 rounded mb-4 text-start">
                        <h5 class="mb-3">Session Details</h5>
                        <p><strong>Session:</strong> {{ $booking->bookable->title }}</p>
                        <p><strong>Instructor:</strong> {{ $booking->bookable->instructor->name }}</p>
                        <p><strong>Date & Time:</strong> {{ $booking->booking_date->format('l, F j, Y \a\t h:i A') }}</p>
                        <p><strong>Amount Paid:</strong> {{ number_format($booking->bookable->price, 2) }} JD</p>
                    </div>
                    
                    <a href="{{ route('dashboard') }}" class="btn btn-primary px-4">
                        Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection