@extends('admin.layouts.app')

@section('title', 'Course Sessions')

@section('content')
<style>
    /* Pagination Styles */
/* Pagination Styles */
.pagination {
    gap: 10px;
}

.page-item .page-link {
    display: flex;
    align-items: center;
    padding: 8px 16px;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    color: var(--primary);
    font-weight: 500;
    transition: all 0.3s ease;
    background-color: white;
}

.page-item .page-link:hover {
    background-color: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(108, 92, 231, 0.2);
}

.page-item.disabled .page-link {
    color: #b0b0b0;
    background-color: #f8f9fa;
    border-color: #e0e0e0;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.page-item.active .page-link {
    background-color: var(--primary);
    color: white;
    border-color: var(--primary);
}

/* Icons */
.page-link i {
    font-size: 0.9rem;
}

/* Responsive */
@media (max-width: 576px) {
    .page-link {
        padding: 6px 12px;
        font-size: 0.9rem;
    }
    
    .page-link i {
        font-size: 0.8rem;
    }
}
    /* Main container styling */
    .container {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin-top: 20px;
        max-width: 100%;
        overflow-x: auto;
    }
    
    /* Header styling */
    h2 {
        color: var(--primary);
        font-weight: 600;
        margin: 0;
        font-size: 1.5rem;
    }
    
    /* Button styling */
    .btn {
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
    }
    
    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
    }
    
    .btn-primary:hover {
        background-color: #2a2d55;
        border-color: #2a2d55;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(57, 61, 114, 0.3);
    }
    
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
    }
    
    /* Table styling */
    .table {
        margin-top: 20px;
        border-radius: 8px;
        overflow: hidden;
        width: 100%;
    }
    
    .table thead {
        background-color: var(--primary);
        color: white;
    }
    
    .table th {
        font-weight: 500;
        padding: 12px 15px;
        white-space: nowrap;
    }
    
    .table td {
        padding: 12px 15px;
        vertical-align: middle;
    }
    
    .table tbody tr {
        transition: all 0.2s;
    }
    
    .table tbody tr:hover {
        background-color: rgba(57, 61, 114, 0.05);
    }
    
    /* Action buttons */
    .btn-sm {
        padding: 6px 10px;
        font-size: 14px;
        border-radius: 4px;
        margin-right: 5px;
    }
    
    .btn-edit {
        background-color: var(--accent);
        color: white;
        border: none;
    }
    
    .btn-edit:hover {
        background-color: #0e0f1f;
        color: white;
    }
    
    .btn-delet {
        background-color: var(--dark);
        color: white;
        border: none;
    }
    
    .btn-delet:hover {
        background-color: #e02962;
        color: white;
    }
    
    /* Page header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--secondary);
        flex-wrap: wrap;
        gap: 15px;
    }
    
    /* Search container */
    .search-container {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    
    .search-input {
        flex: 1;
        min-width: 200px;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        transition: all 0.3s;
        font-size: 14px;
    }
    
    .search-btn {
        background-color: var(--primary);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
    }
    
    .search-btn:hover {
        background-color: #2a2d55;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(57, 61, 114, 0.2);
    }
    
    .search-btn i {
        margin-right: 6px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 1199.98px) {
        .container {
            padding: 25px;
        }
    }
    
    @media (max-width: 991.98px) {
        h2 {
            font-size: 1.4rem;
        }
        
        .table th, .table td {
            padding: 10px 12px;
        }
    }
    
    @media (max-width: 767.98px) {
        .container {
            padding: 20px;
        }
        
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .table thead {
            display: none;
        }
        
        .table tbody tr {
            display: block;
            margin-bottom: 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }
        
        .table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #f1f1f1;
        }
        
        .table tbody td:before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--primary);
            margin-right: 1rem;
            flex: 1;
        }
        
        .table tbody td:last-child {
            border-bottom: none;
        }
        
        .action-buttons {
            justify-content: flex-end;
        }
    }
    
    @media (max-width: 575.98px) {
        .container {
            padding: 15px;
        }
        
        h2 {
            font-size: 1.3rem;
        }
        
        .search-container {
            flex-direction: column;
        }
        
        .search-input, .search-btn {
            width: 100%;
        }
        
        .btn {
            padding: 8px 12px;
            font-size: 0.9rem;
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container py-4">
    <div class="page-header">
        <h2>All Course Sessions</h2>
        <a href="{{ route('admin.course-sessions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i> Add New Session
        </a>
    </div>
    
    <form action="{{ route('admin.course-sessions.index') }}" method="GET" class="search-container">
        <input type="text" 
               name="course_title" 
               class="search-input" 
               placeholder="Search by course title..." 
               value="{{ request('course_title') }}"
               aria-label="Search sessions">
        
        <button type="submit" class="search-btn">
            <i class="fas fa-search"></i> Search
        </button>
        
        @if(request('course_title'))
            <a href="{{ route('admin.course-sessions.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Clear
            </a>
        @endif
    </form>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Course</th>
                    <th>Instructor</th>
                    <th data-label="Start Date">Start Date</th>
                    <th data-label="End Date">End Date</th>
                    <th>Session Mode</th>
                    <th data-label="Seats">Max Seats</th>
                    <th data-label="Actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sessions as $session)
                    <tr>
                        <td data-label="Title">{{ $session->title }}</td>
                        <td data-label="Course">{{ $session->course->title ?? '-' }}</td>
                        <td data-label="Instructor">{{ $session->instructor->name ?? '-' }}</td>
                        <td data-label="Start Date">{{ \Carbon\Carbon::parse($session->start_date)->format('M d, Y') }}</td>
                        <td data-label="End Date">{{ \Carbon\Carbon::parse($session->end_date)->format('M d, Y') }}</td>
                        <td>{{ $session->session_mode }}</td>
                        <td data-label="Max Seats">{{ $session->max_seats }}</td>
                        <td data-label="Actions">
                            <div class="d-flex">
                                <a href="{{ route('admin.course-sessions.show', $session->id) }}" class="btn btn-show btn-sm" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.course-sessions.edit', $session->id) }}" class="btn btn-sm btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                    {{-- <span class="d-none d-md-inline">Edit</span> --}}
                                </a>
                                <form action="{{ route('admin.course-sessions.destroy', $session->id) }}" method="POST" class="ml-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this session?')" 
                                            class="btn btn-sm btn-delet" title="Delete">
                                        <i class="fas fa-trash"></i>
                                        {{-- <span class="d-none d-md-inline">Delete</span> --}}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">No sessions found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($sessions->hasPages())
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center mt-4">
        {{-- Previous Page Link --}}
        @if ($sessions->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">
                    <i class="fas fa-chevron-left mr-1"></i> Previous
                </span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $sessions->previousPageUrl() }}" rel="prev">
                    <i class="fas fa-chevron-left mr-1"></i> Previous
                </a>
            </li>
        @endif

        {{-- Next Page Link --}}
        @if ($sessions->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $sessions->nextPageUrl() }}" rel="next">
                    Next <i class="fas fa-chevron-right ml-1"></i>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">
                    Next <i class="fas fa-chevron-right ml-1"></i>
                </span>
            </li>
        @endif
    </ul>
</nav>
@endif
</div>
@endsection