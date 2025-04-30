
@extends('layouts.master')

@section('title', 'Services')

@section('content')

 <!-- Page Header Start -->
 <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-2 text-white mb-4">Services</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a> </li>
                {{-- <li class="breadcrumb-item"><a href="#">Pages</a></li> --}}
                <li class="breadcrumb-item text-white" aria-current="page">Services</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->


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

@endsection


