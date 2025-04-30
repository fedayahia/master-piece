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
        margin-bottom: 2rem;
        font-size: 1.75rem;
        border-bottom: 2px solid var(--secondary);
        padding-bottom: 0.75rem;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 0;
    }

    /* Form Elements */
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--accent);
    }

    .form-control {
        display: block;
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--primary);
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(57, 61, 114, 0.25);
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    /* Image Section */
    .image-section {
        grid-column: span 2;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .image-preview-container {
        border: 1px dashed #ddd;
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
    }

    .current-image {
        max-width: 100%;
        max-height: 200px;
        border-radius: 0.5rem;
    }

    .image-upload-box {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* Pricing Section */
    .pricing-section {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 0;
    }

    /* Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #eee;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
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

    .btn-primary {
        color: white;
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        background-color: #2a2d55;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(57, 61, 114, 0.2);
    }

    .btn-outline-secondary {
        color: #6c757d;
        background-color: transparent;
        border-color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .image-section {
            grid-column: span 1;
            grid-template-columns: 1fr;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
    }
</style>

<div class="container">
    <h2>Edit Event</h2>

    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Basic Information Section -->
        <div class="form-grid">
            <div class="form-group">
                <label for="title" class="form-label">Event Title *</label>
                <input type="text" id="title" name="title" class="form-control" 
                       value="{{ old('title', $event->title) }}" required>
            </div>
            
            <div class="form-group">
                <label for="instructor" class="form-label">Instructor</label>
                <input type="text" id="instructor" name="instructor" class="form-control" 
                       value="{{ old('instructor', $event->instructor) }}">
            </div>
        </div>
        
        <!-- Date/Time Section -->
        <div class="form-grid">
            <div class="form-group">
                <label for="event_date" class="form-label">Event Date *</label>
                <input type="date" id="event_date" name="event_date" class="form-control" 
                       value="{{ old('event_date', $event->event_date) }}" required>
            </div>
            
            <div class="form-group">
                <label for="start_time" class="form-label">Start Time *</label>
                <input type="time" id="start_time" name="start_time" class="form-control" 
                       value="{{ old('start_time', $event->start_time) }}" required>
            </div>
            
            <div class="form-group">
                <label for="end_time" class="form-label">End Time *</label>
                <input type="time" id="end_time" name="end_time" class="form-control" 
                       value="{{ old('end_time', $event->end_time) }}" required>
            </div>
        </div>
        
        <!-- Location Section -->
        <div class="form-grid">
            <div class="form-group">
                <label for="location" class="form-label">Location *</label>
                <input type="text" id="location" name="location" class="form-control" 
                       value="{{ old('location', $event->location) }}" required>
            </div>
        </div>
        
        <!-- Image Section -->
        <div class="form-grid image-section">
            <div class="image-preview-container">
                @if($event->image)
                    <p>Current Image:</p>
                    <img src="{{ asset('storage/events/' . $event->image) }}" alt="Current Event Image" class="current-image">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image">
                        <label class="form-check-label" for="remove_image">Remove current image</label>
                    </div>
                @else
                    <p>No image uploaded</p>
                @endif
            </div>
            
            <div class="image-upload-box">
                <label for="image" class="form-label">Upload New Image</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                <small class="text-muted">Recommended size: 800x450px</small>
            </div>
        </div>
        
        <!-- Description Section -->
        <div class="form-grid">
            <div class="form-group">
                <label for="description" class="form-label">Event Description *</label>
                <textarea id="description" name="description" class="form-control" rows="6" required>{{ old('description', $event->description) }}</textarea>
            </div>
        </div>
        
        <!-- Pricing Section -->
        <div class="pricing-section">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_free" name="is_free" value="1" 
                       {{ old('is_free', $event->is_free) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_free">This is a free event</label>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="action-buttons">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Update Event
            </button>
            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times me-2"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection