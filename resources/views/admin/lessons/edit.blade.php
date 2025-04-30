@extends('admin.layouts.app')

@section('title', 'Edit Lesson')

@section('content')
    <div class="container mt-4">
        <h1>Edit Lesson</h1>

        <form action="{{ route('admin.lessons.update', $lesson->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="title">Lesson Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $lesson->title }}" required>
            </div>

            <div class="form-group">
                <label for="course_id">Select Course</label>
                <select name="course_id" id="course_id" class="form-control" required>
                    <option value="">Select Course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ $lesson->course_id == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="content">Lesson Content</label>
                <textarea name="content" id="content" rows="5" class="form-control" required>{{ $lesson->content }}</textarea>
            </div>

            <div class="form-group">
                <label for="video_url">Lesson Video URL</label>
                <input type="url" name="video_url" id="video_url" class="form-control" value="{{ $lesson->video_url }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Lesson</button>
        </form>
    </div>
@endsection
