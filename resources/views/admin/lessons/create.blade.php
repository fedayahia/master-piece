@extends('admin.layouts.app')

@section('title', 'Add New Lesson')

@section('content')
    <div class="container mt-4">
        <h1>Add New Lesson</h1>

        <form action="{{ route('admin.lessons.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Lesson Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="course_id">Select Course</label>
                <select name="course_id" id="course_id" class="form-control" required>
                    <option value="">Select Course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="content">Lesson Content</label>
                <textarea name="content" id="content" rows="5" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="video_url">Lesson Video URL</label>
                <input type="url" name="video_url" id="video_url" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Create Lesson</button>
        </form>
    </div>
@endsection
