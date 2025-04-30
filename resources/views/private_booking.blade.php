@extends('layouts.master')

@section('content')
<div class="container py-5">
    <div class="booking-card bg-white rounded-lg shadow-sm p-0">
        <!-- Header -->
        <div class="booking-header p-4 border-bottom">
            <h2 class="text-dark mb-0">Book a Session</h2>
        </div>
        
        <!-- Session Info -->
        <div class="p-4">
            <div class="d-flex align-items-center mb-4">
                <img src="{{ $session->instructor->profile_photo_url }}" 
                     class="rounded-circle me-3" width="50" alt="Instructor">
                <div>
                    <h5 class="mb-1">{{ $session->title }}</h5>
                    <p class="text-muted mb-0">with {{ $session->instructor->name }}</p>
                </div>
                <div class="ms-auto bg-light-success p-2 rounded">
                    <span class="text-success fw-bold">{{ number_format($session->price, 2) }} JD</span>
                </div>
            </div>
            
            <div class="mb-4">
                <p class="mb-2"><i class="far fa-clock me-2"></i> Duration: {{ $session->duration }} minutes</p>
                @if($session->description)
                <p class="text-secondary">{{ $session->description }}</p>
                @endif
            </div>
        </div>
        
        <!-- Booking Form -->
        <form action="{{ route('private_sessions.store') }}" method="POST" class="p-4 border-top">
            @csrf
            <input type="hidden" name="instructor_id" value="{{ $session->instructor_id }}">
            <input type="hidden" name="price" value="{{ $session->price }}">
            <input type="hidden" name="session_id" value="{{ $session->id }}">
            
            <h5 class="mb-3">Choose a suitable time</h5>
            
            <div class="row g-2">
                @foreach($availableSlots as $slot)
                @php
                    $slotTime = \Carbon\Carbon::parse($slot['datetime']);
                    $slotEnd = $slotTime->copy()->addMinutes($session->duration);
                    $isSoon = $slotTime->diffInHours(now()) < 2;
                @endphp
                <div class="col-md-6">
                    <input type="radio" name="session_date" 
                           id="slot-{{ $loop->index }}" 
                           value="{{ $slot['datetime'] }}" 
                           class="d-none"
                           {{ $isSoon ? 'disabled' : '' }}>
                    <label for="slot-{{ $loop->index }}" 
                           class="time-slot w-100 text-center p-3 rounded border cursor-pointer">
                        <div class="fw-bold">{{ $slotTime->translatedFormat('l') }}</div>
                        <div class="text-muted small mb-2">{{ $slotTime->translatedFormat('d M Y') }}</div>
                        <div class="badge bg-light-primary text-primary">
                            {{ $slotTime->format('h:i A') }} - {{ $slotEnd->format('h:i A') }}
                        </div>
                    </label>
                </div>
                @endforeach
            </div>
            
            <button type="submit" class="btn btn-primary w-100 mt-4 py-2">
                Confirm Booking
            </button>
        </form>
    </div>
</div>

<style>
.booking-card {
    max-width: 600px;
    margin: 0 auto;
    border: 1px solid #eee;
}

.time-slot {
    transition: all 0.2s;
}

.time-slot:hover {
    border-color: #0d6efd !important;
}

input[type="radio"]:checked + .time-slot {
    background-color: #f8f9fa;
    border-color: #0d6efd !important;
    box-shadow: 0 0 0 1px #0d6efd;
}

.cursor-pointer {
    cursor: pointer;
}
</style>
@endsection