@extends('instructor.layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">Create New Session</h1>
        <a href="{{ route('instructor.private-sessions.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('instructor.private-sessions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="title">Session Title*</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="duration">Duration (mins)*</label>
                        <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                               id="duration" name="duration" min="15" step="15" 
                               value="{{ old('duration') }}" required>
                        @error('duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="price">Price ($)*</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" min="0" step="0.01" 
                               value="{{ old('price') }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description*</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="img">Session Image</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('img') is-invalid @enderror" 
                               id="img" name="img">
                        <label class="custom-file-label" for="img">Choose file</label>
                        @error('img')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">
                        Max 2MB (JPG, JPEG, PNG)
                    </small>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Create Session
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
        var fileName = e.target.files[0].name;
        e.target.nextElementSibling.innerText = fileName;
    });
</script>
@endpush

@push('styles')
<style>
    :root {
        --primary: #393D72;
            --secondary:  rgba(254, 56, 115, 0.3);
            --accent:#1A1C2E ;
            --dark:   #ff2f6e;
            --light: #F8F9FA;
            --sidebar-width: 250px;
            --navbar-height: 60px;
    }

    .container {
        max-width: 800px;
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
        gap: 5px;
    }

    .btn-back:hover {
        text-decoration: underline;
    }

    .form-container {
        background: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    .form-group.col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
        padding-right: 15px;
        padding-left: 15px;
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
        min-height: 120px;
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

    .image-preview {
        display: none;
        width: 150px;
        height: 150px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #eee;
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
    }

    .btn-reset {
        color: var(--secondary);
        background-color: white;
        border: 1px solid #ced4da;
    }

    .btn-reset:hover {
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
        .form-group.col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
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
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
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