@extends('layouts.master')

@section('title', 'Registration')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endpush

@section('content')

<section class="register-section">
    <h2>Create a New Account</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('register') }}" method="post" enctype="multipart/form-data"> 
        @csrf 

        {{-- Full Name --}}
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        @error('name')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        {{-- Email --}}
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        {{-- Phone Number --}}
        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
        @error('phone_number')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        {{-- Password --}}
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        @error('password')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        {{-- Confirm Password --}}
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
        
        {{-- Image --}}
        {{-- <label for="image">Profile Picture:</label>
        <input type="file" id="image" name="image" accept="image/*">
        @error('image')
            <div class="text-danger">{{ $message }}</div>
        @enderror --}}

        <button class="but-register" type="submit">Register</button>
    </form>
</section>

@endsection
