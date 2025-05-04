@extends('instructor.layouts.app')

@section('content')
<style>
    /* Main Container */
    select {
        display: block; /* يجعل الـ select عنصرًا متاحًا بالكامل داخل الحاوية */
        width: 100%; /* يأخذ عرض الحاوية بالكامل */
        padding: 10px; /* إضافة حواف داخلية */
        font-size: 1rem; /* حجم الخط */
        border: 1px solid #ccc; /* حافة */
        border-radius: 5px; /* حواف دائرية */
        background-color: #fff; /* خلفية بيضاء */
    }

    /* تحسين الـ form-control إذا كانت تؤثر على المظهر */
    .form-control {
        padding: 0; /* إزالة الحواف الداخلية الزائدة */
        width: 100%; /* التأكد من أن الـ select يشغل المساحة بالكامل */
        font-size: 1rem; /* حجم الخط */
        border: 1px solid #ccc; /* حافة رقيقة */
        border-radius: 5px; /* حواف دائرية */
        background-color: #fff; /* خلفية بيضاء */
        color: #333; /* لون النص */
    }
    
    .container {
        background-color: white;
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        margin: 1.5rem auto;
        max-width: 100%;
    }

    /* Header Section */
    .section-header {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--secondary);
    }

    @media (min-width: 768px) {
        .section-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    .section-header h1 {
        color: var(--primary);
        font-weight: 600;
        margin: 0;
        font-size: 1.5rem;
    }

    /* Buttons */
    .btn {
        padding: 0.75rem 1.25rem;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background-color: #2a2d55;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(57, 61, 114, 0.2);
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
    }

    /* Filter Form */
    .filter-form {
        margin-bottom: 1.5rem;
        background: #f8f9fa;
        padding: 1.25rem;
        border-radius: 8px;
    }

    .filter-form .row {
        --bs-gutter-x: 1rem;
        --bs-gutter-y: 1rem;
    }



    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(57, 61, 114, 0.25);
    }

    /* Table Styling */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        width: 100%;
        margin-bottom: 1.5rem;
        border-collapse: collapse;
    }

    .table thead {
        background-color: var(--primary);
        color: white;
    }

    .table th {
        padding: 0.75rem;
        font-weight: 500;
        vertical-align: middle;
        font-size: 0.875rem;
        text-align: left;
    }

    .table td {
        padding: 0.75rem;
        vertical-align: middle;
        border-top: 1px solid #e9ecef;
        font-size: 1rem;
        }

    /* Mobile Table Layout */
    @media (max-width: 767px) {
        .table thead {
            display: none;
        }
        
        .table tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }
        
        .table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: none;
            border-bottom: 1px solid #e9ecef;
            padding: 0.75rem;
        }
        
        .table td:before {
            content: attr(data-label);
            font-weight: 500;
            color: var(--primary);
            margin-right: 1rem;
        }
        
        .table td:last-child {
            border-bottom: none;
        }
    }

    /* Badges */
    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 500;
        border-radius: 0.25rem;
    }

    /* Action Buttons */
    .action-btns {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-sm {
        padding: 0.375rem 0.5rem;
        min-width: 2rem;
        height: 2rem;
        border-radius: 0.25rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
    }

    .btn-show {
        background-color: var(--primary);
        color: white;
        border: none;
    }

    .btn-edit {
        background-color: #17a2b8;
        color: white;
        border: none;
    }

    .btn-delete {
        background-color: var(--dark);
        color: white;
        border: none;
    }

    /* Pagination */
    .pagination {
        justify-content: center;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .page-item.active .page-link {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .page-link {
        color: var(--primary);
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: #e9ecef;
    }

    /* Course Image */
    .course-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 0.75rem;
    }

    /* Mobile Optimizations */
    @media (max-width: 767px) {
        .container {
            padding: 1rem;
        }
        
        .filter-form .col-md-2, 
        .filter-form .col-md-4 {
            width: 100%;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
        
        .action-btns {
            justify-content: flex-end;
        }
    }

    @media (max-width: 575px) {
        .section-header h1 {
            font-size: 1.25rem;
        }
        
        .btn {
            padding: 0.65rem 1rem;
            font-size: 0.875rem;
        }
    }
    </style>
<div class="container">
    <div class="section-header">
        <h1>Courses Management</h1>
        <a href="{{ route('instructor.courses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Course
        </a>
    </div>

    <form action="{{ route('instructor.courses.index') }}" method="GET" class="filter-form">
                <div class="row g-3">
            <!-- Search Field -->
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by title..." value="{{ request('search') }}">
            </div>
    
            <!-- Category Filter -->
            <div class="col-md-4">
                <select name="category" class="form-control">
                    <option value="">All Categories</option>
                    <option value="Newborn Care" {{ request('category') == 'Newborn Care' ? 'selected' : '' }}>Newborn Care</option>
                    <option value="Positive Parenting" {{ request('category') == 'Positive Parenting' ? 'selected' : '' }}>Positive Parenting</option>
                    <option value="Mother and Child Health" {{ request('category') == 'Mother and Child Health' ? 'selected' : '' }}>Mother and Child Health</option>
                    <option value="Child First Aid" {{ request('category') == 'Child First Aid' ? 'selected' : '' }}>Child First Aid</option>
                    <option value="Family Communication" {{ request('category') == 'Family Communication' ? 'selected' : '' }}>Family Communication</option>
                </select>
            </div>
    
            <!-- Filter Button -->
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
    
            <!-- Reset Button -->
            <div class="col-md-2">
                <a href="{{ route('instructor.courses.index') }}" class="btn btn-secondary w-100">
                    <i class="fas fa-sync-alt"></i> Reset
                </a>
            </div>
        </div>
    </form>
    
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Seats Available</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td data-label="#">{{ $course->id }}</td>
                        <td data-label="Title">
                            <div class="d-flex align-items-center">
                                @if($course->image)
                                    <img src="{{ asset('storage/courses/' . $course->image) }}" alt="{{ $course->title }}" class="course-img">
                                @endif
                                <span>{{ Str::limit($course->title, 25) }}</span>
                            </div>
                        </td>
                        <td data-label="Price">JOD{{ number_format($course->price, 2) }}</td>
                        <td data-label="Category"><span class="badge bg-secondary">{{ $course->category }}</span></td>
                        <td data-label="Seats">{{ $course->seats_available }}</td>
                        <td data-label="Actions">
                            <div class="action-btns">
                                <a href="{{ route('instructor.courses.show', $course->id) }}" class="btn btn-show btn-sm" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('instructor.courses.edit', $course->id) }}" class="btn btn-edit btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('instructor.courses.destroy', $course->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this course?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            <div class="empty-state py-4">
                                <i class="fas fa-book-open"></i>
                                <h4 class="mt-3">No courses found</h4>
                                <p class="text-muted mb-0">Try adjusting your search or create a new course</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- {{ $courses->appends(request()->query())->links() }} --}}

</div>
@endsection