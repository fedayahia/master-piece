@extends('instructor.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">Edit Session</h1>
        <a href="{{ route('instructor.private-sessions.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('instructor.private-sessions.update', $privateSession->id) }}" 
                  method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="title">Session Title*</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $privateSession->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="duration">Duration (mins)*</label>
                        <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                               id="duration" name="duration" min="15" step="15" 
                               value="{{ old('duration', $privateSession->duration) }}" required>
                        @error('duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="price">Price (JOD)*</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" min="0" step="0.01" 
                               value="{{ old('price', $privateSession->price) }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
<!-- Online Status Toggle -->
<div class="form-group">
    <label>Session Type*</label>
    <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
        <label class="btn btn-outline-primary {{ old('is_online', $privateSession->is_online) ? 'active' : '' }}">
            <input type="radio" name="is_online" value="1" 
                   {{ old('is_online', $privateSession->is_online) ? 'checked' : '' }}> 
            <i class="fas fa-laptop me-2"></i> Online Session
        </label>
        <label class="btn btn-outline-primary {{ !old('is_online', $privateSession->is_online) ? 'active' : '' }}">
            <input type="radio" name="is_online" value="0" 
                   {{ !old('is_online', $privateSession->is_online) ? 'checked' : '' }}>
            <i class="fas fa-map-marker-alt me-2"></i> In-Person Session
        </label>
    </div>
    @error('is_online')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
                <div class="form-group">
                    <label for="description">Description*</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4" required>{{ old('description', $privateSession->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Current Image</label>
                    @if($privateSession->img)
                        <div class="mb-2">
                            <img src="{{ asset('storage/private_sessions/'.$privateSession->img) }}" 
                                 class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    @else
                        <p class="text-muted">No image uploaded</p>
                    @endif

                    <label for="img">Update Image</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('img') is-invalid @enderror" 
                               id="img" name="img">
                        <label class="custom-file-label" for="img">Choose new file</label>
                        @error('img')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">
                        Leave blank to keep current image
                    </small>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Session
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Update file input label
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = e.target.files[0]?.name || "Choose file";
        e.target.nextElementSibling.innerText = fileName;
    });
</script>
@endpush

@push('styles')
<style>
  .btn-group-toggle .btn {
        flex: 1;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem;
    }

    .btn-group-toggle .btn.active {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    /* .btn-group-toggle .btn:not(.active) {
        background-color: white;
    } */

    .btn-group-toggle .btn i {
        margin-right: 0.5rem;
    }

    .container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .section-header h1 {
        color: var(--primary);
        font-size: 1.8rem;
        margin: 0;
    }

    .btn-back {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        border-radius: 4px;
        border: 1px solid var(--primary);
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background-color: rgba(57, 61, 114, 0.1);
        text-decoration: none;
    }

    .form-card {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--dark);
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

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
    }

    .input-group {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        width: 100%;
    }

    .input-group-prepend {
        margin-right: -1px;
        display: flex;
    }

    .input-group-text {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        text-align: center;
        white-space: nowrap;
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: 0.375rem 0 0 0.375rem;
    }

    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }

    .file-upload-wrapper {
        position: relative;
        margin-bottom: 1rem;
    }

    .file-upload-input {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 0.1px;
        height: 0.1px;
    }

    .file-upload-label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        background-color: var(--light);
        border: 2px dashed #ced4da;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        gap: 10px;
    }

    .file-upload-label:hover {
        border-color: var(--primary);
        background-color: rgba(57, 61, 114, 0.05);
    }

    .current-image {
        margin-top: 15px;
    }

    .current-image p {
        margin-bottom: 8px;
        font-size: 0.9rem;
        color: var(--secondary);
    }

    .img-thumbnail {
        max-width: 200px;
        max-height: 200px;
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 4px;
    }

    .image-preview {
        display: none;
        width: 200px;
        height: 200px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #eee;
        margin-top: 10px;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .form-actions {
        display: flex;
        gap: 15px;
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
        border-radius: 0.375rem;
        transition: all 0.2s ease;
        cursor: pointer;
        gap: 8px;
        text-decoration: none;
    }

    .btn-primary {
        color: white;
        background-color: var(--primary);
        border: 1px solid var(--primary);
    }

    .btn-primary:hover {
        background-color: #2c3060;
        border-color: #2c3060;
        transform: translateY(-2px);
        color: white;
    }

    .btn-cancel {
        color: var(--secondary);
        background-color: white;
        border: 1px solid #ced4da;
    }

    .btn-cancel:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: var(--danger);
    }

    .is-invalid {
        border-color: var(--danger) !important;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush