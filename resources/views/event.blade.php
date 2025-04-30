@extends('layouts.master')

@section('title', 'Events')

@section('content')

 <!-- Page Header Start -->
 <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-2 text-white mb-4">Events</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a> </li>
                <li class="breadcrumb-item text-white" aria-current="page">Events</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->


<!-- Events Start -->
<div class="container-fluid events py-5 bg-light">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Our Events</h4>
            <h1 class="mb-5 display-3">Our Upcoming Events</h1>
        </div>
        <div class="row g-5 justify-content-center">
            @foreach($events as $event)
                <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="events-item bg-primary rounded">
                        <div class="events-inner position-relative">
                            <div class="events-img overflow-hidden rounded-circle position-relative">
                                <img src="{{ asset('storage/events/'.$event->image) }}" class="img-fluid w-100 rounded-circle" alt="Image">
                                <div class="event-overlay">
                                    <a href="{{ asset('storage/'.$event->image) }}" data-lightbox="event-1"><i class="fas fa-search-plus text-white fa-2x"></i></a>
                                </div>
                            </div>
                            <div class="px-4 py-2 bg-secondary text-white text-center events-rate">{{ \Carbon\Carbon::parse($event->event_date)->format('d M') }}</div>
                            <div class="d-flex justify-content-between px-4 py-2 bg-secondary">
                                <small class="text-white"><i class="fas fa-calendar me-1 text-primary"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('h:i A') }} - {{ \Carbon\Carbon::parse($event->event_date)->addHours(2)->format('h:i A') }}</small>
                                <small class="text-white"><i class="fas fa-map-marker-alt me-1 text-primary"></i> {{ $event->is_online ? 'Online' : $event->location }}</small>
                            </div>
                        </div>
                        <div class="events-text p-4 border border-primary bg-white border-top-0 rounded-bottom">
                            <a href="#" class="h4">{{ $event->title }}</a>
                            <p class="mb-0 mt-3">{{ $event->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Events End -->


@endsection

