@extends('admin.layouts.app')

@section('content')
<style>
    /* Main Container */
    .container {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        margin: 1.5rem auto;
        max-width: 100%;
    }

    /* Page Header */
    h2 {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 1.5rem;
        font-size: 1.75rem;
    }

    /* Card Styling */
    .event-card {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .card-header {
        background-color: var(--primary);
        color: white;
        padding: 1.25rem 1.5rem;
        border-bottom: none;
    }

    .card-header h4 {
        margin: 0;
        font-weight: 600;
        font-size: 1.25rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .event-detail {
        display: flex;
        margin-bottom: 1rem;
        align-items: flex-start;
    }

    .detail-label {
        flex: 0 0 180px;
        font-weight: 600;
        color: var(--accent);
    }

    .detail-value {
        flex: 1;
    }

    .event-image {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
        margin-top: 0.5rem;
        max-height: 300px;
        object-fit: cover;
    }

    .free-badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        background-color: var(--secondary);
        color: var(--primary);
        border-radius: 0.25rem;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .card-footer {
        background-color: #f8f9fa;
        padding: 1rem 1.5rem;
        border-top: 1px solid rgba(0, 0, 0, 0.125);
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.625rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 500;
        line-height: 1.5;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        cursor: pointer;
        user-select: none;
        border: 1px solid transparent;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }

    .btn-warning {
        color: #212529;
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
        transform: translateY(-1px);
    }

    .btn-danger {
        color: white;
        background-color: var(--dark);
        border-color: var(--dark);
    }

    .btn-danger:hover {
        background-color: #e02d60;
        border-color: #d42a5a;
        transform: translateY(-1px);
    }

    .btn-secondary {
        color: white;
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
        transform: translateY(-1px);
    }

    /* Responsive Adjustments */
    @media (max-width: 767px) {
        .container {
            padding: 1.25rem;
        }
        
        .card-header, 
        .card-body, 
        .card-footer {
            padding: 1rem;
        }
        
        .event-detail {
            flex-direction: column;
        }
        
        .detail-label {
            flex: 1;
            margin-bottom: 0.25rem;
        }
        
        .card-footer {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .btn {
            width: 100%;
            padding: 0.75rem;
        }
    }
</style>

<div class="container">
    <h2>Event Details</h2>

    <div class="event-card">
        <div class="card-header">
            <h4>{{ $event->title }}</h4>
        </div>
        <div class="card-body">
            <div class="event-detail">
                <div class="detail-label">Description:</div>
                <div class="detail-value">{{ $event->description ?? 'N/A' }}</div>
            </div>
            
            <div class="event-detail">
                <div class="detail-label">Event Date:</div>
                <div class="detail-value">{{ $event->event_date->format('F j, Y') }}</div>
            </div>
            
            <div class="event-detail">
                <div class="detail-label">Time:</div>
                <div class="detail-value">
                    {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }} - 
                    {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                </div>
            </div>
            
            <div class="event-detail">
                <div class="detail-label">Location:</div>
                <div class="detail-value">{{ $event->location }}</div>
            </div>
            
            @if($event->image)
            <div class="event-detail">
                <div class="detail-label">Image:</div>
                <div class="detail-value">
                    <img src="{{ asset('storage/events/' . $event->image) }}" alt="Event Image" class="event-image">
                </div>
            </div>
            @endif
            
            <div class="event-detail">
                <div class="detail-label">Instructor:</div>
                <div class="detail-value">{{ $event->instructor ?? 'N/A' }}</div>
            </div>
            
            <div class="event-detail">
                <div class="detail-label">Pricing:</div>
                <div class="detail-value">
                    @if($event->is_free)
                        <span class="free-badge">Free Event</span>
                    @else
                        Paid Event
                    @endif
                </div>
            </div>
            
            <div class="event-detail">
                <div class="detail-label">Created At:</div>
                <div class="detail-value">{{ $event->created_at->format('F j, Y \a\t g:i A') }}</div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>

            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this event?')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
            
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Events
            </a>
        </div>
    </div>
</div>
@endsection