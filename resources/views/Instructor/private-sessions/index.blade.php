@extends('instructor.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">My Private Sessions</h1>
        <a href="{{ route('instructor.private-sessions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Session
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
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
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $session->title }}</td>
                            <td>{{ $session->duration }} mins</td>
                            <td>JOD{{ number_format($session->price, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ $session->is_active ? 'success' : 'secondary' }}">
                                    {{ $session->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="action-buttons">
                                <a href="{{ route('instructor.private-sessions.show', $session->id) }}" 
                                   class="btn btn-sm btn-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('instructor.private-sessions.edit', $session->id) }}" 
                                   class="btn btn-sm btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('instructor.private-sessions.destroy', $session->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm " style="background:VAR( --dark) "
                                            title="Delete" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-calendar-times fa-2x mb-3"></i>
                                <p>No sessions found. Create your first session!</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $privateSessions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    :root {
        --primary: #393D72;  
        --secondary: rgba(254, 56, 115, 0.3);  
        --accent: #1A1C2E; 
        --dark: #ff2f6e;  
        --light: #F8F9FA;  
    }

    .container {
        background-color: white;  
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        margin: 1.5rem auto;
        max-width: 100%;
    }

    .section-header h1 {
        color: var(--primary);
        font-weight: 600;
        font-size: 1.5rem;
    }

    .table thead {
        background-color: var(--primary);  
        color: white;  
    }

    .btn-primary {
        background-color: var(--primary);  
        color: white;
    }

    .badge-success {
        background-color: #28a745;  
    }
    .badge-secondary {
        background-color: #6c757d;  
    }

    .btn-show {
        background-color: var(--primary);  
    }
    .btn-edit {
        background-color: #17a2b8;  
    }
    .btn-delete {
        background-color: var( --dark);  
    }

    .empty-state {
        color: #6c757d;  
    }
</style>
@endpush