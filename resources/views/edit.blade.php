@extends('layouts.master')

@section('title', 'Edit Profile')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <style>
        .alert {
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
        }
        
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        
        .alert-error {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .btn-primary {
            background-color: #6c5ce7;
            border-color: #6c5ce7;
            padding: 10px 25px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #5649c0;
            border-color: #5649c0;
            transform: translateY(-2px);
        }
        
        .current-image {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border: 2px solid #eee;
            transition: all 0.3s;
        }
        
        .current-image:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Edit Profile</h4>
                <h1 class="mb-5 display-3">Update Your Information</h1>
            </div>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-error alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        {{-- Name --}}
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        {{-- Email --}}
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        {{-- Phone --}}
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" 
                                   id="phone" value="{{ old('phone_number', $user->phone_number) }}"
                                   placeholder="+1234567890">
                            @error('phone_number')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        {{-- Profile Image --}}
                        <div class="form-group mb-4">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" accept="image/*">
                            <small class="text-muted">Max size: 2MB | Formats: jpeg, png, jpg, gif, webp</small>
                            @error('image')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        {{-- Current Image --}}
                        @if ($user->image)
                            <div class="mb-4">
                                <p class="mb-2">Current Image:</p>
                                <img src="{{ asset('storage/' . $user->image) }}" alt="Profile Image" 
                                     class="current-image" width="120" height="120">
                            </div>
                        @endif
                        
                        {{-- Password Change --}}
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Change Password</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" name="current_password" 
                                           class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password">
                                    @error('current_password')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" name="new_password" 
                                           class="form-control @error('new_password') is-invalid @enderror" 
                                           id="new_password">
                                    @error('new_password')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" name="new_password_confirmation" 
                                           class="form-control" id="new_password_confirmation">
                                </div>
                            </div>
                        </div>
                    
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-save me-2"></i> Update Profile
                            </button>
                            
                            <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary px-4 py-2">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection