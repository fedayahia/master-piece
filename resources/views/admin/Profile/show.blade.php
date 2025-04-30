@extends('admin.layouts.app')

@section('title', 'Admin Profile')

@section('content')
<style>
    .profile-container {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-top: 20px;
    }
    
    h2 {
        color: var(--primary);
        margin-bottom: 25px;
        font-weight: 600;
        border-bottom: 2px solid var(--secondary);
        padding-bottom: 10px;
    }
    
    .profile-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        max-width: 600px;
        margin: 0 auto;
    }
    
    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
    }
    
    .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--light);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        margin-right: 25px;
    }
    
    .default-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background-color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
        font-weight: bold;
        margin-right: 25px;
    }
    
    .profile-details {
        list-style: none;
        padding: 0;
    }
    
    .detail-item {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .detail-label {
        font-weight: 600;
        color: var(--accent);
        min-width: 120px;
        display: inline-block;
    }
    
    .detail-value {
        color: #495057;
    }
    
    .role-badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        border-radius: 0.25rem;
        text-transform: capitalize;
        background-color: var(--dark);
        color: white;
    }
    
    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
        padding: 10px 25px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-primary:hover {
        background-color: #2c3060;
        border-color: #2c3060;
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
        }
        
        .profile-image,
        .default-avatar {
            margin-right: 0;
            margin-bottom: 20px;
        }
        
        .detail-label {
            display: block;
            margin-bottom: 5px;
        }
    }
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Admin Profile</h2>
    </div>

    <div class="profile-card">
        <div class="card-body">
            <div class="profile-header">
                @if(auth()->user()->image)
                    <img src="{{ asset('storage/profile_images/' . auth()->user()->image) }}" alt="Profile Image" class="profile-image">
                @else
                    <div class="default-avatar">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                
                <div>
                    <h3 class="mb-2" style="color: var(--primary);">{{ auth()->user()->name }}</h3>
                    <span class="role-badge">{{ ucfirst(auth()->user()->role) }}</span>
                </div>
            </div>

            <ul class="profile-details">
                <li class="detail-item">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ auth()->user()->email }}</span>
                </li>
                
                <li class="detail-item">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value">{{ auth()->user()->phone_number ?? 'N/A' }}</span>
                </li>
                
                <li class="detail-item">
                    <span class="detail-label">Member Since:</span>
                    <span class="detail-value">{{ auth()->user()->created_at->format('M d, Y') }}</span>
                </li>
            </ul>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
            </div>
        </div>
    </div>
</div>
@endsection