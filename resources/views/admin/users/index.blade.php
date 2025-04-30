@extends('admin.layouts.app')

@section('content')
    <style>
        .container {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
        }

        .section-header {
            color: var(--primary);
            margin-bottom: 25px;
            font-weight: 600;
            border-bottom: 2px solid var(--secondary);
            padding-bottom: 10px;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            margin-bottom: 20px;
        }

        .btn-primary:hover {
            background-color: #2a2d55;
            border-color: #2a2d55;
        }

        .table {
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead {
            background-color: var(--primary);
            color: white;
        }

        .table th {
            font-weight: 500;
        }

        .table tbody tr:hover {
            background-color: rgba(77, 101, 249, 0.05);
        }

        .btn-show,
        .btn-edit,
        .btn-delet {
            display: flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.9rem;
            gap: 5px;
            text-decoration: none;
            color: white;
        }

        .btn-show {
            background-color: var(--primary);
        }

        .btn-edit {
            background-color: var(--accent);
        }

        .btn-delet {
            background-color: var(--dark);
        }

        .btn-show:hover {
            background-color: #2a2d55;
        }

        .btn-edit:hover {
            background-color: #0e0f1f;
        }

        .btn-delet:hover {
            background-color: #e02962;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .pagination .page-link {
            color: var(--primary);
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.2rem;
        }

        .search-form {
        margin-bottom: 25px;
    }

    .search-form .input-group {
        border-radius: 6px;
        overflow: hidden;
        height: 45px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .search-form .form-control {
        border: 1px solid #e0e0e0;
        border-right: none;
        height: 45px;
        padding: 10px 15px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .search-form .form-control:focus {
        border-color: var(--primary);
        box-shadow: none;
    }

    .search-form .input-group-append {
        margin-left: 0;
    }

    .search-form .btn-search {
        border: 1px solid var(--primary);
        border-left: none;
        background-color: var(--primary);
        color: white;
        padding: 0 20px;
        transition: all 0.3s ease;
    }

    .search-form .btn-search:hover {
        background-color: #2a2d55;
        border-color: #2a2d55;
    }

    .search-form .btn-reset {
        border: 1px solid #e0e0e0;
        background-color: #f8f9fa;
        color: #6c757d;
        margin-left: 10px;
        padding: 0 15px;
        transition: all 0.3s ease;
    }

    .search-form .btn-reset:hover {
        background-color: #e9ecef;
        color: var(--dark);
    }

    /* تنسيق الفلاتر المحسن */
    .filter-group {
        display: flex;
        align-items: center;
    }

    .filter-select {
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        padding: 0 15px;
        height: 45px;
        font-size: 0.9rem;
        flex: 1;
        margin-right: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .filter-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(57, 61, 114, 0.25);
    }

    .btn-filter {
        background-color: var(--accent);
        color: white;
        border: none;
        padding: 0 20px;
        height: 45px;
        transition: all 0.3s ease;
    }

    .btn-filter:hover {
        background-color: #0e0f1f;
        color: white;
    }

    /* التعديلات للشاشات الصغيرة */
    @media (max-width: 767.98px) {
        .search-form .row {
            flex-direction: column;
            gap: 15px;
        }

        .search-form .col-md-8,
        .search-form .col-md-4 {
            width: 100%;
        }

        .filter-group {
            flex-direction: column;
            gap: 10px;
        }

        .filter-select {
            width: 100%;
            margin-right: 0;
        }

        .search-form .btn-reset {
            margin-left: 0;
            margin-top: 10px;
            width: 100%;
        }
    }
        /* البادجات */
        .badge-role {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 600;
            border-radius: 0.25rem;
        }

        .badge-admin {
            background-color: #4e73df;
            color: white;
        }

        .badge-user {
            background-color: #1cc88a;
            color: white;
        }

        /* Responsive additions */
        @media (max-width: 767.98px) {
            .container {
                padding: 15px;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-form .row {
                flex-direction: column;
                gap: 15px;
            }

            .search-form .col-md-8,
            .search-form .col-md-4 {
                width: 100%;
            }

            .table-responsive {
                border: none;
            }

            .table thead {
                display: none;
            }

            .table tr {
                display: block;
                margin-bottom: 15px;
                border: 1px solid #dee2e6;
                border-radius: 8px;
            }

            .table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 15px;
                border-top: none;
                border-bottom: 1px solid #dee2e6;
            }

            .table td:before {
                content: attr(data-label);
                font-weight: bold;
                margin-right: 15px;
                flex: 0 0 100px;
            }

            .table td:last-child {
                border-bottom: none;
                justify-content: flex-end;
                gap: 5px;
            }
        }
    </style>

    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-center flex-wrap">
            <h1 class="h3 mb-2 mb-md-0">Users Management</h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary mt-2 mt-md-0">
                <i class="fas fa-plus"></i> <span class="d-none d-md-inline">Add New User</span>
            </a>
        </div>
        {{-- <form action="{{ route('admin.users.restore', $user->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Restore</button>
        </form> --}}
        
        <!-- Search Form -->
        <form action="{{ route('admin.users.index') }}" method="GET" class="search-form">
            <div class="row g-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                               placeholder="Search by name or email...">
                        <div class="input-group-append">
                            <button class="btn btn-search" type="submit">
                                <i class="fas fa-search"></i> <span class="d-none d-md-inline">Search</span>
                            </button>
                        </div>
                        @if(request('search') || request('role'))
                        <div class="input-group-append">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-reset">
                                <i class="fas fa-undo"></i> <span class="d-none d-md-inline">Reset</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="filter-group">
                        <select name="role" class="filter-select">
                            <option value="">All Roles</option>
                            <option value="parent" {{ request('role') == 'parent' ? 'selected' : '' }}>Parents</option>
                            <option value="instructor" {{ request('role') == 'instructor' ? 'selected' : '' }}>Instructors</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admins</option>
                        </select>
                        <button class="btn btn-filter" type="submit">
                            <i class="fas fa-filter"></i> <span class="d-none d-md-inline">Filter</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        

        <!-- Users Table -->
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone_number }}</td>
                            <td>
                                @if ($user->role === 'admin')
                                    <span class="badge bg-success">Admin</span>
                                @elseif ($user->role === 'instructor')
                                    <span class="badge bg-info text-dark">Instructor</span>
                                @else
                                    <span class="badge bg-secondary">Parent</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-show btn-sm" title="View" style="margin-right: 10px;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-edit btn-sm" title="Edit" style="margin-right: 10px;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delet btn-sm" title="Delete" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        
            {{-- Pagination --}}
            {{-- @if($users->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->withQueryString()->links() }}
                </div>
            @endif --}}
@endsection        
