@extends('layouts.master')

@section('title', 'Login')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endpush

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<section class="register-section">
    <h2>Login</h2>
    <form action="{{ route('login') }}" method="post">
        @csrf
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <span class="error-message">{{ $message }}</span>
        @enderror

        <label for="password">Password:</label> 
        <input type="password" id="password" name="password" required>
        @error('password')
            <span class="error-message">{{ $message }}</span>
        @enderror

        @if($errors->has('auth'))
            <div class="error-message">{{ $errors->first('auth') }}</div>
        @endif

        <button class="but-register" type="submit">Login</button>
        
        <p>New User? <a href="{{ route('register') }}" class="register-link">Make Registration</a></p>
    </form>
</section>
@endsection

