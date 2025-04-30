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
        
        .user-details-card {
            border-radius: 8px;
            overflow: hidden;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }
        
        .detail-item {
            border-left: none;
            border-right: none;
            padding: 1.25rem 1.5rem;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }
        
        .detail-item:first-child {
            border-top: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #495057;
            min-width: 150px;
            margin-bottom: 0.5rem;
        }
        
        .detail-value {
            color: #212529;
            flex: 1;
        }
        
        .user-avatar {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
        }
        
        .user-avatar:hover {
            transform: scale(1.05);
        }
        
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }
        
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        
        .action-buttons {
            margin-top: 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        /* Status indicator */
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .status-active {
            background-color: #28a745;
        }
        
        .status-inactive {
            background-color: #dc3545;
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
            
            .detail-item {
                flex-direction: column;
                align-items: flex-start;
                padding: 1rem;
            }
            
            .detail-label {
                min-width: 100%;
                margin-bottom: 0.25rem;
            }
            
            .user-avatar {
                width: 100px;
                height: 100px;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .action-buttons a, 
            .action-buttons form {
                width: 100%;
            }
            
            .action-buttons .btn {
                width: 100%;
                justify-content: center;
            }
            
            .ms-auto {
                margin-left: 0 !important;
                margin-top: 0.5rem;
            }
        }

        @media (max-width: 575.98px) {
            .container {
                padding: 15px;
                margin: 0 -15px;
                border-radius: 0;
                box-shadow: none;
                border: 1px solid #e9ecef;
            }
        }
    </style>

    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-center flex-wrap">
            <h1 class="h3 mb-2 mb-md-0">User Details</h1>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> <span class="d-none d-md-inline">Back to Users</span>
            </a>
        </div>
        
        <div class="text-center mt-4">
            <img src="{{ $user->image ? asset('storage/profile_images/' . $user->image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=120&background=random' }}" alt="{{ $user->name }}" class="user-avatar" alt="User Avatar">
            <h3 class="mt-3">{{ $user->name }}</h3>
            <p class="text-muted">{{ ucfirst($user->role) }}</p>
        </div>
        
        <div class="card user-details-card mt-3">
            <ul class="list-group list-group-flush">
           
                <li class="list-group-item detail-item">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $user->email }}</span>
                </li>
                <li class="list-group-item detail-item">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value">{{ $user->phone_number ?? 'Not provided' }}</span>
                </li>
                <li class="list-group-item detail-item">
                    <span class="detail-label">Role:</span>
                    <span class="detail-value">
                        <span class="badge bg-{{ $user->role == 'admin' ? 'primary' : ($user->role == 'instructor' ? 'info' : 'success') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </span>
                </li>
          
                <li class="list-group-item detail-item">
                    <span class="detail-label">Account Created:</span>
                    <span class="detail-value">{{ $user->created_at->format('M d, Y h:i A') }}</span>
                </li>
            </ul>
        </div>
        
   
            {{-- @if($user->is_active)
                <form action="{{ route('admin.users.deactivate', $user->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-user-slash me-1"></i> Deactivate
                    </button>
                </form>
            @else
                <form action="{{ route('admin.users.activate', $user->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-user-check me-1"></i> Activate
                    </button>
                </form>
            @endif --}}
        
        </div>
    </div>
@endsection