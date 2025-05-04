@extends('layouts.master')

@section('title', 'Private Sessions')

@section('content')
<style>
    .session-item {
        transition: all 0.3s;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .session-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(255, 72, 128, 0.2);
    }

    .session-img img {
        width: 100%;
        border-radius: 10px;
    }

    .session-text {
        padding: 20px;
        background-color: white;
        border-radius: 10px;
        margin-top: -30px;
    }

    .session-price {
        background-color: rgba(255, 72, 128, 0.1);
        color: #393d72;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 1.2rem;
    }

    .session-teacher img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
</style>

@php
    $categories = [
        'Wellness',
        'Self-improvement',
        'Mindfulness',
        'Fitness',
    ];
@endphp

<!-- Page Header Start -->
<div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-2 text-white mb-4">Private Sessions</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a> </li>
                <li class="breadcrumb-item text-white" aria-current="page">Private Sessions</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Sessions Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Our Private Sessions</h4>
            <h1 class="mb-5 display-3">Exclusive One-on-One Sessions</h1>
        </div>

        <!-- Row for Sessions and Sidebar -->
        <div class="row">
            <!-- Sidebar (Search & Filter) -->
            <div class="col-md-4 col-lg-3">
                <div class="search-filter-container wow fadeIn" data-wow-delay="0.2s">
                    <div class="search-filter-card">
                        <h5 class="search-filter-title">Find Your Perfect Session</h5>
                        <form method="GET" action="{{ route('sessions.index') }}" class="row g-4">
                            <div class="col-md-12">
                                <label for="search" class="form-label">Search Sessions</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-search text-primary"></i>
                                    </span>
                                    <input type="text" name="search" id="search" class="form-control border-start-0" 
                                           value="{{ request('search') }}" placeholder="Search by session title...">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="category" class="form-label">Filter by Category</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-filter text-primary"></i>
                                    </span>
                                    <select name="category" id="category" class="form-select border-start-0">
                                        <option value="">All Categories</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 d-flex flex-column">
                                <label class="form-label invisible">Actions</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i> Search
                                    </button>
                                    <a href="{{ route('sessions.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-sync-alt me-2"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sessions List -->
            <div class="col-md-8 col-lg-9">
                <div class="row g-5 justify-content-center">
                    @foreach ($sessions as $session)
                    <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                        <div class="session-item rounded">
                            <div class="session-img">
                                <img src="{{ asset('storage/sessions/' . $session->image) }}" alt="{{ $session->title }}">
                            </div>
                            <div class="session-text">
                                <a href="{{ route('sessions.show', $session->id) }}" class="h4">{{ $session->title }}</a>
                                <p class="mt-3 mb-0">{{ $session->description }}</p>
                            </div>
                            <div class="session-price text-center mt-3">
                                ${{ number_format($session->price, 2) }}
                            </div>
                            <div class="session-teacher d-flex align-items-center border-top bg-white px-4 py-3">
                                <img src="{{ asset($session->instructor->image) }}" alt="Instructor">
                                <div class="ms-3">
                                    <h6 class="mb-0 text-primary">{{ $session->instructor->name ?? 'Unknown Instructor' }}</h6>
                                    <small>Expert Instructor</small>
                                </div>
                            </div>
                            <div class="text-center py-3">
                                <a href="{{ route('sessions.book', $session->id) }}" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sessions End -->
@endsection
