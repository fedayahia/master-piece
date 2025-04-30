

@extends('layouts.master')

@section('title', 'Team')

@section('content')

<!-- Page Header Start -->
<div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-2 text-white mb-4">Our Team</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a> </li>
                {{-- <li class="breadcrumb-item"><a href="#">Pages</a></li> --}}
                <li class="breadcrumb-item text-white" aria-current="page">Our Team</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->


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
@endsection
