@extends('admin.layouts.app')

@section('content')
<style>
    :root {
        --primary: #393D72;
        --secondary: #F8F9FA;
        --accent: #1A1C2E;
        --light: #F8F9FA;
        --danger: #DC3545;
    }

    .container {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-top: 1.5rem;
    }

    .section-header {
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--secondary);
        margin-bottom: 1.5rem;
    }

    /* Form Input Styling */
    .form-control, .form-select {
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        font-size: 0.9375rem;
        transition: all 0.2s ease;
        background-color: #fff;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(57, 61, 114, 0.15);
        outline: none;
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
        padding-right: 2.5rem;
    }

    label {
        font-weight: 500;
        color: var(--accent);
        margin-bottom: 0.5rem;
        display: block;
    }

    .password-note {
        font-size: 0.8125rem;
        color: #64748b;
        margin-top: 0.375rem;
    }

    .profile-image-preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 0.5rem;
        margin: 0.5rem 0;
        border: 1px solid #e2e8f0;
        background-color: #f8fafc;
        display: {{ $user->image ? 'block' : 'none' }};
    }

    /* Button Styling */
    .btn {
        padding: 0.625rem 1.5rem;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        background-color: #2a2d55;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(57, 61, 114, 0.2);
    }

    .btn-outline-secondary {
        border-color: #d2d6da;
        color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
    }

    .form-actions {
        padding-top: 1.5rem;
        border-top: 1px solid var(--secondary);
        margin-top: 1rem;
        display: flex;
        gap: 0.75rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .container {
            padding: 1.25rem;
        }
        
        .form-actions {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
        
        .profile-image-preview {
            width: 80px;
            height: 80px;
        }
    }

    @media (max-width: 575.98px) {
        .container {
            border-radius: 0;
            margin: 0 -15px;
            box-shadow: none;
            border: 1px solid #e9ecef;
        }
    }
</style>

<div class="container">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-0">Edit User: {{ $user->name }}</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Users
        </a>
    </div>
    
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="mt-4">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="name">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" 
                           value="{{ old('name', $user->name) }}" required placeholder="John Doe">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="email">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" 
                           value="{{ old('email', $user->email) }}" required placeholder="user@example.com">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control"
                           placeholder="Leave blank to keep current password">
                    <p class="password-note">Only enter if you want to change the password</p>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control"
                           value="{{ old('phone_number', $user->phone_number) }}" placeholder="+966 50 123 4567">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="role">User Role <span class="text-danger">*</span></label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="parent" {{ old('role', $user->role) == 'parent' ? 'selected' : '' }}>Parent</option>
                        <option value="instructor" {{ old('role', $user->role) == 'instructor' ? 'selected' : '' }}>Instructor</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="image">Profile Image</label>
                    <input type="text" name="image" id="image" class="form-control"
                           value="{{ old('image', $user->image) }}" placeholder="Paste image URL"
                           onchange="updateImagePreview()">
                    <img id="imagePreview" src="{{ $user->image ? $user->image : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=7F9CF5&background=EBF4FF' }}" 
                         class="profile-image-preview mt-2" alt="Profile Preview">
                </div>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Update User
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
    function updateImagePreview() {
        const imageUrl = document.getElementById('image').value;
        const preview = document.getElementById('imagePreview');
        const userName = document.getElementById('name').value;
        
        if (imageUrl) {
            preview.src = imageUrl;
            preview.style.display = 'block';
        } else {
            preview.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&color=7F9CF5&background=EBF4FF`;
        }
    }

    document.getElementById('name').addEventListener('input', updateImagePreview);

    document.addEventListener('DOMContentLoaded', function() {
        if (!document.getElementById('image').value) {
            updateImagePreview();
        }
    });
</script>
@endsection