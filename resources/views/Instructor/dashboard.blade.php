@extends('instructor.layouts.app')

@section('title', 'Instructor Dashboard')

@section('content')
<style>
    :root {
        --primary: #393D72;
        --secondary: rgba(254, 56, 115, 0.3);
        --accent: #1A1C2E;
        --dark: #ff2f6e;
        --light: #F8F9FA;
        --success: #27ae60;
        --info: #3498db;
    }

    .dashboard-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #f8f9fa 100%);
        padding: 25px;
        min-height: 100vh;
    }

    /* ==== Stat Cards ==== */
    .stat-card {
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 25px;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        text-align: center;
        border-left: 5px solid var(--primary);
        position: relative;
        overflow: hidden;
        z-index: 1;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);
        z-index: -1;
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-card h3 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 8px;
        color: var(--accent);
        letter-spacing: -0.5px;
    }

    .stat-card p {
        color: #6c757d;
        font-size: 1.05rem;
        font-weight: 500;
        margin-bottom: 0;
    }

    .stat-card .icon {
        font-size: 2.8rem;
        margin-bottom: 20px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--dark) 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .stat-card:hover .icon {
        animation: float 2s ease-in-out infinite;
    }

    /* ==== Animation ==== */
    @keyframes float {
        0%   { transform: translateY(0px); }
        50%  { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }

    /* ==== Chart Cards ==== */
    .chart-card {
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        margin-bottom: 25px;
        border: none;
        transition: all 0.4s ease;
    }

    .chart-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.12);
    }

    .chart-card .card-header {
        background: transparent;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 20px 25px;
        border-radius: 20px 20px 0 0 !important;
    }

    .chart-card .card-header h5 {
        font-weight: 700;
        color: var(--accent);
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        margin: 0;
    }

    .chart-card .card-header h5 i {
        margin-right: 10px;
        font-size: 1.5rem;
    }

    .chart-container {
        position: relative;
        height: 320px;
        padding: 20px;
    }

    /* ==== Rating Stars ==== */
    .rating-stars {
        font-size: 1.5rem;
        letter-spacing: 2px;
        margin: 10px 0;
    }

    .rating-stars .filled {
        color: #FFC107;
    }

    .rating-stars .empty {
        color: #E0E0E0;
    }

    /* ==== Table Styles ==== */
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
    }

    .table {
        margin-bottom: 0;
    }

    .table th {
        background-color: var(--primary);
        color: white;
        font-weight: 600;
    }

    .table td {
        vertical-align: middle;
    }

    .badge-success {
        background-color: var(--success);
    }

    .badge-warning {
        background-color: #FFC107;
        color: #1A1C2E;
    }

    /* ==== Cards Color Modifiers ==== */
    .students-card {
        border-left-color: var(--success);
    }

    .courses-card {
        border-left-color: var(--info);
    }

    .rating-card {
        border-left-color: #FFC107;
    }

    /* ==== Responsive ==== */
    @media (max-width: 768px) {
        .stat-card h3 {
            font-size: 2rem;
        }

        .chart-container {
            height: 250px;
        }
    }

    .private-session-badge {
        background-color: #9b59b6;
        color: white;
    }
    
    .course-badge {
        background-color: #3498db;
        color: white;
    }
</style>



<!-- Top Courses -->
<body class="dashboard-container">

    <div class="container">
        <h1 class="mb-4 text-center" style="color: var(--accent);">My Dashboard</h1>
    
        <div class="row">
            <div class="col-md-4">
                <div class="stat-card students-card">
                    <div class="icon"><i class="bi bi-people"></i></div>
                    <h3>{{$totalParents}}</h3>
                    <p>My Students</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="stat-card courses-card">
                    <div class="icon"><i class="bi bi-journal-bookmark"></i></div>
                    <h3>{{ $totalCourses }}</h3>
                    <p>My Courses</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="stat-card rating-card">
                    <div class="icon"><i class="bi bi-star-fill"></i></div>
                    <h3>{{ number_format($avgRating, 1) }}</h3>
                    <p>My Average Rating</p>
                </div>
            </div>
        </div>
    </div>

        <div class="chart-card mt-5">
            <div class="card-header">
                <h5><i class="bi bi-table"></i>  Private Session Bookings</h5>
            </div>
            <div class="table-responsive p-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Session Title</th>
                            <th>Selected Time</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestPrivateBookings as $index => $booking)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $booking->student_name ?? $booking->user->name }}</td>
                                <td>{{ $booking->session_title ?? $booking->availableTime->privateSession->title }}</td>
                                <td>{{ $booking->selected_time }}</td>
                                <td>{{ $booking->duration ?? $booking->availableTime->privateSession->duration }}  minutes</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>
@endsection