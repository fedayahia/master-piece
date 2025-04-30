@extends('instructor.layouts.app')

@section('content')
<div class="container">
    <h2>📚 Students Enrolled in the Course: {{ $course->title }}</h2>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Email</th>
                <th>Enrollment Status</th>
                <th>Enrollment Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enrollments as $enrollment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $enrollment->user->name }}</td>
                    <td>{{ $enrollment->user->email }}</td>
                    <td>
                        <span class="badge badge-{{ $enrollment->status == 'completed' ? 'success' : 'info' }}">
                            {{ ucfirst($enrollment->status) }}
                        </span>
                    </td>
                    <td>{{ $enrollment->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
