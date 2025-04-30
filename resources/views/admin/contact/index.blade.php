@extends('admin.layouts.app')

@section('title', 'Contact Messages')

@section('content')
<style>
    .container {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-top: 20px;
        width: 100%;
        overflow-x: auto;
    }
    
    h1 {
        color: var(--primary);
        margin-bottom: 20px;
        font-weight: 600;
        border-bottom: 2px solid var(--secondary);
        padding-bottom: 10px;
        font-size: 1.5rem;
    }
    
    .table {
        width: 100%;
        margin-top: 15px;
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
        padding: 12px;
        vertical-align: middle;
        white-space: nowrap;
    }
    
    .table td {
        padding: 12px;
        vertical-align: middle;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .table tbody tr:hover {
        background-color: rgba(57, 61, 114, 0.03);
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        border-radius: 0.25rem;
        text-transform: capitalize;
    }
    
    .status-read {
        background-color: #28a745;
        color: white;
    }
    
    .status-unread {
        background-color: #dc3545;
        color: white;
    }
    
    .status-archived {
        background-color: #6c757d;
        color: white;
    }
    
    .btn {
        padding: 8px 12px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
    }
    
    .btn-show {
        background-color: var(--primary);
        color: white;
        border: none;
    }
    
    .btn-show:hover {
        background-color: #2c3060;
        transform: translateY(-2px);
    }
    
    .btn-delet {
        background-color: var(--dark);
        color: white;
        border: none;
    }
    
    .btn-delet:hover {
        background-color: #e0265e;
        transform: translateY(-2px);
    }
    
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: nowrap;
    }
    
    .filter-section {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    
    .filter-form {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }
    
    .filter-form select, 
    .filter-form input {
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid #ddd;
        flex: 1;
        min-width: 150px;
    }
    
    .filter-form button {
        background-color: var(--primary);
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 6px;
    }
    
    .pagination {
        justify-content: center;
        margin-top: 20px;
    }
    
    .page-link {
        color: var(--primary);
    }
    
    .page-item.active .page-link {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    /* Responsive adjustments */
    @media (max-width: 1199.98px) {
        .container {
            padding: 20px;
        }
    }

    @media (max-width: 991.98px) {
        h1 {
            font-size: 1.4rem;
        }
        
        .table th, .table td {
            padding: 10px;
        }
        
        .action-buttons {
            flex-wrap: wrap;
        }
    }

    @media (max-width: 767.98px) {
        .container {
            padding: 15px;
        }
        
        h1 {
            font-size: 1.3rem;
            margin-bottom: 15px;
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
        
        .filter-form select, 
        .filter-form input {
            width: 100%;
        }
    }

    @media (max-width: 575.98px) {
        .container {
            padding: 12px;
        }
        
        h1 {
            font-size: 1.25rem;
            padding-bottom: 8px;
        }
        
        .table tbody td {
            padding: 8px;
            font-size: 0.9rem;
        }
        
        .btn {
            padding: 6px 10px;
            font-size: 0.85rem;
        }
        
        .btn i {
            margin: 0 !important;
        }
        
        .btn span {
            display: none;
        }
    }

    @media (max-width: 400px) {
        .action-buttons {
            flex-direction: column;
            gap: 5px;
        }
        
        .action-buttons .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container">
    <h1>Contact Messages</h1>

    {{-- <div class="filter-section">
        <form method="GET" action="{{ route('admin.contact.index') }}" class="filter-form">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
            
            <input type="text" name="search" placeholder="Search messages..." value="{{ request('search') }}" class="form-control">
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter me-1"></i> <span class="d-none d-sm-inline">Filter</span>
            </button>
            
            <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary">
                <i class="fas fa-sync-alt me-1"></i> <span class="d-none d-sm-inline">Reset</span>
            </a>
        </form>
    </div> --}}

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Messages</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                <tr>
                    <td data-label="ID">{{ $message->id }}</td>
                    <td data-label="Name">{{ $message->name }}</td>
                    <td data-label="Email"><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></td>
                    <td data-label ="Messages">{{ $message->message}}</td> 
                 
                    <td data-label="Date">{{ $message->created_at->format('M d, Y') }}</td>
                  
                
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No messages found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- @if($messages->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $messages->links() }}
    </div>
    @endif --}}
</div>
@endsection