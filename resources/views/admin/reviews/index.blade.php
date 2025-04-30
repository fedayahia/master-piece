@extends('admin.layouts.app')

@section('title', 'Course Reviews')

@section('content')
<style>
    .container {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-top: 20px;
    }
    
    h1 {
        color: var(--primary);
        margin-bottom: 25px;
        font-weight: 600;
        border-bottom: 2px solid var(--secondary);
        padding-bottom: 10px;
    }
    
    .alert-success {
        background-color: rgba(40, 167, 69, 0.1);
        border-left: 4px solid #28a745;
        color: #28a745;
        padding: 15px;
        margin-bottom: 25px;
        border-radius: 4px;
    }
    
    .table {
        width: 100%;
        margin-top: 20px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.05);
    }
    
    .table thead {
        background-color: var(--primary);
        color: white;
    }
    
    .table th {
        font-weight: 500;
        padding: 15px;
        vertical-align: middle;
    }
    
    .table td {
        padding: 15px;
        vertical-align: middle;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .table tbody tr:hover {
        background-color: rgba(57, 61, 114, 0.03);
    }
    
    .rating-stars {
        display: inline-flex;
        gap: 2px;
    }
    
    .comment {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .btn-delet {
        background-color: var(--dark);
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .btn-delet:hover {
        background-color: #e0265e;
        transform: translateY(-2px);
    }
    
    .pagination {
        justify-content: center;
        margin-top: 30px;
    }
    
    .page-link {
        color: var(--primary);
    }
    
    .page-item.active .page-link {
        background-color: var(--primary);
        border-color: var(--primary);
    }
</style>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-3 mb-md-0">Course Reviews</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="d-none d-md-table-header-group">
                <tr>
                    <th>User</th>
                    <th>Course</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviews as $review)
                    <tr>
                        <td data-label="User" class="d-block d-md-table-cell">
                            <span class="d-md-none fw-bold">User: </span>
                            {{ $review->user->name }}
                        </td>
                        <td data-label="Course" class="d-block d-md-table-cell">
                            <span class="d-md-none fw-bold">Course: </span>
                            {{ $review->course->title }}
                        </td>
                        <td data-label="Rating" class="d-block d-md-table-cell">
                            <span class="d-md-none fw-bold">Rating: </span>
                            <div class="rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                                <span class="ms-2">{{ $review->rating }}/5</span>
                            </div>
                        </td>
                        <td data-label="Comment" class="d-block d-md-table-cell">
                            <span class="d-md-none fw-bold">Comment: </span>
                            <span class="comment" title="{{ $review->comment }}">
                                {{ $review->comment }}
                            </span>
                        </td>
                        <td data-label="Actions" class="d-block d-md-table-cell">
                            <span class="d-md-none fw-bold">Actions: </span>
                            <form method="POST" action="{{ route('admin.reviews.destroy', $review->id) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this review?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delet">
                                    <i class="fas fa-trash"></i> 
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $reviews->links() }}
    </div>
</div>
@endsection