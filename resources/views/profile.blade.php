@extends('layouts.master')

@section('title', 'User Profile')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endpush

@section('content')
    <div class="container-fluid user-profile py-5">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">User Profile</h4>
                <h1 class="mb-5 display-3">Manage Your Account</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        
            <div class="row g-5">
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="profile-item rounded p-4 bg-light">
                        <h4 class="text-primary">Personal Information</h4>
                        <p class="mb-2"><strong>Name:</strong> {{ $user->name }}</p>
                        <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                        <p class="mb-3"><strong>Phone:</strong> {{ $user->phone_number }}</p>
                        <a href="{{ route('user.edit') }}" class="btn btn-primary text-white btn-border-radius">Edit Profile</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-8 wow fadeIn" data-wow-delay="0.3s">
                    <div class="profile-item rounded p-4 bg-light">
                        <h4 class="text-primary mb-4">Your Booked Sessions</h4>
                        <ul class="list-group booking-list">
                            @forelse($bookedItems as $item)
                                @php
                                    $title = $item->title ?? 'No Title';
                                    $status = $item->status ?? 'not_enrolled';
                                    $type = $item->type ?? 'Unknown';
                                @endphp
                                <li class="list-group-item booking-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="d-flex align-items-center mb-1">
                                                <strong class="booking-title">{{ $title }}</strong>
                                                <span class="badge bg-secondary ms-2">{{ $type }}</span>
                                            </div>
                                            <div class="booking-details">
                                                <span class="me-2">Status: <span class="badge bg-info text-dark">{{ $status }}</span></span>
                                                
                                                @if($item instanceof \App\Models\PrivateSession && $item->selected_time)
                                                    <span class="text-muted">
                                                        <i class="bi bi-calendar-event me-1"></i>
                                                        {{ \Carbon\Carbon::parse($item->selected_time)->format('d M Y, h:i A') }}
                                                    </span>
                                                @elseif($item instanceof \App\Models\Course && $item->selected_time)
                                                    <span class="text-muted">
                                                        <i class="bi bi-calendar-event me-1"></i>
                                                        {{ \Carbon\Carbon::parse($item->selected_time)->format('d M Y, h:i A') }}
                                                        @if($item->session_title)
                                                            ({{ $item->session_title }})
                                                        @endif
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">You don't have any bookings yet.</li>
                            @endforelse
                        </ul>                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .booking-list {
            font-size: 1rem;
        }
        
        .booking-item {
            padding: 1rem;
            margin-bottom: 0.75rem;
            border-radius: 0.5rem !important;
            border: 1px solid #dee2e6;
        }
        
        .booking-title {
            font-size: 1rem;
            font-weight: 600;
            color: #212529;
        }
        
        .booking-details {
            font-size: 0.9rem;
            color: #6c757d;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.5rem;
        }
        
        .badge {
            font-size: 0.85rem;
            font-weight: 500;
        }
    </style>
@endsection