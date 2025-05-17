@extends('admin.layouts.app')

@section('content')
    <style>
        /* Main Container */
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-top: 25px;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Section Header */
        .section-header {
            color: var(--primary);
            margin-bottom: 30px;
            font-weight: 600;
            border-bottom: 2px solid var(--secondary-light);
            padding-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .section-header h1 {
            font-size: 1.75rem;
            margin: 0;
        }
        
        /* Form Elements */
        .form-group {
            margin-bottom: 1.75rem;
            position: relative;
        }
        
        label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #495057;
            display: block;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
            padding: 0.75rem 1rem;
            width: 100%;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.15);
            outline: none;
        }
        
        /* Select Dropdown Specific */
        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='%236e6e6e' stroke='%236e6e6e' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 14px 10px;
            cursor: pointer;
        }
        
        .form-select option {
            padding: 10px 15px;
            background: #fff;
        }
        
        .form-select option:hover {
            background-color: var(--primary-light) !important;
            color: var(--primary-dark);
        }
        
        .form-select option:checked {
            background-color: var(--primary-light);
            color: var(--primary-dark);
            font-weight: 500;
        }
        
        /* Placeholder styling */
        .form-select option[disabled]:first-child {
            color: #adb5bd;
            font-style: italic;
        }
        
        /* Buttons */
        .btn-create {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 0.75rem 2rem;
            font-weight: 500;
            color: white;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-create:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-outline-secondary {
            border-radius: 8px;
            padding: 0.75rem 2rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            transform: translateY(-1px);
        }
        
        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        /* Helper Text */
        .text-muted {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 0.25rem;
            display: block;
        }
        
        /* Responsive Design */
        @media (max-width: 991.98px) {
            .container {
                padding: 25px;
            }
        }
        
        @media (max-width: 767.98px) {
            .container {
                padding: 20px;
                margin-top: 15px;
            }
            
            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
                margin-bottom: 25px;
            }
            
            .form-group {
                margin-bottom: 1.5rem;
            }
            
            .form-control, .form-select {
                padding: 0.7rem 0.9rem;
            }
            
            .form-actions {
                flex-direction: column;
                gap: 10px;
            }
            
            .btn-create, .btn-outline-secondary {
                width: 100%;
                padding: 0.7rem;
            }
        }
        
        @media (max-width: 575.98px) {
            .container {
                padding: 15px;
                border-radius: 8px;
            }
            
            .section-header h1 {
                font-size: 1.5rem;
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
            
            <div class="form-actions">
                <button type="submit" class="btn btn-create">
                    <i class="fas fa-save me-2"></i> Create User
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i> Cancel
                </a>
            </div>
        </form>
    </div>
@endsection