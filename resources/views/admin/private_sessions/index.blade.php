@extends('admin.layouts.app')

@section('content')
<style>
    :root {
        --primary: #393D72;
        --secondary: rgba(254, 56, 115, 0.3);
        --accent: #1A1C2E;
        --dark: #ff2f6e;
        --light: #F8F9FA;
    }

    /* Main Container */
    .container {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        margin: 2rem auto;
        max-width: 100%;
    }

    /* Header Section */
    .page-header {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--secondary);
    }

    @media (min-width: 768px) {
        .page-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    .page-header h1 {
        color: var(--primary);
        font-weight: 600;
        margin: 0;
        font-size: 1.75rem;
    }

    /* Buttons */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
        border: none;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background-color: #2a2d55;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(57, 61, 114, 0.2);
    }

    /* Table Styling */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin-bottom: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.05);
    }

    .table {
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
        font-size: 0.95rem;
    }

    .table thead {
        background-color: var(--primary);
        color: white;
        position: sticky;
        top: 0;
    }

    .table th {
        padding: 1rem;
        font-weight: 500;
        vertical-align: middle;
        text-align: left;
    }

    .table td {
        padding: 1rem;
        vertical-align: middle;
        border-top: 1px solid #e9ecef;
        text-align: left;
    }

    .table tr:hover {
        background-color: rgba(57, 61, 114, 0.03);
    }

    /* Session Image */
    .session-img {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid var(--secondary);
    }

    /* Price Badge */
    .price-badge {
        background-color: #e8f5e9;
        color: #2e7d32;
        padding: 0.35rem 0.75rem;
        border-radius: 1rem;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-block;
    }

    /* Duration Badge */
    .duration-badge {
        background-color: #e3f2fd;
        color: #1565c0;
        padding: 0.35rem 0.75rem;
        border-radius: 1rem;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-block;
    }

    /* Instructor Avatar */
    .instructor-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 0.5rem;
        border: 2px solid var(--primary);
    }

    /* Description Text */
    .description-text {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 300px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #e9ecef;
    }

    /* Responsive Table */
    @media (max-width: 767px) {
        .table thead {
            display: none;
        }
        
        .table tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            padding: 0.5rem;
        }
        
        .table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: none;
            border-bottom: 1px solid #e9ecef;
            padding: 0.75rem;
            text-align: right;
        }
        
        .table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--primary);
            margin-right: 1rem;
        }
        
        .session-img {
            width: 50px;
            height: 50px;
        }
        
        .description-text {
            max-width: 200px;
        }
    }

    /* Responsive Adjustments */
    @media (max-width: 575px) {
        .container {
            padding: 1.25rem;
        }
        
        .page-header h1 {
            font-size: 1.5rem;
        }
        
        .btn {
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>

<div class="container">
    <div class="page-header">
        <h1> Private Sessions</h1>
      
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Session</th>
                    <th>Instructor</th>
                    <th>Duration</th>
                    <th>Price</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sessions as $session)
                    <tr>
                        <td data-label="ID">{{ $session->id }}</td>
                        <td data-label="Session">
                            <div class="d-flex align-items-center">
                                @if($session->img)
                                    <img src="{{ asset('storage/private_sessions/' . $session->img) }}" 
                                         class="session-img me-2" 
                                         alt="{{ $session->title }}">
                                @endif
                                <span>{{ $session->title }}</span>
                            </div>
                        </td>
                        <td data-label="Instructor">
                            @if($session->instructor)
                                <div class="d-flex align-items-center">
                                    <img src="{{ $session->instructor->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($session->instructor->name).'&background=393D72&color=fff' }}" 
                                         class="instructor-avatar" 
                                         alt="{{ $session->instructor->name }}">
                                    <span>{{ $session->instructor->name }}</span>
                                </div>
                            @else
                                <span class="text-muted">No Instructor</span>
                            @endif
                        </td>
                        <td data-label="Duration">
                            <span class="duration-badge">{{ $session->duration }} mins</span>
                        </td>
                        <td data-label="Price">
                            <span class="price-badge">${{ number_format($session->price, 2) }}</span>
                        </td>
                        <td data-label="Description">
                            <div class="description-text">
                                {{ $session->description ?? 'No description' }}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if($sessions->isEmpty())
        <div class="empty-state">
            <i class="fas fa-calendar-times empty-state-icon"></i>
            <h3>No Private Sessions Found</h3>
            <p>Start by creating a new private session</p>
            <a href="{{ route('admin.private-sessions.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus"></i> Create Session
            </a>
        </div>
    @endif
</div>
@endsection