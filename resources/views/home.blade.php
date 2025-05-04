@extends('layouts.master')

@section('content')

<!-- Hero Start -->
<div class="container-fluid py-5 hero-header wow fadeIn" data-wow-delay="0.1s">
    <div class="container  py-5">
        <div class="row g-5">
            <div class="col-lg-7 col-md-12">
                <h1 class="mb-3 text-white">Smart Parenting Starts Here</h1>
                <h1 class="mb-5 display-1 text-white">Learn, Grow, and Thrive Together</h1>
                <a href="{{ route('courses.index') }}" class="btn btn-primary px-4 py-3 px-md-5  me-4 btn-border-radius">Get Started</a>
                {{-- <a href="{{ route('about') }}" class="btn btn-primary px-4 py-3 px-md-5 btn-border-radius">Learn More</a> --}}
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->

<!-- About Start -->
<div class="container-fluid py-5 about bg-light">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5 wow fadeIn" data-wow-delay="0.1s">
                <div class="video border">
                    {{-- <button type="button" class="btn btn-play" data-bs-toggle="modal" data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal"> --}}
                        <span></span>
                    </button>
                </div>
            </div>
            <div class="col-lg-7 wow fadeIn" data-wow-delay="0.3s">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">About Us</h4>
                <h1 class="text-dark mb-4 display-5">Empowering Parents with Knowledge and Skills to Raise Happy, Healthy Children</h1>
                <p class="text-dark mb-4">
                    Our institution is dedicated to supporting parents and caregivers through high-quality, evidence-based courses that focus on child development, positive parenting, communication skills, and emotional intelligence. We believe that by educating parents, we build stronger families and a brighter future for the next generation.
                </p>
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <h6 class="mb-3"><i class="fas fa-check-circle me-2"></i>Positive Parenting Techniques</h6>
                        <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-primary"></i>Emotional Intelligence Training</h6>
                        <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-secondary"></i>Nutrition and Child Health</h6>
                    </div>
                    <div class="col-lg-6">
                        <h6 class="mb-3"><i class="fas fa-check-circle me-2"></i>Safe Online Practices</h6>
                        <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-primary"></i>Strong Parent-Child Bonds</h6>
                        <h6><i class="fas fa-check-circle me-2 text-secondary"></i>Expert-Led Sessions</h6>
                    </div>
                </div>
                {{-- <a href="#" class="btn btn-primary px-5 py-3 btn-border-radius">Learn More</a> --}}
            </div>
        </div>
    </div>
</div>
<!-- About End -->

<!-- Service Start -->
<div class="container-fluid service py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">What We Do</h4>
            <h1 class="mb-5 display-3">Thank you for joining us on your parenting journey</h1>
        </div>
        <div class="row g-5">
            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeIn" data-wow-delay="0.1s">
                <div class="text-center border-primary border bg-white service-item">
                    <div class="service-content d-flex align-items-center justify-content-center p-4">
                        <div class="service-content-inner">
                            <div class="p-4"><i class="fas fa-gamepad fa-6x text-primary"></i></div>
                            <a href="#" class="h4">Effective Learning & Play</a>
                            <p class="my-3">Education is not limited to books only! We provide you with 
                                strategies that combine play and learning to develop your 
                                child's skills in a fun and interactive way.</p>
                            {{-- <a href="#" class="btn btn-primary text-white px-4 py-2 my-2 btn-border-radius">Read More</a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeIn" data-wow-delay="0.3s">
                <div class="text-center border-primary border bg-white service-item">
                    <div class="service-content d-flex align-items-center justify-content-center p-4">
                        <div class="service-content-inner">
                            <div class="p-4"><i class="fas fa-sort-alpha-down fa-6x text-primary"></i></div>
                            <a href="#" class="h4">Comprehensive Parenting Programs</a>
                            <p class="my-3">From pregnancy to adolescence, we offer expert courses on parenting, child development, and daily challenges.</p>
                            {{-- <a href="#" class="btn btn-primary text-white px-4 py-2 my-2 btn-border-radius">Read More</a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeIn" data-wow-delay="0.5s">
                <div class="text-center border-primary border bg-white service-item">
                    <div class="service-content d-flex align-items-center justify-content-center p-4">
                        <div class="service-content-inner">
                            <div class="p-4"><i class="fas fa-users fa-6x text-primary"></i></div>
                            <a href="#" class="h4">Guidance from Parenting Experts</a>
                            <p class="my-3">
                                A team of experts in parenting, mental health, and nutrition share valuable advice through interactive courses and specialized lectures.</p>
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeIn" data-wow-delay="0.7s">
                <div class="text-center border-primary border bg-white service-item">
                    <div class="service-content d-flex align-items-center justify-content-center p-4">
                        <div class="service-content-inner">
                            <div class="p-4"><i class="fas fa-user-nurse fa-6x text-primary"></i></div>
                            <a href="#" class="h4">Mental & Emotional Well-being</a>
                            <p class="my-3">Learn how to support your child's mental health and boost their confidence, 
                                along with strategies to manage stress and daily parenting challenges.</p>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service End -->
<!-- Courses Start -->
<div class="container-fluid program py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Our Courses</h4>
            <h1 class="mb-5 display-3">Exclusive Parenting & Child Development Courses</h1>
        </div>

        <div class="row g-5 justify-content-center">
            @foreach ($courses as $course)
                <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="program-item rounded">
                        <div class="program-img position-relative">
                            <div class="overflow-hidden img-border-radius">
                                <img src="{{ asset('storage/courses/' . $course->image) }}" alt="{{ $course->title }}" class="img-fluid w-100">
                            </div>
                            <div class="px-9 py-2 bg-primary text-white program-rate text-center" style="direction: ltr; min-width: 110px; padding-left: 12px; padding-right: 12px;">
                                JOD{{ number_format($course->price,2) }}
                            </div>
                            
                            
                            </div>

                        <div class="course-text bg-white px-4 pb-3">
                            <div class="course-text-inner">
                                <a href="{{ route('courses.show', $course->id) }}" class="h4">{{ $course->title }}</a>
                                <p class="mt-3 mb-0">{{ $course->description }}</p>
                            </div>
                        </div>

                        <div class="course-teacher d-flex align-items-center border-top border-primary bg-white px-4 py-3">
                            <img src="{{ asset('storage/instructor/'. $course->instructor->image) }}" class="img-fluid rounded-circle p-2 border border-primary bg-white" alt="Dr. Laila Alattar" style="width: 100px; height: 1=0px;" alt="Instructor">
                            <div class="ms-3">
                                <h6 class="mb-0 text-primary">{{ $course->instructor->name ?? 'Unknown Instructor' }}</h6>
                                <small>Expert Instructor</small>
                            </div>
                        </div>

                        <div class="text-center d-flex align-items-center justify-content-center bg-white py-3">
                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-book btn-sm">Show Details</a>
                        </div>

                        <div class="d-flex justify-content-between px-4 py-2 bg-primary rounded-bottom">
                            <small class="text-white"><i class="fas fa-chair me-1"></i> {{ $course->seats_available }} Seats</small>
                            <small class="text-white"><i class="fas fa-clock me-1"></i> {{ $course->duration }} Hours</small>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="d-inline-block text-center wow fadeIn" data-wow-delay="0.1s" style="margin-top: 50px;">
                <a href="{{ route('courses.index') }}" class="btn btn-primary px-5 py-3 text-white btn-border-radius">View All Programs</a>
            </div>
            
        </div> <!-- Close the row here -->
    </div>
</div>
<!-- Courses End -->








        <!-- Events Start -->
        {{-- <div class="container-fluid events py-5 bg-light">
            <div class="container py-5">
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                    <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Our Events</h4>
                    <h1 class="mb-5 display-3">Our Upcoming Events</h1>
                </div>
                <div class="row g-5 justify-content-center">
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.1s">
                        <div class="events-item bg-primary rounded">
                            <div class="events-inner position-relative">
                                <div class="events-img overflow-hidden rounded-circle position-relative">
                                    <img src="img/event-1.jpg" class="img-fluid w-100 rounded-circle" alt="Image">
                                    <div class="event-overlay">
                                        <a href="img/event-1.jpg" data-lightbox="event-1"><i class="fas fa-search-plus text-white fa-2x"></i></a>
                                    </div>
                                </div>
                                <div class="px-4 py-2 bg-secondary text-white text-center events-rate">29 Nov</div>
                                <div class="d-flex justify-content-between px-4 py-2 bg-secondary">
                                    <small class="text-white"><i class="fas fa-calendar me-1 text-primary"></i> 10:00am - 12:00pm</small>
                                    <small class="text-white"><i class="fas fa-map-marker-alt me-1 text-primary"></i> New York</small>
                                </div>
                            </div>
                            <div class="events-text p-4 border border-primary bg-white border-top-0 rounded-bottom">
                                <a href="#" class="h4">Music & drawing workshop</a>
                                <p class="mb-0 mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed purus consectetur,</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.3s">
                        <div class="events-item bg-primary rounded">
                            <div class="events-inner position-relative">
                                <div class="events-img overflow-hidden rounded-circle position-relative">
                                    <img src="img/event-2.jpg" class="img-fluid w-100 rounded-circle" alt="Image">
                                    <div class="event-overlay">
                                        <a href="img/event-3.jpg" data-lightbox="event-1"><i class="fas fa-search-plus text-white fa-2x"></i></a>
                                    </div>
                                </div>
                                <div class="px-4 py-2 bg-secondary text-white text-center events-rate">29 Nov</div>
                                <div class="d-flex justify-content-between px-4 py-2 bg-secondary">
                                    <small class="text-white"><i class="fas fa-calendar me-1 text-primary"></i> 10:00am - 12:00pm</small>
                                    <small class="text-white"><i class="fas fa-map-marker-alt me-1 text-primary"></i> New York</small>
                                </div>
                            </div>
                            <div class="events-text p-4 border border-primary bg-white border-top-0 rounded-bottom">
                                <a href="#" class="h4">Why need study</a>
                                <p class="mb-0 mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed purus consectetur,</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.5s">
                        <div class="events-item bg-primary rounded">
                            <div class="events-inner position-relative">
                                <div class="events-img overflow-hidden rounded-circle position-relative">
                                    <img src="img/event-3.jpg" class="img-fluid w-100 rounded-circle" alt="Image">
                                    <div class="event-overlay">
                                        <a href="img/event-3.jpg" data-lightbox="event-1"><i class="fas fa-search-plus text-white fa-2x"></i></a>
                                    </div>
                                </div>
                                <div class="px-4 py-2 bg-secondary text-white text-center events-rate">29 Nov</div>
                                <div class="d-flex justify-content-between px-4 py-2 bg-secondary">
                                    <small class="text-white"><i class="fas fa-calendar me-1 text-primary"></i> 10:00am - 12:00pm</small>
                                    <small class="text-white"><i class="fas fa-map-marker-alt me-1 text-primary"></i> New York</small>
                                </div>
                            </div>
                            <div class="events-text p-4 border border-primary bg-white border-top-0 rounded-bottom">
                                <a href="#" class="h4">Child health consciousness</a>
                                <p class="mb-0 mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed purus consectetur,</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Events End-->


        <!-- Blog Start-->
        {{-- <div class="container-fluid blog py-5">
            <div class="container py-5">
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Latest News & Blog</h4>
                    <h1 class="mb-5 display-3">Read Our Latest News & Blog</h1>
                </div>
                <div class="row g-5 justify-content-center">
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.1s">
                        <div class="blog-item rounded-bottom">
                            <div class="blog-img overflow-hidden position-relative img-border-radius">
                                <img src="img/blog-1.jpg" class="img-fluid w-100" alt="Image">
                            </div>
                            <div class="d-flex justify-content-between px-4 py-3 bg-light border-bottom border-primary blog-date-comments">
                                <small class="text-dark"><i class="fas fa-calendar me-1 text-dark"></i> 29 Nov 2023</small>
                                <small class="text-dark"><i class="fas fa-comment-alt me-1 text-dark"></i> Comments (15)</small>
                            </div>
                            <div class="blog-content d-flex align-items-center px-4 py-3 bg-light">
                                <div class="overflow-hidden rounded-circle rounded-top border border-primary">
                                    <img src="img/program-teacher.jpg" class="img-fluid rounded-circle p-2 rounded-top" alt="Image" style="width: 70px; height: 70px; border-style: dotted; border-color: var(--bs-primary) !important;">
                                </div>
                                <div class="ms-3">
                                    <h6 class="text-primary">Mary Mordern</h6>
                                    <p class="text-muted">Baby Care</p>
                                </div>
                            </div>
                            <div class="px-4 pb-4 bg-light rounded-bottom">
                                <div class="blog-text-inner">
                                    <a href="#" class="h4">How to pay attention to your child?</a>
                                    <p class="mt-3 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed purus</p>
                                </div>
                                <div class="text-center">
                                    <a href="#" class="btn btn-primary text-white px-4 py-2 mb-3 btn-border-radius">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.3s">
                        <div class="blog-item rounded-bottom">
                            <div class="blog-img overflow-hidden position-relative img-border-radius">
                                <img src="img/blog-2.jpg" class="img-fluid w-100" alt="Image">
                            </div>
                            <div class="d-flex justify-content-between px-4 py-3 bg-light border-bottom border-primary blog-date-comments">
                                <small class="text-dark"><i class="fas fa-calendar me-1 text-dark"></i> 29 Nov 2023</small>
                                <small class="text-dark"><i class="fas fa-comment-alt me-1 text-dark"></i> Comments (15)</small>
                            </div>
                            <div class="blog-content d-flex align-items-center px-4 py-3 bg-light">
                                <div class="overflow-hidden rounded-circle rounded-top border border-primary">
                                    <img src="img/program-teacher.jpg" class="img-fluid rounded-circle p-2 rounded-top" alt="" style="width: 70px; height: 70px; border-style: dotted; border-color: var(--bs-primary) !important;">
                                </div>
                                <div class="ms-3">
                                    <h6 class="text-primary">Mary Mordern</h6>
                                    <p class="text-muted">Baby Care</p>
                                </div>
                            </div>
                            <div class="px-4 pb-4 bg-light rounded-bottom">
                                <div class="blog-text-inner">
                                    <a href="#" class="h4">Play outdoor sports with your child</a>
                                    <p class="mt-3 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed purus</p>
                                </div>
                                <div class="text-center">
                                    <a href="#" class="btn btn-primary text-white px-4 py-2 mb-3 btn-border-radius">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.5s">
                        <div class="blog-item rounded-bottom">
                            <div class="blog-img overflow-hidden position-relative img-border-radius">
                                <img src="img/blog-3.jpg" class="img-fluid w-100" alt="Image">
                            </div>
                            <div class="d-flex justify-content-between px-4 py-3 bg-light border-bottom border-primary blog-date-comments">
                                <small class="text-dark"><i class="fas fa-calendar me-1 text-dark"></i> 29 Nov 2023</small>
                                <small class="text-dark"><i class="fas fa-comment-alt me-1 text-dark"></i> Comments (15)</small>
                            </div>
                            <div class="blog-content d-flex align-items-center px-4 py-3 bg-light">
                                <div class="overflow-hidden rounded-circle rounded-top border border-primary">
                                    <img src="img/program-teacher.jpg" class="img-fluid rounded-circle p-2 rounded-top" alt="" style="width: 70px; height: 70px; border-style: dotted; border-color: var(--bs-primary) !important;">
                                </div>
                                <div class="ms-3">
                                    <h6 class="text-primary">Mary Mordern</h6>
                                    <p class="text-muted">Baby Care</p>
                                </div>
                            </div>
                            <div class="px-4 pb-4 bg-light rounded-bottom">
                                <div class="blog-text-inner">
                                    <a href="#" class="h4">How to make time for your kids?</a>
                                    <p class="mt-3 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed purus</p>
                                </div>
                                <div class="text-center">
                                    <a href="#" class="btn btn-primary text-white px-4 py-2 mb-3 btn-border-radius">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Blog End-->
        <div class="container-fluid program py-5" style="background-color:#ffff;">
            <div class="container py-5">
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                    <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Private Sessions</h4>
                    <h1 class="mb-5 display-3">Book One-on-One Sessions with Experts</h1>
                </div>
        
                <div class="row g-5 justify-content-center">
                    @foreach($privateSessions as $session)
                        <div class="col-12 col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.1s">
                            <div class="program-item rounded">
                                <div class="program-img position-relative">
                                    <div class="overflow-hidden img-border-radius">
                                        <img src="{{ asset('storage/private_sessions/'.$session->img) }}" alt="{{ $session->title }}" class="img-fluid w-100">
                                    </div>
                                    <div class="px-9 py-2 bg-primary text-white program-rate text-center" style="direction: ltr; min-width: 110px; padding-left: 12px; padding-right: 12px;">
                                        JOD{{ number_format($session->price, 2) }}</div>
                                </div>
        
                                <div class="course-text bg-white px-4 pb-3">
                                    <div class="course-text-inner">
                                        {{-- <a href="{{ route('private_sessions.show', $session->id) }}" class="h4">{{ $session->title }}</a> --}}
                                        <p class="mt-3 mb-0">{{ $session->description }}</p>
                                    </div>
                                </div>
        
                                <div class="course-teacher d-flex align-items-center border-top border-primary bg-white px-4 py-3">
                                    <img src="{{ asset('storage/instructor/'. $session->instructor->image) }}" class="img-fluid rounded-circle p-2 border border-primary bg-white" alt="Dr. Laila Alattar" style="width: 100px; height: 1=0px;" alt="Instructor">

                                    <div class="ms-3">
                                        <h6 class="mb-0 text-primary">{{ $session->instructor->name }}</h6>
                                        <small>Expert Instructor</small>
                                    </div>
                                </div>
        
                                <div class="text-center d-flex align-items-center justify-content-center bg-white py-3">
                                    <a href="{{ route('private-sessions.book', $session->id) }}" class="btn btn-book btn-sm">Book Now</a>
                                </div>
                                
        
                                <div class="d-flex justify-content-between px-4 py-2 bg-primary rounded-bottom">
                                    <small class="text-white"><i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($session->session_date)->format('l, F j, Y') }}</small>
                                    <small class="text-white"><i class="fas fa-clock me-1"></i> Duration: {{ $session->duration }} mins</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
        
                    <div class="d-inline-block text-center wow fadeIn" data-wow-delay="0.1s" style="margin-top: 50px;">
                        <a href="{{ route('private-sessions.index') }}" class="btn btn-primary px-5 py-3 text-white btn-border-radius">View All Private Sessions</a>
                    </div>
        
                    <!-- Pagination -->
                    <div class="d-inline-block text-center wow fadeIn" data-wow-delay="0.1s" style="margin-top: 50px;">
                        {{-- {{ $privateSessions->links() }} <!-- Pagination links --> --}}
                    </div>
                </div> <!-- Close the row here -->
            </div>
        </div>
        
        
        
        <!-- Team Start-->
        <div class="container-fluid team py-5">
            <div class="container py-5">
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Our Team</h4>
                    <h1 class="mb-5 display-3">Meet With Our Expert Teachers</h1>
                </div>
                <div class="row g-5 justify-content-center">
@foreach($users as $user)
<div class="col-md-6 col-lg-4 col-xl-3 wow fadeIn" data-wow-delay="0.1s">
    <div class="team-item border border-primary img-border-radius overflow-hidden">
        <img src="{{ asset('storage/instructor/'. $user->image) }}" class="img-fluid w-100" alt="{{ $user->name }}">

        <div class="team-icon d-flex align-items-center justify-content-center">
            <a class="share btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fas fa-share-alt"></i></a>
            <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fab fa-facebook-f"></i></a>
            <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fab fa-twitter"></i></a>
            <a class="share-link btn btn-primary btn-md-square text-white rounded-circle" href=""><i class="fab fa-instagram"></i></a>
        </div>
        <div class="team-content text-center py-3">
            <h4 class="text-primary">{{ $user->name }}</h4>
            <p class="text-muted mb-2">{{ ucfirst($user->role) }}</p>
        </div>
    </div>
</div>
@endforeach

                
                                
                </div>
            </div>
        </div>
        <!-- Team End-->

        <!-- Events Start -->
        {{-- <div class="container-fluid events py-5 bg-light">
            <div class="container py-5">
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                    <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Our Events</h4>
                    <h1 class="mb-5 display-3">Our Upcoming Events</h1>
                </div>
                <div class="row g-5 justify-content-center">
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.1s">
                        <div class="events-item bg-primary rounded">
                            <div class="events-inner position-relative">
                                <div class="events-img overflow-hidden rounded-circle position-relative">
                                    <img src="img/event-1.jpg" class="img-fluid w-100 rounded-circle" alt="Image">
                                    <div class="event-overlay">
                                        <a href="img/event-1.jpg" data-lightbox="event-1"><i class="fas fa-search-plus text-white fa-2x"></i></a>
                                    </div>
                                </div>
                                <div class="px-4 py-2 bg-secondary text-white text-center events-rate">29 Nov</div>
                                <div class="d-flex justify-content-between px-4 py-2 bg-secondary">
                                    <small class="text-white"><i class="fas fa-calendar me-1 text-primary"></i> 10:00am - 12:00pm</small>
                                    <small class="text-white"><i class="fas fa-map-marker-alt me-1 text-primary"></i> New York</small>
                                </div>
                            </div>
                            <div class="events-text p-4 border border-primary bg-white border-top-0 rounded-bottom">
                                <a href="#" class="h4">Music & drawing workshop</a>
                                <p class="mb-0 mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed purus consectetur,</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.3s">
                        <div class="events-item bg-primary rounded">
                            <div class="events-inner position-relative">
                                <div class="events-img overflow-hidden rounded-circle position-relative">
                                    <img src="img/event-2.jpg" class="img-fluid w-100 rounded-circle" alt="Image">
                                    <div class="event-overlay">
                                        <a href="img/event-3.jpg" data-lightbox="event-1"><i class="fas fa-search-plus text-white fa-2x"></i></a>
                                    </div>
                                </div>
                                <div class="px-4 py-2 bg-secondary text-white text-center events-rate">29 Nov</div>
                                <div class="d-flex justify-content-between px-4 py-2 bg-secondary">
                                    <small class="text-white"><i class="fas fa-calendar me-1 text-primary"></i> 10:00am - 12:00pm</small>
                                    <small class="text-white"><i class="fas fa-map-marker-alt me-1 text-primary"></i> New York</small>
                                </div>
                            </div>
                            <div class="events-text p-4 border border-primary bg-white border-top-0 rounded-bottom">
                                <a href="#" class="h4">Why need study</a>
                                <p class="mb-0 mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed purus consectetur,</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.5s">
                        <div class="events-item bg-primary rounded">
                            <div class="events-inner position-relative">
                                <div class="events-img overflow-hidden rounded-circle position-relative">
                                    <img src="img/event-3.jpg" class="img-fluid w-100 rounded-circle" alt="Image">
                                    <div class="event-overlay">
                                        <a href="img/event-3.jpg" data-lightbox="event-1"><i class="fas fa-search-plus text-white fa-2x"></i></a>
                                    </div>
                                </div>
                                <div class="px-4 py-2 bg-secondary text-white text-center events-rate">29 Nov</div>
                                <div class="d-flex justify-content-between px-4 py-2 bg-secondary">
                                    <small class="text-white"><i class="fas fa-calendar me-1 text-primary"></i> 10:00am - 12:00pm</small>
                                    <small class="text-white"><i class="fas fa-map-marker-alt me-1 text-primary"></i> New York</small>
                                </div>
                            </div>
                            <div class="events-text p-4 border border-primary bg-white border-top-0 rounded-bottom">
                                <a href="#" class="h4">Child health consciousness</a>
                                <p class="mb-0 mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed purus consectetur,</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Events End-->


        <!-- Blog Start-->
        {{-- <div class="container-fluid blog py-5">
            <div class="container py-5">
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Latest News & Blog</h4>
                    <h1 class="mb-5 display-3">Read Our Latest News & Blog</h1>
                </div>
                <div class="row g-5 justify-content-center">
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.1s">
                        <div class="blog-item rounded-bottom">
                            <div class="blog-img overflow-hidden position-relative img-border-radius">
                                <img src="img/blog-1.jpg" class="img-fluid w-100" alt="Image">
                            </div>
                            <div class="d-flex justify-content-between px-4 py-3 bg-light border-bottom border-primary blog-date-comments">
                                <small class="text-dark"><i class="fas fa-calendar me-1 text-dark"></i> 29 Nov 2023</small>
                                <small class="text-dark"><i class="fas fa-comment-alt me-1 text-dark"></i> Comments (15)</small>
                            </div>
                            <div class="blog-content d-flex align-items-center px-4 py-3 bg-light">
                                <div class="overflow-hidden rounded-circle rounded-top border border-primary">
                                    <img src="img/program-teacher.jpg" class="img-fluid rounded-circle p-2 rounded-top" alt="Image" style="width: 70px; height: 70px; border-style: dotted; border-color: var(--bs-primary) !important;">
                                </div>
                                <div class="ms-3">
                                    <h6 class="text-primary">Mary Mordern</h6>
                                    <p class="text-muted">Baby Care</p>
                                </div>
                            </div>
                            <div class="px-4 pb-4 bg-light rounded-bottom">
                                <div class="blog-text-inner">
                                    <a href="#" class="h4">How to pay attention to your child?</a>
                                    <p class="mt-3 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed purus</p>
                                </div>
                                <div class="text-center">
                                    <a href="#" class="btn btn-primary text-white px-4 py-2 mb-3 btn-border-radius">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.3s">
                        <div class="blog-item rounded-bottom">
                            <div class="blog-img overflow-hidden position-relative img-border-radius">
                                <img src="img/blog-2.jpg" class="img-fluid w-100" alt="Image">
                            </div>
                            <div class="d-flex justify-content-between px-4 py-3 bg-light border-bottom border-primary blog-date-comments">
                                <small class="text-dark"><i class="fas fa-calendar me-1 text-dark"></i> 29 Nov 2023</small>
                                <small class="text-dark"><i class="fas fa-comment-alt me-1 text-dark"></i> Comments (15)</small>
                            </div>
                            <div class="blog-content d-flex align-items-center px-4 py-3 bg-light">
                                <div class="overflow-hidden rounded-circle rounded-top border border-primary">
                                    <img src="img/program-teacher.jpg" class="img-fluid rounded-circle p-2 rounded-top" alt="" style="width: 70px; height: 70px; border-style: dotted; border-color: var(--bs-primary) !important;">
                                </div>
                                <div class="ms-3">
                                    <h6 class="text-primary">Mary Mordern</h6>
                                    <p class="text-muted">Baby Care</p>
                                </div>
                            </div>
                            <div class="px-4 pb-4 bg-light rounded-bottom">
                                <div class="blog-text-inner">
                                    <a href="#" class="h4">Play outdoor sports with your child</a>
                                    <p class="mt-3 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed purus</p>
                                </div>
                                <div class="text-center">
                                    <a href="#" class="btn btn-primary text-white px-4 py-2 mb-3 btn-border-radius">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.5s">
                        <div class="blog-item rounded-bottom">
                            <div class="blog-img overflow-hidden position-relative img-border-radius">
                                <img src="img/blog-3.jpg" class="img-fluid w-100" alt="Image">
                            </div>
                            <div class="d-flex justify-content-between px-4 py-3 bg-light border-bottom border-primary blog-date-comments">
                                <small class="text-dark"><i class="fas fa-calendar me-1 text-dark"></i> 29 Nov 2023</small>
                                <small class="text-dark"><i class="fas fa-comment-alt me-1 text-dark"></i> Comments (15)</small>
                            </div>
                            <div class="blog-content d-flex align-items-center px-4 py-3 bg-light">
                                <div class="overflow-hidden rounded-circle rounded-top border border-primary">
                                    <img src="img/program-teacher.jpg" class="img-fluid rounded-circle p-2 rounded-top" alt="" style="width: 70px; height: 70px; border-style: dotted; border-color: var(--bs-primary) !important;">
                                </div>
                                <div class="ms-3">
                                    <h6 class="text-primary">Mary Mordern</h6>
                                    <p class="text-muted">Baby Care</p>
                                </div>
                            </div>
                            <div class="px-4 pb-4 bg-light rounded-bottom">
                                <div class="blog-text-inner">
                                    <a href="#" class="h4">How to make time for your kids?</a>
                                    <p class="mt-3 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed purus</p>
                                </div>
                                <div class="text-center">
                                    <a href="#" class="btn btn-primary text-white px-4 py-2 mb-3 btn-border-radius">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Blog End-->


        <!-- Team Start-->
        {{-- <div class="container-fluid team py-5">
            <div class="container py-5">
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Our Team</h4>
                    <h1 class="mb-5 display-3">Meet With Our Expert Teacher</h1>
                </div>
                <div class="row g-5 justify-content-center">
                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeIn" data-wow-delay="0.1s">
                        <div class="team-item border border-primary img-border-radius overflow-hidden">
                            <img src="img/team-1.jpg" class="img-fluid w-100" alt="">
                            <div class="team-icon d-flex align-items-center justify-content-center">
                                <a class="share btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fas fa-share-alt"></i></a>
                                <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fab fa-twitter"></i></a>
                                <a class="share-link btn btn-primary btn-md-square text-white rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                            <div class="team-content text-center py-3">
                                <h4 class="text-primary">Linda Carlson</h4>
                                <p class="text-muted mb-2">English Teacher</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeIn" data-wow-delay="0.3s">
                        <div class="team-item border border-primary img-border-radius overflow-hidden">
                            <img src="img/team-2.jpg" class="img-fluid w-100" alt="">
                            <div class="team-icon d-flex align-items-center justify-content-center">
                                <a class="share btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fas fa-share-alt"></i></a>
                                <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fab fa-twitter"></i></a>
                                <a class="share-link btn btn-primary btn-md-square text-white rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                            <div class="team-content text-center py-3">
                                <h4 class="text-primary">Linda Carlson</h4>
                                <p class="text-muted mb-2">English Teacher</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeIn" data-wow-delay="0.5s">
                        <div class="team-item border border-primary img-border-radius overflow-hidden">
                            <img src="img/team-3.jpg" class="img-fluid w-100" alt="">
                            <div class="team-icon d-flex align-items-center justify-content-center">
                                <a class="share btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fas fa-share-alt"></i></a>
                                <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fab fa-twitter"></i></a>
                                <a class="share-link btn btn-primary btn-md-square text-white rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                            <div class="team-content text-center py-3">
                                <h4 class="text-primary">Linda Carlson</h4>
                                <p class="text-muted mb-2">English Teacher</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeIn" data-wow-delay="0.7s">
                        <div class="team-item border border-primary img-border-radius overflow-hidden">
                            <img src="img/team-4.jpg" class="img-fluid w-100" alt="">
                            <div class="team-icon d-flex align-items-center justify-content-center">
                                <a class="share btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fas fa-share-alt"></i></a>
                                <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3" href=""><i class="fab fa-twitter"></i></a>
                                <a class="share-link btn btn-primary btn-md-square text-white rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                            </div>
                            <div class="team-content text-center py-3">
                                <h4 class="text-primary">Linda Carlson</h4>
                                <p class="text-muted mb-2">English Teacher</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Team End-->

<!-- Reviews Start -->
<div class="container-fluid testimonial py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Our Reviews</h4>
            <h1 class="mb-5 display-3">What Parents Say About Us</h1>
        </div>

        <div class="owl-carousel testimonial-carousel wow fadeIn" data-wow-delay="0.3s">
            @foreach($reviews as $review)
                <div class="testimonial-item img-border-radius bg-light border border-primary p-4">
                    <div class="p-4 position-relative">
                        <i class="fa fa-quote-right fa-2x text-primary position-absolute" style="top: 15px; right: 15px;"></i>

                        <div class="d-flex align-items-center">
                            <div class="border border-primary bg-white rounded-circle">
                                <img src="{{ asset('storage/profile_images/' . $review->user->image) }}"                                     class="rounded-circle p-2" 
                                     style="width: 80px; height: 80px; border-style: dotted; border-color: var(--bs-primary);" 
                                     alt="">
                            </div>

                            <div class="ms-4">
                                <h4 class="text-dark">{{ $review->user->name }}</h4>
                                
                                {{-- اسم الكورس بلون كحلي --}}
                                <p class="m-0 pb-3" style="color: #001f3f;">{{ $review->course->title ?? 'Unknown Course' }}</p>

                                {{-- النجوم حسب التقييم --}}
                                <div class="d-flex pe-5">
                                    @for ($i = 0; $i < $review->rating; $i++)
                                        <i class="fas fa-star text-primary"></i>
                                    @endfor
                                    @for ($i = $review->rating; $i < 5; $i++)
                                        <i class="fas fa-star text-muted"></i>
                                    @endfor
                                </div> 
                            </div>
                        </div>

                        {{-- التعليق بلون كحلي --}}
                        <div class="border-top border-primary mt-4 pt-3">
                            <p class="mb-0" style="color: #001f3f;">{{ $review->comment }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Reviews End -->  



@endsection




    

        
   