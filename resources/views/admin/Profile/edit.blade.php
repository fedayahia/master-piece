@extends('admin.layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="profile-edit-container">
    <div class="profile-edit-card">
        <div class="profile-header">
            <h2><i class="fas fa-user-edit"></i> Edit Your Profile</h2>
            <p>Update your personal information</p>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="profile-picture-section">
                <div class="picture-preview">
                    @if(auth()->user()->image)
                        <img src="{{ asset('storage/' . auth()->user()->image) }}" id="profilePreview">
                    @else
                        <div class="initials">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    @endif
                </div>
                <div class="upload-btn">
                    <label for="profileImage">
                        <i class="fas fa-camera"></i> Change Photo
                        <input type="file" id="profileImage" name="image" accept="image/*">
                    </label>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="name"><i class="fas fa-user"></i> Full Name</label>
                    <input type="text" name="full_name" value="{{ old('full_name', auth()->user()->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone"></i> Phone</label>
                    <input type="text" id="phone" name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number) }}">
                </div>

                <div class="form-group">
                    <label><i class="fas fa-user-tag"></i> Role</label>
                    <div class="role-display">{{ ucfirst(auth()->user()->role) }}</div>
                </div>

                <div class="form-group">
                    <label for="password"><i class="fas fa-key"></i> New Password</label>
                    <input type="password" id="password" name="password" placeholder="Leave blank to keep current">
                </div>

                <div class="form-group">
                    <label for="confirmPassword"><i class="fas fa-key"></i> Confirm Password</label>
                    <input type="password" id="confirmPassword" name="password_confirmation">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="save-btn">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="{{ route('admin.user.profile') }}" class="cancel-btn">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .profile-edit-container {
        padding: 2rem;
        display: flex;
        justify-content: center;
    }

    .profile-edit-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 800px;
        padding: 2.5rem;
    }

    .profile-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .profile-header h2 {
        color: #393D72;
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
    }

    .profile-header p {
        color: #6c757d;
    }

    .profile-picture-section {
        text-align: center;
        margin-bottom: 2rem;
    }

    .picture-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f5f7ff, #e2e6ff);
        margin: 0 auto 1rem;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .picture-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .initials {
        font-size: 2.5rem;
        font-weight: bold;
        color: #393D72;
    }

    .upload-btn {
        position: relative;
        display: inline-block;
    }

    .upload-btn label {
        background: #f8f9fa;
        color: #393D72;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        transition: all 0.3s;
    }

    .upload-btn label:hover {
        background: #e9ecef;
    }

    .upload-btn input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #495057;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-group input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        transition: all 0.3s;
    }

    .form-group input:focus {
        border-color: #393D72;
        box-shadow: 0 0 0 3px rgba(57, 61, 114, 0.2);
        outline: none;
    }

    .role-display {
        padding: 0.75rem 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        color: #495057;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
    }

    .save-btn {
        background: #393D72;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .save-btn:hover {
        background: #2c3060;
        transform: translateY(-2px);
    }

    .cancel-btn {
        background: white;
        color: #495057;
        border: 1px solid #dee2e6;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .cancel-btn:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .profile-edit-card {
            padding: 1.5rem;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .save-btn, .cancel-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
    // Profile picture preview
    document.getElementById('profileImage').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                let preview = document.getElementById('profilePreview');
                if (!preview) {
                    const previewContainer = document.querySelector('.picture-preview');
                    previewContainer.innerHTML = '';
                    preview = document.createElement('img');
                    preview.id = 'profilePreview';
                    previewContainer.appendChild(preview);
                }
                preview.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection