@extends('admin.layouts.app')

@section('content')
<style>
    /* Main Container */
    .container {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
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

    /* Form Sections */
    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px dashed #eee;
    }

    .form-section h4 {
        color: var(--accent);
        margin-bottom: 1.25rem;
        font-weight: 500;
    }

    /* Form Groups */
    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--primary);
    }

    /* Form Controls */
   /* تعديل لحل مشكلة النصوص في input وtextarea */
.form-control {
    padding: 0.75rem 1rem; /* تأكد من أن هناك مساحة داخلية كافية */
    font-size: 1rem; /* تأكد من أن الخط بالحجم المناسب */
    line-height: 1.5; /* تحسين المسافة بين الأسطر */
    height: auto; /* تأكد من أن الصندوق يحتوي على مساحة كافية لعرض النص */
}

textarea.form-control {
    min-height: 120px; /* تأكد من أنه يوجد مساحة كافية لعرض النص */
    resize: vertical;
    line-height: 1.5; /* تأكد من المسافة بين الأسطر داخل الـ textarea */
}

    .form-control:focus {
        border-color: var(--primary);
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(57, 61, 114, 0.25);
    }


    /* Image Preview */
    .image-preview {
        margin-top: 1rem;
        display: none;
    }

    .image-preview img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 0.375rem;
        border: 1px solid #dee2e6;
        object-fit: cover;
    }

    /* Buttons */
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
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

    /* Error Handling */
    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    /* Grid Layout for Larger Screens */
    @media (min-width: 768px) {
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
    }

    /* Responsive Adjustments */
    @media (max-width: 576px) {
        .container {
            padding: 1.5rem;
        }
        
        .btn {
            width: 100%;
        }
    }
</style>

<div class="container">
    <h1>Create New Course</h1>

    <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Basic Information Section -->
        <div class="form-section">
            <h4>Basic Information</h4>
            
            <div class="form-group">
                <label for="title">Course Title *</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                       value="{{ old('title') }}" required>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="instructor_id">Instructor *</label>
                <select name="instructor_id" id="instructor_id" class="form-control @error('instructor_id') is-invalid @enderror" required>
                    <option value="">Select Instructor</option>
                    @foreach($instructors as $instructor)
                        <option value="{{ $instructor->id }}" {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                            {{ $instructor->name }}
                        </option>
                    @endforeach
                </select>
                @error('instructor_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <!-- Course Details Section -->
        <div class="form-section">
            <h4>Course Details</h4>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="price">Price *</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" 
                               value="{{ old('price') }}" step="0.01" min="0" required>
                    </div>
                    @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="duration">Duration (hours) *</label>
                    <div class="input-group">
                        <input type="number" name="duration" id="duration" class="form-control @error('duration') is-invalid @enderror" 
                               value="{{ old('duration') }}" min="1" required>
                        <span class="input-group-text">hrs</span>
                    </div>
                    @error('duration')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                    <option value="">Select Category</option>
                    <option value="Newborn Care" {{ old('category') == 'Newborn Care' ? 'selected' : '' }}>Newborn Care</option>
                    <option value="Positive Parenting" {{ old('category') == 'Positive Parenting' ? 'selected' : '' }}>Positive Parenting</option>
                    <option value="Mother and Child Health" {{ old('category') == 'Mother and Child Health' ? 'selected' : '' }}>Mother and Child Health</option>
                    <option value="Child First Aid" {{ old('category') == 'Child First Aid' ? 'selected' : '' }}>Child First Aid</option>
                    <option value="Family Communication" {{ old('category') == 'Family Communication' ? 'selected' : '' }}>Family Communication</option>
                </select>
                @error('category')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <!-- Media & Availability Section -->
        <div class="form-section">
            <h4>Media & Availability</h4>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="seats_available">Seats Available *</label>
                    <input type="number" name="seats_available" id="seats_available" class="form-control @error('seats_available') is-invalid @enderror" 
                           value="{{ old('seats_available') }}" min="1" required>
                    @error('seats_available')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="image">Course Image</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" 
                           accept="image/*" onchange="previewImage(this)">
                    @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    
                    <div class="image-preview" id="imagePreview">
                        <p class="small text-muted mb-1">Image Preview:</p>
                        <img id="previewImage" src="#" alt="Course image preview">
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="form-group text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Create Course
            </button>
                         <!-- Cancel Button -->

            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                <i class="fas fa-times-circle"></i> Cancel
            </a>
        </div>
            
    </form>
</div>


<script>
    // Image preview functionality
    function previewImage(input) {
        const preview = document.getElementById('previewImage');
        const previewContainer = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            previewContainer.style.display = 'none';
        }
    }
</script>
@endsection