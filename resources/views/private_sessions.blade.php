@extends('layouts.master')

@section('content')

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
<div class="container-fluid program py-5" style="background-color:#ffff;">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Private Sessions</h4>
            <h1 class="mb-5 display-3">Book One-on-One Sessions with Experts</h1>
        </div>

        <div class="row g-5 justify-content-center">
            @foreach($sessions as $session)
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
                                <a href="{{ route('private-sessions.book', $session->id) }}" class="h4">{{ $session->title }}</a>
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
                            <a href="{{ route('private-sessions.book', $session->id) }}" class="btn btn-book btn-sm">
                                <i class="fas fa-calendar-alt me-2"></i> Book Now
                            </a>
                                                </div>
                        

                        <div class="d-flex justify-content-between px-4 py-2 bg-primary rounded-bottom">
                            {{-- <small class="text-white"><i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($session->session_date)->format('l, F j, Y') }}</small> --}}
                            <small class="text-white"><i class="fas fa-clock me-1"></i> Duration: {{ $session->duration }} mins</small>
                            <small class="text-white">
                                <i class="fas {{ $session->is_online ? 'fa-wifi' : 'fa-building' }} me-1"></i>
                                {{ $session->is_online ? 'Online' : 'Offline' }}
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach

          
       <!-- Pagination -->
<div class="d-flex justify-content-center wow fadeIn" data-wow-delay="0.1s" style="margin-top: 50px;">
    <nav aria-label="Page navigation">
        <ul class="pagination flex-wrap justify-content-center mb-0">
            {{-- Previous Page Link --}}
            @if ($sessions->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link px-3 py-2 rounded-start">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link px-3 py-2 rounded-start" href="{{ $sessions->previousPageUrl() }}" rel="prev">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $current = $sessions->currentPage();
                $last = $sessions->lastPage();
                $start = max($current - 2, 1);
                $end = min($current + 2, $last);
            @endphp

            @if($start > 1)
                <li class="page-item">
                    <a class="page-link px-3 py-2" href="{{ $sessions->url(1) }}">1</a>
                </li>
                @if($start > 2)
                    <li class="page-item disabled d-none d-sm-block">
                        <span class="page-link px-3 py-2">...</span>
                    </li>
                @endif
            @endif

            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $current)
                    <li class="page-item active" aria-current="page">
                        <span class="page-link px-3 py-2">{{ $i }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link px-3 py-2" href="{{ $sessions->url($i) }}">{{ $i }}</a>
                    </li>
                @endif
            @endfor

            @if($end < $last)
                @if($end < $last - 1)
                    <li class="page-item disabled d-none d-sm-block">
                        <span class="page-link px-3 py-2">...</span>
                    </li>
                @endif
                <li class="page-item">
                    <a class="page-link px-3 py-2" href="{{ $sessions->url($last) }}">{{ $last }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($sessions->hasMorePages())
                <li class="page-item">
                    <a class="page-link px-3 py-2 rounded-end" href="{{ $sessions->nextPageUrl() }}" rel="next">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link px-3 py-2 rounded-end">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
</div>
        </div> <!-- Close the row here -->
    </div>
</div>
@endsection
