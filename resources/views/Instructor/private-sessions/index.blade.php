@extends('instructor.layouts.app')

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
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 2rem;
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
    }

    .bg-success {
        background-color: #28a745;
    }

    .bg-secondary {
        background-color: #6c757d;
    }

    .bg-info {
        background-color: #17a2b8;
    }

    /* Price Formatting */
    .price-cell {
        font-weight: 500;
        color: var(--primary);
    }

    /* Session Info */
    .session-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .session-title {
        font-weight: 500;
    }

    /* Action Buttons */
    .action-btns {
        display: flex;
        gap: 0.5rem;
    }

    .btn-sm {
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
    }

    .btn-view {
        background-color: var(--primary);
        color: white;
    }

    .btn-edit {
        background-color: #17a2b8;
        color: white;
    }

    .btn-delete {
        background-color: var(--dark);
        color: white;
    }

    .btn-view:hover {
        background-color: #2a2d55;
    }

    .btn-edit:hover {
        background-color: #138496;
    }

    .btn-delete:hover {
        background-color: #e0265a;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #e9ecef;
    }

    .empty-state h3 {
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .empty-state p {
        margin-bottom: 1.5rem;
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
        }
        
        .table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--primary);
            margin-right: 1rem;
        }
        
        .table td:last-child {
            border-bottom: none;
            justify-content: flex-end;
        }

        .action-btns {
            justify-content: flex-end;
        }

        .session-info {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    /* Responsive Adjustments */
    @media (max-width: 575px) {
        .container {
            padding: 1.25rem;
        }
        
        .section-header h1 {
            font-size: 1.5rem;
        }
        
        .btn {
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>

<div class="container">
    <div class="section-header">
        <h1>My Private Sessions</h1>
        <a href="{{ route('instructor.private-sessions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Session
        </a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Duration</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($privateSessions as $session)
                <tr>
                    <td data-label="#">{{ $loop->iteration }}</td>
                    <td data-label="Title" class="session-title">{{ $session->title }}</td>
                    <td data-label="Duration">{{ $session->duration }} mins</td>
                    <td data-label="Price" class="price-cell">JOD{{ number_format($session->price, 2) }}</td>
                    <td data-label="Status">
                        <span class="badge {{ $session->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $session->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td data-label="Actions">
                        <div class="action-btns">
                            <a href="{{ route('instructor.private-sessions.show', $session->id) }}" 
                               class="btn btn-sm btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('instructor.private-sessions.edit', $session->id) }}" 
                               class="btn btn-sm btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('instructor.private-sessions.destroy', $session->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-delete" 
                                        title="Delete" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <h3>No Sessions Found</h3>
                            <p>Create your first private session to get started!</p>
                            <a href="{{ route('instructor.private-sessions.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Session
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($privateSessions->isNotEmpty())
    <div class="d-flex justify-content-center mt-4">
        {{ $privateSessions->links() }}
    </div>
    @endif
</div>
@endsection