@extends('admin.layouts.app')

@section('title', 'Manage Lessons')

@section('content')
    <div class="container mt-4">
        <h1>Manage Lessons</h1>
        <a href="{{ route('admin.lessons.create') }}" class="btn btn-primary mb-3">Add New Lesson</a>

        {{-- عرض التنبيه للنجاح --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 10px; right: 10px; z-index: 9999; width: 300px;">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Course</th>
                    <th>Content</th>
                    <th>Video URL</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lessons as $lesson)
                    <tr>
                        <td>{{ $lesson->id }}</td>
                        <td>{{ $lesson->title }}</td>
                        <td>{{ $lesson->course->title }}</td>
                        
                        <!-- Content with Link to Open Modal -->
                        <td>
                            <a href="javascript:void(0);" class="btn btn-link" data-toggle="modal" data-target="#lessonModal-{{ $lesson->id }}">
                                View Content
                            </a>
                        </td>

                        <td><a href="{{ $lesson->video_url }}" target="_blank">View Video</a></td>
                        <td>
                            <!-- Edit Icon -->
                            <a href="{{ route('admin.lessons.edit', $lesson->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        
                            <!-- Delete Icon -->
                            <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="lessonModal-{{ $lesson->id }}" tabindex="-1" role="dialog" aria-labelledby="lessonModalLabel-{{ $lesson->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="lessonModalLabel-{{ $lesson->id }}">Lesson: {{ $lesson->title }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h6>Course: {{ $lesson->course->title }}</h6>
                                    <p>{{ $lesson->content }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        {{ $lessons->links() }}
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
