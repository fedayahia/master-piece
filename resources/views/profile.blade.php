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
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Phone:</strong> {{ $user->phone_number }}</p>
                        <a href="{{ route('user.edit') }}" class="btn btn-primary text-white btn-border-radius">Edit Profile</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-8 wow fadeIn" data-wow-delay="0.3s">
                    <div class="profile-item rounded p-4 bg-light">
                        <h4 class="text-primary">Your Booked Sessions</h4>
                        <ul class="list-group">
                            @forelse($bookedItems as $item)
                            @php
                                $title = $item->title ?? 'No Title';
                                $status = $item->status ?? 'not_enrolled';
                                $type = $item->type ?? 'Unknown'; // هذا هو الـ type الذي تم تحديده في الـ Controller
                            @endphp
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $title }}</strong>
                                        <span class="badge bg-secondary ms-2">{{ $type }}</span><br>
                                        <small>Status: <span class="badge bg-info text-dark">{{ $status }}</span><br>
                
                                        @if($item instanceof \App\Models\PrivateSession && $item->selected_time)
                                            <small class="text-muted">Selected time:</small><br>
                                            <span><i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($item->selected_time)->format('d M Y, h:i A') }}</span><br>
                                        @elseif($item instanceof \App\Models\Course && $item->selected_time)
                                            <small class="text-muted">Upcoming session:</small><br>
                                            <span><i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($item->selected_time)->format('d M Y, h:i A') }} ({{ $item->session_title }})</span><br>
                                        @endif
                
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
@endsection
