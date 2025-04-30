@extends('instructor.layouts.app')

@section('content')
<div class="container">
    <h2>My Available Time Slots</h2>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th>Assigned Session</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($availableTimes as $slot)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($slot->available_date)->format('M d, Y H:i') }}</td>
                    <td>
                        @if($slot->is_available)
                            <span class="badge bg-success">Available</span>
                        @else
                            <span class="badge bg-danger">Booked</span>
                        @endif
                    </td>
                    <td>
                        @if($slot->privateSession)
                            {{ $slot->privateSession->title }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($slot->is_available)
                            <form action="{{ route('instructor.available_times.destroy', $slot->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        @else
                            <button class="btn btn-sm btn-secondary" disabled>Cannot delete booked session</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <a href="{{ route('instructor.available_times.create') }}" class="btn btn-primary">
        Add New Time Slot
    </a>
</div>
@endsection