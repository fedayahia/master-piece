@extends('layouts.master')

@section('content')

<style>
    :root {
        --primary: #6c5ce7;
        --secondary: #a29bfe;
        --dark: #2d3436;
        --light: #f5f6fa;
        --accent: #fd79a8;
        --success: #00b894;
        --warning: #fdcb6e;
        --danger: #d63031;
    }
    
    /* Flash Messages */
    .alert-booking {
        border-radius: 8px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid;
    }
    
    .alert-booking.alert-success {
        background-color: rgba(0, 184, 148, 0.1);
        border-left-color: #00b894;
        color: #00b894;
    }
    
    .alert-booking.alert-danger {
        background-color: rgba(214, 48, 49, 0.1);
        border-left-color: #d63031;
        color: #d63031;
    }
    
    /* Hero Section */
    .course-hero {
        /* background: var(--accent); */
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(108, 92, 231, 0.3);
        overflow: hidden;
        position: relative;
        z-index: 1;
        color: white;
    }

    .course-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        z-index: -1;
    }

    .course-hero img {
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .course-hero img:hover {
        transform: scale(1.02);
    }

    /* Session Cards */
    .session-card {
        background: rgba(255, 255, 255, 0.95);
        border-left: 5px solid var(--accent);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
        border-radius: 8px;
    }

    .session-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .session-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: var(--accent);
    }

    /* Info Cards */
    .info-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 12px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        height: 100%;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .info-card i {
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 2.5rem;
        margin-bottom: 15px;
    }

    /* Section Headers */
    .section-header {
        position: relative;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .section-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--accent));
        border-radius: 3px;
    }

    /* Seats Badge */
    .seats-badge {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .course-hero {
            text-align: center;
        }
        
        .course-hero img {
            margin-bottom: 20px;
            max-height: 250px;
            object-fit: cover;
        }
    }
</style>

<!-- Flash Messages -->
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i>
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Course Hero Section -->
<div class="container py-4">
    <div class="course-hero p-4 mb-4">
        <div class="row align-items-center">
            <div class="col-md-5">
                <img src="{{ asset('storage/courses/' . $course->image) }}" alt="{{ $course->title }}" class="img-fluid rounded">
            </div>
            <div class="col-md-7 p-4">
                <h1 class="display-5 fw-bold mb-3">{{ $course->title }}</h1>
                <div class="d-flex align-items-center mb-3">
                    <div>
                        <h6 class="mb-0">{{ $course->instructor->name }}</h6>
                        <small>Instructor</small>
                    </div>
                </div>

                @auth
                    @php
                        $userBooking = \App\Models\Booking::where('user_id', auth()->id())
                            ->where('booking_for_type', 'Course')
                            ->where('booking_for_id', $course->id)
                            ->where('status', 'enrolled')
                            ->latest()
                            ->first();
                    @endphp

                    @if ($course->seats_available <= 0)
                        <div class="alert alert-warning d-flex align-items-center gap-2" role="alert" style="width: 300PX">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div><strong>Sorry!</strong> All seats are booked.</div>
                        </div>
                    @elseif ($userBooking)
                        <div class="alert alert-info d-flex flex-column gap-1" role="alert" style="width: 400PX">
                            <div><i class="fas fa-info-circle me-1"></i> <strong>Note:</strong> You already booked this course.</div>
                            {{-- <div><i class="fas fa-receipt me-1"></i> <strong>Booking Code:</strong> {{ $userBooking->seat_number }}</div> --}}
                            <div><i class="fas fa-calendar-check me-1"></i> <strong>Booking Date:</strong> {{ \Carbon\Carbon::parse($userBooking->booking_date)->format('F j, Y h:i A') }}</div>
                        </div>
                    @else
                        <form action="{{ route('checkout.billing') }}" method="GET" class="d-inline">
                            <input type="hidden" name="item_id" value="{{ $course->id }}">
                            <input type="hidden" name="type" value="course">
                            <button type="submit" class="btn btn-light text-primary fw-semibold px-3 py-3 rounded">
                                <i class="fas fa-ticket-alt me-1 small"></i> Book Now
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light px-4 py-2">
                        <i class="fas fa-sign-in-alt me-2"></i> Login to Book
                    </a>
                @endauth

            </div>
        </div>
    </div>



    <!-- Course Content -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h4 class="mb-0 section-header">
                <i class="fas fa-book-open me-2"></i> Course Description
            </h4>
        </div>
        <div class="card-body">
            <p class="lead">{{ $course->short_description }}</p>
            <div class="mt-4">{{ $course->long_description }}</div>
            
            <div class="row mt-4">
                <div class="col-md-4 mb-3">
                    <div class="info-card text-center p-4">
                        <i class="fas fa-clock"></i>
                        <h5>Duration</h5>
                        <p class="mb-0">{{ $course->duration }} Hours</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="info-card text-center p-4">
                        <i class="fas fa-certificate"></i>
                        <h5>Certificate</h5>
                        <p class="mb-0">Upon Completion</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="info-card text-center p-4">
                        <i class="fas fa-users"></i>
                        <h5>Seats Available</h5>
                        <p class="mb-0">{{ $course->seats_available }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Sessions -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h4 class="mb-0 section-header">
                <i class="fas fa-calendar-alt me-2"></i> Course Sessions
            </h4>
        </div>
        <div class="card-body">
            @foreach($course->sessions as $session)
            @php
                $seatsLeft = $session->max_seats - ($session->bookings_count ?? 0);
            @endphp
            <div class="session-card p-4">
                <div class="d-flex justify-content-between align-items-start flex-wrap">
                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-2">Session {{ $loop->iteration }}: {{ $session->title }}</h5>
        
                        {{-- وصف الجلسة --}}
                        @if($session->description)
                            <p class="text-muted mb-3">{{ $session->description }}</p>
                        @endif
        
                        <ul class="list-unstyled mb-3 text-muted">
                            <li class="mb-2">
                                <i class="fas fa-calendar-day me-2"></i>
                                {{ \Carbon\Carbon::parse($session->start_date)->format('F j, Y') }} -
                                {{ \Carbon\Carbon::parse($session->end_date)->format('F j, Y') }}
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-clock me-2"></i>
                                Duration: {{ $session->duration }} hours
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-signal me-2"></i>
                                Mode: {{ ucfirst($session->session_mode) }}
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-chair me-2"></i>
                                Total Seats: {{ $session->max_seats }}
                            </li>
                        </ul>
                        
        
                        
                    </div>
                </div>
            </div>
        @endforeach
        
        
        </div>
    </div>
</div>

@endsection