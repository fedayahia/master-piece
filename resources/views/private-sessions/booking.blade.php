@extends('layouts.master')

@section('content')
<div class="container py-5">
    <div class="booking-card bg-white rounded-lg shadow-sm p-0 overflow-hidden">
        <!-- Header -->
        <div class="booking-header p-4 border-bottom bg-light-primary">
            <h2 class="text-dark mb-0 fw-semibold">
                <i class="fas fa-calendar-check me-2"></i> Book a Session
            </h2>
        </div>
        
        <!-- Main Content - Split into Two Columns -->
        <div class="row g-0">
            <!-- Left Column - Session Info -->
            <div class="col-md-6 p-4 border-end">
                <div class="d-flex align-items-center mb-4">
                    {{-- <img src="{{ $session->instructor->profile_photo_url }}" 
                         class="rounded-circle me-3 border border-3 border-primary" 
                         width="60" 
                         alt="Instructor"> --}}
                    <div class="flex-grow-1">
                        <h5 class="mb-1 fw-semibold">{{ $session->title }}</h5>
                        <p class="text-muted mb-0">
                            <i class="fas fa-user-tie me-1"></i> {{ $session->instructor->name }}
                        </p>
                    </div>
                    <div class="ms-auto bg-light-success p-2 rounded text-center">
                        <span class="text-success fw-bold d-block">{{ number_format($session->price, 2) }} JOD</span>
                        <small class="text-muted">Per session</small>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-light-primary p-2 rounded me-3">
                            <i class="far fa-clock text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">Duration</h6>
                            <p class="text-muted mb-0">{{ $session->duration }} Minutes</p>
                        </div>
                    </div>
                    
                    @if($session->description)
                    <div class="bg-light p-3 rounded">
                        <h6 class="fw-semibold mb-2">
                            <i class="fas fa-info-circle me-1 text-primary"></i> Description
                        </h6>
                        <p class="text-secondary mb-0">{{ $session->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Right Column - Booking Form -->
            <div class="col-md-6">
                <form action="{{ route('private-sessions.storeSelectedTime') }}" method="POST">
                    @csrf
                    <input type="hidden" name="session_id" value="{{ $session->id }}">
                    <input type="hidden" name="instructor_id" value="{{ $session->instructor_id }}">
                    <input type="hidden" name="price" value="{{ $session->price }}">

                    <!-- Display Alert if Booking is Duplicate -->
                    @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    </div>
                    @endif

                    <div class="p-4">
                        <h5 class="mb-3 fw-semibold text-primary">
                            <i class="far fa-calendar-alt me-2"></i> Choose a Time Slot
                        </h5>
                        
                        <div class="time-slots-container">
                            @foreach($availableSlots as $slot)
                            @php
                                $slotTime = \Carbon\Carbon::parse($slot['datetime']);
                                $isSoon = $slotTime->diffInHours(now()) < 2;
                                $isAvailable = $slot['is_available'] ?? true;
                            @endphp
                            <div class="mb-2">
                                <input type="radio" name="available_time_id" 
                                       id="slot-{{ $loop->index }}" 
                                       value="{{ $slot['id'] }}" 
                                       class="d-none"
                                       {{ !$isAvailable || $isSoon ? 'disabled' : '' }}>
                                <label for="slot-{{ $loop->index }}" 
                                       class="time-slot d-block p-3 rounded border cursor-pointer mb-0 
                                              {{ !$isAvailable ? 'bg-light' : 'hover:border-primary' }}
                                              {{ $isSoon ? 'opacity-75' : '' }}">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold">{{ $slotTime->translatedFormat('l, d M Y') }}</div>
                                            <div class="badge bg-light-primary text-primary mt-1">
                                                {{ $slotTime->format('h:i A') }} - {{ $slot['end_time'] }}
                                            </div>
                                        </div>
                                        @if(!$isAvailable)
                                        <span class="badge bg-light-danger text-danger">
                                            <i class="fas fa-times-circle me-1"></i> Booked
                                        </span>
                                        @elseif($isSoon)
                                        <span class="badge bg-light-warning text-warning">
                                            <i class="fas fa-exclamation-circle me-1"></i> Soon
                                        </span>
                                        @else
                                        <span class="badge bg-light-success text-success">
                                            <i class="fas fa-check-circle me-1"></i> Available
                                        </span>
                                        @endif
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="p-4 border-top">
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold">
                            <i class="fas fa-calendar-plus me-2"></i> Confirm Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.booking-card {
    max-width: 1000px; /* Increased width to accommodate two columns */
    margin: 0 auto;
    border: 1px solid #e9ecef;
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.05);
}

.booking-header {
    background-color: rgba(13, 110, 253, 0.05);
    border-bottom: 2px solid rgba(13, 110, 253, 0.1) !important;
}

.time-slot {
    transition: all 0.2s ease;
    border: 1px solid #dee2e6;
}

.time-slot:hover {
    border-color: #0d6efd !important;
    background-color: rgba(13, 110, 253, 0.03);
}

input[type="radio"]:checked + .time-slot {
    background-color: rgba(13, 110, 253, 0.05);
    border-color: #0d6efd !important;
    box-shadow: 0 0 0 1px #0d6efd;
}

.bg-light-primary {
    background-color: rgba(13, 110, 253, 0.1);
}

.bg-light-success {
    background-color: rgba(25, 135, 84, 0.1);
}

.bg-light-danger {
    background-color: rgba(220, 53, 69, 0.1);
}

.bg-light-warning {
    background-color: rgba(255, 193, 7, 0.1);
}

.hover\:border-primary:hover {
    border-color: #0d6efd !important;
}

.opacity-75 {
    opacity: 0.75;
}

.time-slots-container {
    max-height: 400px;
    overflow-y: auto;
    padding-right: 10px;
}

/* Custom scrollbar for time slots */
.time-slots-container::-webkit-scrollbar {
    width: 6px;
}

.time-slots-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.time-slots-container::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.time-slots-container::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Highlight selected time slot
    const radioInputs = document.querySelectorAll('input[type="radio"]');
    radioInputs.forEach(input => {
        input.addEventListener('change', function() {
            document.querySelectorAll('.time-slot').forEach(label => {
                label.classList.remove('border-primary', 'bg-light-primary');
            });
            
            if (this.checked) {
                this.nextElementSibling.classList.add('border-primary', 'bg-light-primary');
            }
        });
    });
    
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const selected = document.querySelector('input[name="available_time_id"]:checked');
        if (!selected) {
            e.preventDefault();
            alert('Please select a time slot before booking');
        }
    });
});
</script>
@endsection