@extends('layouts.master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Payment Successful</h4>
                </div>
                
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle fa-5x text-success"></i>
                    </div>
                    <h3 class="mb-3">Thank You for Your Payment!</h3>
                    <p class="lead">Your enrollment in <strong>{{ session('course_title') }}</strong> has been confirmed.</p>
                    
                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-primary me-3">
                            <i class="fas fa-tachometer-alt me-2"></i> Go to Dashboard
                        </a>
                        <a href="{{ route('courses.show', session('course_id')) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-book me-2"></i> View Course
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection