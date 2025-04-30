@extends('admin.layouts.app')

@section('content')
    <style>
        /* Consistent styling with your other pages */
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
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-control {
            border-radius: 0.375rem;
            border: 1px solid #d2d6da;
            transition: all 0.2s ease;
            padding: 0.75rem 1rem;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(74, 108, 247, 0.25);
        }
        
        label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #495057;
        }
        
        .btn-create {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            color: #ffffff;
        }
        
        .btn-create:hover {
            background-color: var(--primary);
            border-color: var(--primary);
            color: #ffffff;
        }
        
        /* Style for select dropdown */
        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
        }

        /* Responsive additions */
        @media (max-width: 767.98px) {
            .container {
                padding: 15px;
            }
            
            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .form-group {
                margin-bottom: 1rem;
            }
            
            .form-control, .form-select {
                padding: 0.65rem 0.75rem;
            }
            
            .btn-create, .btn-outline-secondary {
                width: 100%;
                margin-bottom: 10px;
            }
            
            .form-actions {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>

    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-center flex-wrap">
            <h1 class="h3 mb-2 mb-md-0">Create New User</h1>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> <span class="d-none d-md-inline">Back to Users</span>
            </a>
        </div>
        
        <form action="{{ route('admin.users.store') }}" method="POST" class="mt-4">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control" required 
                               placeholder="Enter full name">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" required
                               placeholder="Enter email address">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required
                               placeholder="Create password">
                        <small class="text-muted">Minimum 8 characters</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control"
                               placeholder="Enter phone number">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="role">User Role</label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="" disabled selected>Select user role</option>
                            <option value="parent">Parent</option>
                            <option value="instructor">Instructor</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                </div>
          
            </div>
            
            <div class="form-group mt-4 form-actions">
                <button type="submit" class="btn btn-create">
                    <i class="fas fa-save me-1"></i> Create User
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection