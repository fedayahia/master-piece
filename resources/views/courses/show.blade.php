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

    /* Rating Stars */
    .rating-input.ltr-stars {
        direction: ltr;
        display: inline-flex;
        flex-direction: row-reverse;
        gap: 5px;
    }

    .rating-input.ltr-stars input[type="radio"] {
        display: none;
    }

    .rating-input.ltr-stars label {
        cursor: pointer;
        font-size: 1.5rem;
        color: #ddd;
        transition: color 0.2s;
    }

    .rating-input.ltr-stars input[type="radio"]:checked ~ label {
        color: #ddd;
    }

    .rating-input.ltr-stars input[type="radio"]:checked + label,
    .rating-input.ltr-stars input[type="radio"]:checked ~ label ~ label {
        color: #ffc107;
    }

    .rating-input.ltr-stars label:hover,
    .rating-input.ltr-stars label:hover ~ label {
        color: #ffc107;
    }

    .ltr-stars {
        font-size: 1.2rem;
    }

    /* Accordion Styles */
    .session-card .accordion-button {
        background-color: rgba(255, 255, 255, 0.95);
        box-shadow: none;
        border-radius: 8px !important;
    }

    .session-card .accordion-button:not(.collapsed) {
        background-color: rgba(255, 255, 255, 0.98);
        box-shadow: none;
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }

    .session-card .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0,0,0,.125);
    }

    .session-card .accordion-body {
        background-color: rgba(255, 255, 255, 0.98);
        border-bottom-left-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
    }

    .session-card .accordion-item {
        background-color: transparent;
        border: none;
    }

    /* Session details list */
    .session-card .list-unstyled li {
        padding: 0.25rem 0;
    }

    .session-card .list-unstyled i {
        width: 20px;
        text-align: center;
        color: var(--primary);
    }

    /* Right-to-Left Stars Rating Style */
    .rating-input.rtl-stars {
        display: flex;
        direction: rtl;
        unicode-bidi: bidi-override;
        gap: 5px;
    }
    .rating-input.rtl-stars input[type="radio"] {
        display: none;
    }
    .rating-input.rtl-stars label {
        cursor: pointer;
        font-size: 1.5rem;
        color: #ddd;
        transition: color 0.2s;
    }
    .rating-input.rtl-stars input[type="radio"]:checked ~ label {
        color: #ffc107;
    }
    .rating-input.rtl-stars label:hover,
    .rating-input.rtl-stars label:hover ~ label {
        color: #ffc107;
    }
    .rtl-stars {
        font-size: 1.2rem;
        direction: rtl;
        unicode-bidi: bidi-override;
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

@if($errors->any()))
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
                        <div class="alert alert-warning d-flex align-items-center gap-2" role="alert" style="width: 300px">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div><strong>Sorry!</strong> All seats are booked.</div>
                        </div>
                    @elseif ($userBooking)
                        <div class="alert alert-info d-flex flex-column gap-1" role="alert" style="width: 400px">
                            <div><i class="fas fa-info-circle me-1"></i> <strong>Note:</strong> You already booked this course.</div>
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
                    <a href="{{ route('login') }}" class="btn btn-light text-primary px-4 py-2">
                        <i class="fas fa-sign-in-alt me-2"></i> Login to Book
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Course Description -->
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
            <div class="session-card">
                <div class="accordion" id="sessionAccordion{{ $session->id }}">
                    <div class="accordion-item border-0">
                        <h2 class="accordion-header" id="heading{{ $session->id }}">
                            <button class="accordion-button collapsed p-4" type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#collapse{{ $session->id }}" 
                                    aria-expanded="false" 
                                    aria-controls="collapse{{ $session->id }}">
                                <div class="d-flex justify-content-between w-100 align-items-center">
                                    <div>
                                        <h5 class="fw-bold mb-0">Session {{ $loop->iteration }}: {{ $session->title }}</h5>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-day me-1"></i>
                                            {{ \Carbon\Carbon::parse($session->start_date)->format('F j, Y h:i A') }}
                                        </small>
                                    </div>
                                    <span class="badge bg-primary seats-badge">
                                        {{ $session->duration }} hours
                                    </span>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse{{ $session->id }}" class="accordion-collapse collapse" 
                             aria-labelledby="heading{{ $session->id }}" 
                             data-bs-parent="#sessionAccordion{{ $session->id }}">
                            <div class="accordion-body pt-0">
                                @if($session->description)
                                    <p class="text-muted mb-3">{{ $session->description }}</p>
                                @endif
                
                                <ul class="list-unstyled mb-3 text-muted">
                                    <li class="mb-2">
                                        <i class="fas fa-calendar-day me-2"></i>
                                        <strong>Date:</strong> 
                                        {{ \Carbon\Carbon::parse($session->start_date)->format('F j, Y h:i A') }} -
                                        {{ \Carbon\Carbon::parse($session->end_date)->format('h:i A') }}                                    
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-clock me-2"></i>
                                        <strong>Duration:</strong> {{ $session->duration }} hours
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-signal me-2"></i>
                                        <strong>Mode:</strong> {{ ucfirst($session->session_mode) }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-chair me-2"></i>
                                        Total Seats: {{ $session->max_seats }}
                                    </li>
                                    @if($session->location)
                                    <li class="mb-2">
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        <strong>Location:</strong> {{ $session->location }}
                                    </li>
                                    @endif
                                    @if($session->zoom_link)
                                    <li class="mb-2">
                                        <i class="fas fa-video me-2"></i>
                                        <strong>Zoom Link:</strong> 
                                        <a href="{{ $session->zoom_link }}" target="_blank" class="text-primary">
                                            Join Session
                                        </a>
                                    </li>
                                    @endif
                                    @if($session->materials)
                                    <li class="mb-2">
                                        <i class="fas fa-file-alt me-2"></i>
                                        <strong>Materials:</strong> 
                                        <a href="{{ asset('storage/session_materials/' . $session->materials) }}" 
                                           target="_blank" 
                                           class="text-primary">
                                            Download
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                                
                                @if($session->additional_notes)
                                <div class="alert alert-light border mt-3">
                                    <h6><i class="fas fa-sticky-note me-2"></i> Instructor Notes</h6>
                                    <p class="mb-0">{{ $session->additional_notes }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Reviews Section -->
    @auth
    <div class="card shadow-sm mt-4" id="reviews-section">
        <div class="card-header bg-white">
            <h4 class="mb-0"><i class="fas fa-star me-2 text-primary"></i> Course Reviews</h4>
        </div>
        <div class="card-body">
            @php
              $hasBooking = \App\Models\Booking::where('user_id', auth()->id())
                ->where('booking_for_type', 'course')
                ->where('booking_for_id', $course->id)
                ->exists();


                    $courseEnded = \Carbon\Carbon::parse(
                   optional($course->sessions->sortByDesc('created_at')->first())->end_date
                    )->isPast();


                $alreadyReviewed = auth()->user()->reviews()->where('course_id', $course->id)->exists();
            @endphp

            @if($hasBooking && $courseEnded && !$alreadyReviewed)
                <div class="mb-4 p-3 border rounded">
                    <h5>Add Your Review</h5>
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">

                        <!-- Rating Stars (Right to Left) -->
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div class="rating-input rtl-stars">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }}>
                                    <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                @endfor
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="review" class="form-label">Your Review</label>
                            <textarea class="form-control" name="comment" rows="3" required>{{ old('comment') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i> Submit Review
                        </button>
                    </form>
                </div>
            @elseif($alreadyReviewed)
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Thank you for reviewing this course!
                </div>
            @elseif(!$hasBooking)
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-circle"></i> You can only review this course if you have booked it.
                </div>
            @elseif(!$courseEnded)
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-circle"></i> You can only leave a review after the course ends.
                </div>
            @endif

            <!-- Existing Reviews -->
            <div class="reviews-list">
                @forelse($course->reviews as $review)
                    <div class="review-item border-bottom pb-3 mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <img src="{{ asset('storage/profile_images/' . $review->user->image) }}" class="rounded-circle me-2" width="40">
                            <div>
                                <h6 class="mb-0">{{ $review->user->name }}</h6>
                                <div class="rtl-stars">
                                    @for($i = 5; $i >= 1; $i--)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <small class="text-muted ms-auto">
                                {{ $review->created_at ? $review->created_at->diffForHumans() : 'Unknown' }}
                            </small>
                        </div>
                        @if($review->comment)
                            <p class="mb-0 mt-2">{{ $review->comment }}</p>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-comment-alt fa-2x mb-2"></i>
                        <p class="mb-0">No reviews yet. Be the first to review this course!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    @endauth
</div>
@endsection