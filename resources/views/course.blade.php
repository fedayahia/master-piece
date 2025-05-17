@extends('layouts.master')

@section('title', 'Courses')

@section('content')
<style>
    /*** Search & Filter Start ***/
.search-filter-container {
    /* position: sticky; */
    top: 20px;
}

.search-filter-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    padding: 25px;
    transition: all 0.3s ease;
}

.search-filter-card:hover {
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    transform: translateY(-3px);
}

.search-filter-title {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 25px;
    position: relative;
    padding-bottom: 10px;
}

.search-filter-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 50px;
    height: 3px;
    background: var(--bs-primary);
    border-radius: 3px;
}

.form-label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 8px;
    display: block;
}

.input-group {
    margin-bottom: 20px;
}

.input-group-tex {
    text-align: center;
    height: 50px;
    width: 40px;
    padding-top: 15px;
    border-radius: 8px 0 0 8px !important;
    color: var(--bs-primary) !important;
    background-color: rgba(255, 72, 128, 0.1) !important;
    border-right: none !important;
}

.form-control, .form-select {
    border-radius: 0 8px 8px 0 !important;
    border-left: none !important;
    padding: 12px 15px;
    box-shadow: none !important;
    border-color: #e2e8f0;
    transition: all 0.3s;
}

.form-control:focus, .form-select:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.25rem rgba(255, 72, 128, 0.25) !important;
}

.btn {
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-primary {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
    flex-grow: 1;
}

.btn-primary:hover {
    background-color: #d62f6e;
    border-color: #d62f6e;
    transform: translateY(-2px);
}

.btn-secondary {
    background-color: #f8f9fa;
    border-color: #e2e8f0;
    color: #4a5568;
    flex-grow: 1;
}

.btn-secondary:hover {
    background-color: #e9ecef;
    border-color: #dae0e5;
    color: #2c3e50;
    transform: translateY(-2px);
}

/* Animation for form elements */
.search-filter-card .form-control,
.search-filter-card .form-select,
.search-filter-card .btn {
    animation-duration: 0.5s;
    animation-fill-mode: both;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .search-filter-container {
        position: static;
        margin-bottom: 30px;
    }
    
    .search-filter-card {
        padding: 20px;
    }
}
/*** Search & Filter End ***/
    </style>

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


<!-- Page Header Start -->
<div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-2 text-white mb-4">Courses</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a> </li>
                <li class="breadcrumb-item text-white" aria-current="page">Courses</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Courses Start -->
<div class="container-fluid program py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Our Courses</h4>
            <h1 class="mb-5 display-3">Exclusive Parenting & Child Development Courses</h1>
        </div>

        <!-- Row for Courses and Sidebar -->
        <div class="row">
            <!-- Sidebar (Search & Filter) -->
            <div class="col-md-4 col-lg-3">
                <div class="search-filter-container wow fadeIn" data-wow-delay="0.2s">
                    <div class="search-filter-card">
                        <h5 class="search-filter-title">Find Your Perfect Course</h5>
                        <form method="GET" action="{{ route('courses.index') }}" class="row g-4">
                            <div class="col-md-12">
                                <label for="search" class="form-label">Search Courses</label>
                                <div class="input-group">
                                    <span class="input-group-tex bg-white border-end-0">
                                        <i class="fas fa-search text-primary"></i>
                                    </span>
                                    <input type="text" name="search" id="search" class="form-control border-start-0" 
                                           value="{{ request('search') }}" placeholder="Search by course title...">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="category" class="form-label">Filter by Category</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-filter text-primary"></i>
                                    </span>
                                    <select name="category" id="category" class="form-select border-start-0">
                                        <option value="">All Categories</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                        
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 d-flex flex-column">
                                <label class="form-label invisible">Actions</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i> Search
                                    </button>
                                    <a href="{{ route('courses.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-sync-alt me-2"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Courses List -->
            <div class="col-md-8 col-lg-9">
                <div class="programs-container">
                    <div class="row g-5 justify-content-center">
                        @foreach ($courses as $course)
                            <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn" data-wow-delay="0.1s">
                                <div class="program-item-wrapper mb-4">
                                    <div class="program-item rounded h-100">
                                        <div class="program-img position-relative">
                                            <div class="overflow-hidden img-border-radius">
                                                <img src="{{ asset('storage/courses/' . $course->image) }}" alt="{{ $course->title }}" class="img-fluid w-100">
                                            </div>
                                            <div class="px-9 py-2 bg-primary text-white program-rate text-center" style="direction: ltr; min-width: 110px; padding-left: 12px; padding-right: 12px;">
                                                JOD{{ number_format($course->price, 2) }}
                                            </div>
                                        </div>
            
                                        <div class="course-text bg-white px-4 pb-3">
                                            <div class="course-text-inner">
                                                <a href="{{ route('courses.show', $course->id) }}" class="h6">{{ $course->title }}</a>
                                                <p class="mt-3 mb-0">{{ $course->description }}</p>
                                            </div>
                                        </div>
            
                                        <div class="course-teacher d-flex align-items-center border-top border-primary bg-white px-4 py-3">
                                            <img src="{{ asset('storage/instructor/' . $course->instructor->image) }}"
                                                 class="img-fluid rounded-circle p-2 border border-primary bg-white"
                                                 alt="{{ $course->instructor->name ?? 'Instructor' }}"
                                                 style="width: 100px; height: 100px;">
                                            <div class="ms-3">
                                                <h6 class="mb-0 text-primary">{{ $course->instructor->name ?? 'Unknown Instructor' }}</h6>
                                                <small>Expert Instructor</small>
                                            </div>
                                        </div>
            
                                        <div class="text-center d-flex align-items-center justify-content-center bg-white py-3">
                                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-book btn-sm">Show Details</a>
                                        </div>
            
                                        <div class="d-flex justify-content-between px-4 py-2 bg-primary rounded-bottom">
                                            <small class="text-white"><i class="fas fa-chair me-1"></i> {{ $course->seats_available }} Seats</small>
                                            <small class="text-white"><i class="fas fa-clock me-1"></i> {{ $course->duration }} Hours</small>
                                            <small class="text-white">
                                                <i class="fas {{ $course->is_online ? 'fa-wifi' : 'fa-building' }} me-1"></i>
                                                {{ $course->is_online ? 'Online' : 'Offline' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
            
                        <!-- Laravel Dynamic Pagination -->
                        <div class="col-12 mt-5 wow fadeIn" data-wow-delay="0.3s">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center flex-wrap">
                                    {{-- Previous Page Link --}}
                                    @if ($courses->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">&laquo;</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $courses->previousPageUrl() }}" rel="prev">&laquo;</a>
                                        </li>
                                    @endif
                        
                                    {{-- Pagination Elements --}}
                                    @foreach ($courses->getUrlRange(1, $courses->lastPage()) as $page => $url)
                                        @if ($page == $courses->currentPage())
                                            <li class="page-item active" aria-current="page">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                        
                                    {{-- Next Page Link --}}
                                    @if ($courses->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $courses->nextPageUrl() }}" rel="next">&raquo;</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">&raquo;</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection