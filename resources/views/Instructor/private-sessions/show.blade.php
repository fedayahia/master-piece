@extends('instructor.layouts.app')

@section('content')
<div class="container">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="page-title">Session Details</h1>
            <a href="{{ route('instructor.private-sessions.index') }}" class="btn btn-back">
                <i class="fas fa-arrow-left me-2"></i> Back to Sessions
            </a>
        </div>
    
        <div class="session-card">
            <div class="session-card-body">
                <div class="row g-4">
                    <!-- Session Image Column -->
                    <div class="col-lg-4">
                        <div class="session-image-container">
                            @if($privateSession->img)
                                <img src="{{ asset('storage/private_sessions/'.$privateSession->img) }}" 
                                     class="session-image" alt="{{ $privateSession->title }}">
                            @else
                                <div class="session-image-placeholder">
                                    <i class="fas fa-image"></i>
                                    <span>No Image Available</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Session Details Column -->
                    <div class="col-lg-8">
                        <div class="session-header">
                            <h2 class="session-title">{{ $privateSession->title }}</h2>
                            <div class="session-meta">
                                <div class="meta-item">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ $privateSession->duration }} Hours</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <span>JOD{{ number_format($privateSession->price, 2) }}</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas {{ $privateSession->is_online ? 'fa-laptop' : 'fa-map-marker-alt' }}"></i>
                                    <span>{{ $privateSession->is_online ? 'Online Session' : 'In-Person Session' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="session-description">
                            <h5>Description</h5>
                            <p>{{ $privateSession->description ?? 'No description provided' }}</p>
                        </div>
{{--                         
                        <div class="session-actions">
                            <a href="{{ route('instructor.private-sessions.edit', $privateSession->id) }}" 
                               class="btn btn-edit">
                                <i class="fas fa-edit me-2"></i> Edit Session
                            </a>
                            <form action="{{ route('instructor.private-sessions.destroy', $privateSession->id) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete" 
                                        onclick="return confirm('Are you sure you want to delete this session?')">
                                    <i class="fas fa-trash me-2"></i> Delete
                                </button>
                            </form>
                        </div> --}}
                    </div>
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
        --success: #28a745;
        --danger: #dc3545;
        --warning: #ffc107;
    }
    
    .container {
        max-width: 1200px;
        padding: 2rem 1.5rem;
    }
    
    .page-title {
        font-size: 2rem;
        font-weight: 600;
        color: var(--primary);
        margin: 0;
    }
    
    .btn-back {
        background-color: var(--light);
        color: var(--primary);
        border: 1px solid var(--primary);
        padding: 0.5rem 1.25rem;
        transition: all 0.3s ease;
    }
    
    .btn-back:hover {
        background-color: var(--primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .session-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        border: none;
    }
    
    .session-card-body {
        padding: 2rem;
    }
    
    .session-image-container {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .session-image {
        width: 100%;
        height: auto;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .session-image:hover {
        transform: scale(1.03);
    }
    
    .session-image-placeholder {
        width: 100%;
        height: 250px;
        background-color: var(--light);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 1rem;
    }
    
    .session-image-placeholder i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .session-status-badge {
        text-align: center;
    }
    
    .badge {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        border-radius: 50px;
    }
    
    .badge-active {
        background-color: var(--success);
        color: white;
    }
    
    .badge-inactive {
        background-color: var(--secondary);
        color: var(--dark);
    }
    
    .session-header {
        margin-bottom: 2rem;
    }
    
    .session-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--accent);
        margin-bottom: 1rem;
    }
    
    .session-meta {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary);
        font-size: 1rem;
    }
    
    .meta-item i {
        color: var(--dark);
    }
    
    .session-description {
        margin-bottom: 2rem;
    }
    
    .session-description h5 {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .session-description p {
        color: #555;
        line-height: 1.6;
        font-size: 1rem;
    }
    
    .session-actions {
        display: flex;
        gap: 1rem;
        padding-top: 1.5rem;
        border-top: 1px solid #eee;
        flex-wrap: wrap;
    }
    
    .btn-edit {
        background-color: var(--primary);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-edit:hover {
        background-color: #2c3060;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(57, 61, 114, 0.2);
    }
    
    .btn-delete {
        background-color: var(--danger);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-delete:hover {
        background-color: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
    }
    
    @media (max-width: 992px) {
        .session-meta {
            flex-direction: column;
            gap: 0.75rem;
        }
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.5rem;
        }
        
        .session-title {
            font-size: 1.5rem;
        }
        
        .session-card-body {
            padding: 1.5rem;
        }
    }
</style>
@endpush