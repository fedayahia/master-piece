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
        max-width: 500px;
        white-space: normal;
        word-break: break-word;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
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
    
    /* Custom Pagination Styles */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 30px;
    }
    
    .page-item {
        margin: 0;
    }
    
    .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        color: var(--primary);
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        background-color: white;
    }
    
    .page-link:hover {
        background-color: var(--primary);
        color: white;
        border-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(108, 92, 231, 0.2);
    }
    
    .page-item.active .page-link {
        background-color: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    
    .page-item.disabled .page-link {
        color: #b0b0b0;
        background-color: #f8f9fa;
        border-color: #e0e0e0;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    
    @media (max-width: 768px) {
        .comment {
            max-width: 300px;
            -webkit-line-clamp: 2;
        }
    }
    
    @media (max-width: 576px) {
        .comment {
            max-width: 200px;
            -webkit-line-clamp: 1;
        }
        
        .page-link {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }
    }
</style>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-3 mb-md-0">Course Reviews</h1>
    </div>


    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="background-color: var(--primary); color: white; font-weight: 600; padding: 15px; text-align: left; border-radius: 8px 0 0 8px;">User</th>
                    <th style="background-color: var(--primary); color: white; font-weight: 600; padding: 15px; text-align: left;">Course</th>
                    <th style="background-color: var(--primary); color: white; font-weight: 600; padding: 15px; text-align: center;">Rating</th>
                    <th style="background-color: var(--primary); color: white; font-weight: 600; padding: 15px; text-align: left;">Comment</th>
                    <th style="background-color: var(--primary); color: white; font-weight: 600; padding: 15px; text-align: center; border-radius: 0 8px 8px 0;">Actions</th>
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
                                    <span class="d-none d-md-inline">Delete</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($reviews->hasPages())
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($reviews->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $reviews->previousPageUrl() }}" rel="prev">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($reviews->links()->elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $reviews->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($reviews->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $reviews->nextPageUrl() }}" rel="next">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    @endif
</div>
@endsection