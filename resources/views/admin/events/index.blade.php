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
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--secondary);
    }

    .section-header h2 {
        color: var(--primary);
        font-weight: 600;
        margin: 0;
        font-size: 1.75rem;
    }

    /* Buttons */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 400;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
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
    }

    .table {
        width: 100%;
        margin-bottom: 1.5rem;
        border-collapse: collapse;
        font-size: 0.95rem;
    }

    .table thead {
        background-color: var(--primary);
        color: white;
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
    }

    .table tr:hover {
        background-color: rgba(57, 61, 114, 0.03);
    }

    /* Badges */
    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 500;
        border-radius: 0.25rem;
        color: white;
    }
    
    .bg-success {
        background-color: #28a745;
    }
    
    .bg-primary {
        background-color: var(--primary);
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        width: 30px;
        height: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .btn-show {
        background-color: var(--primary);
        color: white;
    }

    .btn-edit {
        background-color: #ffc107;
        color: #212529;
    }

    .btn-delet {
        background-color: var(--dark);
        color: white;
        border:var(--dark); 
    }

    .btn-action:hover {
        transform: scale(1.1);
        opacity: 0.9;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 3rem;
        color: #dee2e6;
        margin-bottom: 1rem;
    }

    /* Pagination */
    .pagination {
        justify-content: center;
        margin-top: 2rem;
    }

    .page-item.active .page-link {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .page-link {
        color: var(--primary);
    }

    /* Responsive Adjustments */
    @media (max-width: 767px) {
        .container {
            padding: 1.25rem;
        }
        
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .table {
            min-width: 100%;
        }
        
        .table th, .table td {
            padding: 0.75rem;
            font-size: 0.85rem;
        }
        
        .action-buttons {
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .btn {
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 575px) {
        .container {
            padding: 1rem;
            margin: 1rem auto;
        }
        
        .section-header h2 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="container">
    <div class="section-header">
        <h2>Manage Events</h2>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Event
        </a>
    </div>

    @if($events->isEmpty())
        <div class="empty-state">
            <i class="fas fa-calendar-alt"></i>
            <h3>No Events Found</h3>
            <p>There are currently no events available. Click the button above to add a new event.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->event_date->format('Y-m-d') }}</td>
                        <td>
                            {{ $event->start_time->format('h:i A') }} - 
                            {{ $event->end_time->format('h:i A') }}
                        </td>
                        <td>{{ $event->location ?? 'Online' }}</td>
                        <td>
                            @if($event->is_free)
                                <span class="badge bg-success">Free</span>
                            @else
                                <span class="badge bg-primary">Paid</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.events.show', $event->id) }}" class="btn-action btn-show" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.events.edit', $event->id) }}" class="btn-action btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delet" title="Delete" onclick="return confirm('Are you sure you want to delete this event?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($events->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $events->links() }}
            </div>
        @endif
    @endif
</div>
@endsection