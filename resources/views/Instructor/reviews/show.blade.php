@extends('instructor.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Reviews for: {{ $course->title }}</h5>
            <div>
                <span class="badge bg-primary">
                    Avg Rating: {{ number_format($course->averageRating(), 1) }}/5
                </span>
            </div>
        </div>
        <div class="card-body">
            @if($reviews->count() > 0)
                @foreach($reviews as $review)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ $review->user->image ?? asset('images/default-user.png') }}" 
                                     class="rounded-circle me-3" 
                                     width="50" 
                                     height="50">
                                <div>
                                    <h6 class="mb-0">{{ $review->user->name }}</h6>
                                    <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                </div>
                            </div>
                            <div>
                                @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="mb-0">{{ $review->comment }}</p>
                    </div>
                </div>
                @endforeach
                
                <div class="mt-3">
                    {{ $reviews->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    No reviews yet for this course.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection