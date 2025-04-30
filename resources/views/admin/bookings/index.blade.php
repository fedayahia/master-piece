@extends('admin.layouts.app')

@section('title', 'Bookings Management')

@section('content')
<style>
    /* Main Container */
    select {
        display: block;
        width: 100%;
        padding: 10px;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
    }

    .form-control {
        padding: 0;
        width: 100%;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
        color: #333;
    }
    
    .container-fluid {
        background-color: white;
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        margin: 1.5rem auto;
        max-width: 100%;
    }

    /* Header Section */
    .card-header {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--secondary);
        background-color: white !important;
    }

    @media (min-width: 768px) {
        .card-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    .card-header h6 {
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

    .badge-primary {
        background-color: var(--primary);
    }

    .badge-info {
        background-color: #17a2b8;
    }

    .badge-secondary {
        background-color: #6c757d;
    }

    .bg-success {
        background-color: #28a745 !important;
    }

    .bg-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }

    /* Action Buttons */
    .action-buttons {
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

    .btn-info {
        background-color: var(--primary);
        color: white;
        border: none;
    }

    .btn-primary {
        color: white;
        border: none;
    }

    .btn-danger {
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

    /* Mobile Optimizations */
    @media (max-width: 767px) {
        .container-fluid {
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
        
        .action-buttons {
            justify-content: flex-end;
        }
    }

    @media (max-width: 575px) {
        .card-header h6 {
            font-size: 1.25rem;
        }
        
        .btn {
            padding: 0.65rem 1rem;
            font-size: 0.875rem;
        }
    }
</style>


<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h3 class="m-0 font-weight-bold" style="color: var(--primary);">Bookings Management</h3>
      
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Seat</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td data-label="ID">{{ $booking->id }}</td>
<td data-label="User">{{ $booking->user->name }}</td>
<td data-label="Type">
    @if($booking->booking_for_type == 'Course')
        <span class="badge badge-primary">Course</span>
    @elseif($booking->booking_for_type == 'PrivateSession')
        <span class="badge badge-info">Private Session</span>
    @else
        <span class="badge badge-secondary">Unknown</span>
    @endif
</td>
<td data-label="Name">{{ $booking->item_name }}</td>
<td data-label="Seat">{{ $booking->seat_number }}</td>
<td data-label="Date">{{ $booking->booking_date }}</td>
<td data-label="Status">
    @if($booking->status == 'enrolled')
        <span class="badge bg-success">Enrolled</span>
    @else
        <span class="badge bg-warning">Not Enrolled</span>
    @endif
</td>
                       
                            
                            <td class="action-buttons">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            
                                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
