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

    /* Header Section */
    .section-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--secondary);
    }

    .section-header h2 {
        color: var(--primary);
        font-weight: 600;
        margin: 0;
        font-size: 1.75rem;
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 1.5rem;
    }

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
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
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

    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0;
    }

    .form-check-label {
        margin-bottom: 0;
    }

    /* Image Upload Preview */
    .image-preview-container {
        display: none;
        margin-top: 1rem;
    }

    .image-preview {
        max-width: 200px;
        max-height: 200px;
        border-radius: 0.5rem;
        border: 1px solid #dee2e6;
    }

    /* Buttons */
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

    .btn-secondary {
        color: white;
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(108, 117, 125, 0.2);
    }

    /* Button Icons */
    .btn i {
        margin-right: 0.5rem;
        font-size: 0.875em;
    }

    /* Button Group */
    .d-flex.gap-2 {
        gap: 1rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 767px) {
        .container {
            padding: 1.5rem;
        }
        
        .row > [class^="col-"] {
            margin-bottom: 1rem;
        }
        
        .btn {
            width: 100%;
            padding: 0.75rem;
        }
        
        .d-flex.gap-2 {
            flex-direction: column;
            gap: 0.75rem;
        }
    }

    /* Date and Time Inputs */
    input[type="date"],
    input[type="time"] {
        appearance: none;
        -webkit-appearance: none;
    }

    /* Validation Errors */
    .is-invalid {
        border-color: var(--dark);
    }

    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: var(--dark);
    }

    .is-invalid ~ .invalid-feedback {
        display: block;
    }
</style>

<div class="container">
    <div class="section-header">
        <h2>Create New Event</h2>
    </div>

    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Basic Information -->
        <div class="row mb-3">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="title" class="form-label">Event Title *</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="instructor" class="form-label">Instructor</label>
                    <input type="text" id="instructor" name="instructor" class="form-control" value="{{ old('instructor') }}">
                </div>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="description" class="form-label">Event Description *</label>
            <textarea id="description" name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
        </div>

        <!-- Date & Time -->
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="event_date" class="form-label">Event Date *</label>
                    <input type="date" id="event_date" name="event_date" class="form-control" value="{{ old('event_date') }}" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="start_time" class="form-label">Start Time *</label>
                    <input type="time" id="start_time" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="end_time" class="form-label">End Time *</label>
                    <input type="time" id="end_time" name="end_time" class="form-control" value="{{ old('end_time') }}" required>
                </div>
            </div>
        </div>

        <!-- Location & Image -->
        <div class="row mb-3">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="location" class="form-label">Location *</label>
                    <input type="text" id="location" name="location" class="form-control" value="{{ old('location') }}" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="image" class="form-label">Event Image</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*">
                    <div class="image-preview-container mt-2">
                        <img id="imagePreview" src="#" alt="Image Preview" class="image-preview">
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing -->
        <div class="form-group mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_free" name="is_free" value="1" {{ old('is_free', 1) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_free">This is a free event</label>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Create Event
            </button>
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i> Cancel
            </a>
        </div>
    </form>
</div>

<script>
    // Image preview functionality
    document.getElementById('image').addEventListener('change', function(e) {
        const previewContainer = document.querySelector('.image-preview-container');
        const preview = document.getElementById('imagePreview');
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            
            reader.readAsDataURL(this.files[0]);
        } else {
            previewContainer.style.display = 'none';
            preview.src = '#';
        }
    });
</script>
@endsection