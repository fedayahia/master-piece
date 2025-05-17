@extends('instructor.layouts.app')

@section('title', 'Parents in My Courses')

@section('content')
<style>
    :root {
        --primary: #393D72;
        --secondary: rgba(254, 56, 115, 0.3);
        --accent: #1A1C2E;
        --dark: #ff2f6e;
        --light: #F8F9FA;
        --sidebar-width: 250px;
        --navbar-height: 60px;
        --primary-light: #505498;
        --text-dark: #4a4a4a;
        --text-light: #6c757d;
        --border-radius: 12px;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        --session-color: #9b59b6;
        --session-light: rgba(155, 89, 182, 0.1);
    }
    
    .parents-dashboard {
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .dashboard-header {
        padding: 1.5rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
    }
    
    .dashboard-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .dashboard-subtitle {
        font-size: 0.95rem;
        opacity: 0.9;
    }
    
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        padding: 1.5rem;
        background-color: var(--light);
    }
    
    .stat-card {
        background: white;
        padding: 1.25rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        text-align: center;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        border-top: 3px solid var(--primary);
    }
    
    .stat-card:nth-child(2) {
        border-top-color: var(--dark);
    }
    
    .stat-card:nth-child(3) {
        border-top-color: var(--accent);
    }
    
    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }
    
    .stat-card:nth-child(2) .stat-value {
        color: var(--dark);
    }
    
    .stat-card:nth-child(3) .stat-value {
        color: var(--accent);
    }
    
    .stat-label {
        font-size: 0.85rem;
        color: var(--text-light);
        font-weight: 500;
    }
    
    .tab-container {
        display: flex;
        background-color: white;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 0 1.5rem;
    }
    
    .tab {
        padding: 1rem 1.5rem;
        cursor: pointer;
        font-weight: 500;
        color: var(--text-light);
        position: relative;
        transition: var(--transition);
        font-size: 0.95rem;
        border-bottom: 3px solid transparent;
    }
    
    .tab:hover {
        color: var(--primary);
        background-color: rgba(57, 61, 114, 0.05);
    }
    
    .tab.active {
        color: var(--primary);
        font-weight: 600;
        border-bottom-color: var(--primary);
    }
    
    .course-section {
        padding: 0;
    }
    
    .section-title {
        padding: 1rem 1.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background-color: white;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        color: var(--primary);
    }
    
    .section-title i {
        color: var(--primary);
    }
    
    .section-title.session {
        color: var(--session-color);
    }
    
    .section-title.session i {
        color: var(--session-color);
    }
    
    .parents-grid-container {
        padding: 1.5rem;
    }
    
    .course-group {
        margin-bottom: 2rem;
        background-color: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }
    
    .course-group:hover {
        box-shadow: var(--shadow-md);
    }
    
    .course-header {
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: white;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .course-title {
        font-weight: 600;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--text-dark);
    }
    
    .course-title i {
        color: var(--primary);
        font-size: 1rem;
    }
    
    .session-group .course-title i {
        color: var(--session-color);
    }
    
    .parents-count {
        background-color: var(--secondary);
        padding: 0.35rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.8rem;
        font-weight: 500;
        color: var(--dark);
    }
    
    .session-group .parents-count {
        background-color: var(--session-light);
        color: var(--session-color);
    }
    
    .parents-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
        padding: 1.5rem;
        background-color: var(--light);
    }
    
    .parent-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        padding: 1.25rem;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        border-left: 3px solid var(--primary);
    }
    
    .session-group .parent-card {
        border-left-color: var(--session-color);
    }
    
    .parent-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }
    
    .parent-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .parent-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }
    
    .parent-avatar:hover {
        transform: scale(1.1);
    }
    
    .parent-details {
        flex: 1;
        min-width: 0;
    }
    
    .parent-name {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
        font-size: 0.95rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .parent-contact {
        font-size: 0.8rem;
        color: var(--text-light);
    }
    
    .contact-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .contact-item i {
        width: 16px;
        text-align: center;
        color: var(--primary);
        font-size: 0.8rem;
    }
    
    .session-group .contact-item i {
        color: var(--session-color);
    }
    
    .empty-parents {
        padding: 2.5rem;
        text-align: center;
        color: var(--text-light);
        grid-column: 1 / -1;
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
    }
    
    .empty-icon {
        font-size: 2.5rem;
        color: rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
    }
    
    .empty-parents h4 {
        font-size: 1.1rem;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }
    
    .empty-parents p {
        font-size: 0.9rem;
        max-width: 400px;
        margin: 0 auto;
    }
    
    @media (max-width: 768px) {
        .stats-container {
            grid-template-columns: 1fr;
        }
        
        .parents-grid {
            grid-template-columns: 1fr;
        }
        
        .course-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }
        
        .parents-count {
            margin-left: auto;
        }
    }
    
    @media (max-width: 576px) {
        .dashboard-header {
            padding: 1.25rem;
        }
        
        .dashboard-title {
            font-size: 1.25rem;
        }
        
        .tab-container {
            padding: 0 1rem;
        }
        
        .tab {
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
        }
        
        .parents-grid-container {
            padding: 1rem;
        }
        
        .parent-card {
            padding: 1rem;
        }
        
        .parent-info {
            gap: 0.75rem;
        }
        
        .parent-avatar {
            width: 45px;
            height: 45px;
        }
    }
    .contact-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem; 
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.5rem; 
}

.contact-item i {
    width: 1rem; 
    text-align: center;
}
    </style>
<div class="parents-dashboard">
    <div class="dashboard-header">
        <div class="dashboard-title">
            <i class="fas fa-users"></i> Parents in My Courses
        </div>
        <div class="dashboard-subtitle">
            View and manage parents enrolled in your courses and private sessions
        </div>
    </div>

    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-value">{{ $totalParents }}</div>
            <div class="stat-label">Total Parents</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $coursesCount }}</div>
            <div class="stat-label">Courses</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $sessionsCount }}</div>
            <div class="stat-label">Private Sessions</div>
        </div>
    </div>

    <div class="tab-container">
        <div class="tab active">By Course/Session</div>
    </div>

    <div id="by-course-section" class="course-section">
        <!-- قسم الكورسات -->
        @if($courseBookings->isNotEmpty())
            <div class="section-title">
                <i class="fas fa-book-open"></i> Parents in Courses
            </div>
            <div class="parents-grid-container">
                @foreach($courseBookings as $courseTitle => $bookings)
                <div class="course-group">
                    <div class="course-header">
                        <div class="course-title">
                            <i class="fas fa-book"></i> {{ $courseTitle }}
                        </div>
                        <div class="parents-count">
                            {{ $bookings->count() }} parents
                        </div>
                    </div>
                    
                    <div class="parents-grid">
                        @foreach($bookings as $booking)
                        <div class="parent-card">
                            <div class="parent-info">
                                <img src="{{ asset('images/default-avatar.png') }}" 
                                     class="parent-avatar" alt="{{ $booking->user_name }}">
                                <div class="parent-details">
                                    <div class="parent-name">{{ $booking->user_name }}</div>
                                    <div class="parent-contact">
                                        <div class="contact-info">
                                            <div class="contact-item">
                                                <i class="fas fa-envelope"></i>
                                                <span>{{ $booking->user_email }}</span>
                                            </div>
                                            <div class="contact-item">
                                                <i class="fas fa-phone"></i>
                                                <span>{{ $booking->phone }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="booking-date">
                                        <small>
                                            <i class="fas fa-calendar-alt"></i> 
                                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        @endif

        @if($sessionBookings->isNotEmpty())
            <div class="section-title session">
                <i class="fas fa-calendar-check"></i> Parents in Private Sessions
            </div>
            <div class="parents-grid-container">
                @foreach($sessionBookings as $sessionTitle => $bookings)
                <div class="course-group session-group">
                    <div class="course-header">
                        <div class="course-title">
                            <i class="fas fa-calendar-alt"></i> {{ $sessionTitle }}
                        </div>
                        <div class="parents-count">
                            {{ $bookings->count() }} parents
                        </div>
                    </div>
                    
                    <div class="parents-grid">
                        @foreach($bookings as $booking)
                        <div class="parent-card">
                            <div class="parent-info">
                                <img src="{{ asset('images/default-avatar.png') }}" 
                                     class="parent-avatar" alt="{{ $booking->user_name }}">
                                <div class="parent-details">
                                    <div class="parent-name">{{ $booking->user_name }}</div>
                                    <div class="parent-contact">
                                        <div class="contact-info">
                                            <div class="contact-item">
                                                <i class="fas fa-envelope"></i>
                                                <span>{{ $booking->user_email }}</span>
                                            </div>
                                            <div class="contact-item">
                                                <i class="fas fa-phone"></i>
                                                <span>{{ $booking->phone }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="booking-date">
                                        <small>
                                            <i class="fas fa-calendar-alt"></i> 
                                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        @endif

        @if($courseBookings->isEmpty() && $sessionBookings->isEmpty())
            <div class="empty-parents" style="margin: 2rem;">
                <div class="empty-icon">
                    <i class="fas fa-book"></i>
                </div>
                <h4>No Courses or Sessions Yet</h4>
                <p>You don't have any courses or private sessions with enrolled parents at the moment.</p>
            </div>
        @endif
    </div>
</div>
@endsection