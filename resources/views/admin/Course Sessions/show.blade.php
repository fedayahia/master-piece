@extends('admin.layouts.app')

@section('content')

<style>
    :root {
        --primary: #393d72;
        --secondary: #f8f9fa;
    }
    
    body {
        background-color: #f5f7fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .container {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        margin: 2rem auto;
        max-width: 100%;
    }

    /* Header */
    h1 {
        color: var(--primary);
        margin-bottom: 1.5rem;
        font-weight: 600;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--secondary);
    }

    /* Card Styling */
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .card-header {
        background-color: var(--primary);
        color: white;
        padding: 1.25rem 1.5rem;
        border-bottom: none;
    }

    .card-header h3 {
        margin: 0;
        font-weight: 500;
        font-size: 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .detail-item {
        margin-bottom: 1.25rem;
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
    }

    .detail-label {
        color: var(--primary);
        font-weight: 600;
        min-width: 200px;
        margin-bottom: 0.5rem;
    }

    .detail-value {
        flex: 1;
        min-width: 0;
        color: #495057;
    }

    .card-footer {
        background-color: rgba(57, 61, 114, 0.05);
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1rem 1.5rem;
        text-align: right;
    }

    /* Buttons */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background-color: #2a2d55;
        border-color: #2a2d55;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(57, 61, 114, 0.3);
    }

    /* Badges for status */
    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.875em;
        font-weight: 600;
        border-radius: 0.25rem;
    }

    .badge-online {
        background-color: #d1fae5;
        color: #065f46;
    }

    .badge-offline {
        background-color: #fee2e2;
        color: #b91c1c;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .container {
            padding: 1.5rem;
        }
        
        .detail-item {
            flex-direction: column;
        }
        
        .detail-label {
            min-width: 100%;
            margin-bottom: 0.25rem;
        }
    }

    @media (max-width: 576px) {
        .card-body, .card-header, .card-footer {
            padding: 1rem;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="container">
    <h1>Session Details</h1>
    
    <div class="card">
        <div class="card-header">
            <h3>Session Information</h3>
        </div>
        <div class="card-body">
            <div class="detail-item">
                <div class="detail-label">Session Title:</div>
                <div class="detail-value">{{ $session->title ?? '--' }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Course:</div>
                <div class="detail-value">{{ $session->course->title ?? '--' }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Instructor:</div>
                <div class="detail-value">{{ $session->instructor->name ?? '--' }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Description:</div>
                <div class="detail-value">{{ $session->description ?? 'No description available' }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Start Date:</div>
                <div class="detail-value">{{ $session->start_date ? \Carbon\Carbon::parse($session->start_date)->format('M d, Y h:i A') : '--' }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">End Date:</div>
                <div class="detail-value">{{ $session->end_date ? \Carbon\Carbon::parse($session->end_date)->format('M d, Y h:i A') : '--' }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Duration (minutes):</div>
                <div class="detail-value">{{ $session->duration ?? '--' }}</div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Session Mode:</div>
                <div class="detail-value">
                    <span class="badge {{ $session->session_mode === 'online' ? 'badge-online' : 'badge-offline' }}">
                        {{ ucfirst($session->session_mode ?? '--') }}
                    </span>
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Maximum Seats:</div>
                <div class="detail-value">{{ $session->max_seats ?? '--' }}</div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.course-sessions.index') }}" class="btn btn-secondary ms-2">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>

@endsection