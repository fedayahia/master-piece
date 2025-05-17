@extends('layouts.master')

@section('content')
<style>
    :root {
        --primary: #6c5ce7;
        --primary-light: #a29bfe;
        --secondary: #fd79a8;
        --dark: #2d3436;
        --light: #f5f6fa;
        --white: #ffffff;
        --gray-light: #dfe6e9;
    }

    .chat-sections-container {
        display: flex;
        gap: 2rem;
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .chat-section {
        flex: 1;
        background: var(--white);
        border-radius: 1.5rem;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(108, 92, 231, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .section-header {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--gray-light);
        position: relative;
    }

    .section-header::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        border-radius: 3px;
    }

    .section-header i {
        font-size: 1.5rem;
        color: var(--primary);
        margin-right: 1rem;
    }

    .section-header h3 {
        margin: 0;
        font-weight: 700;
        color: var(--dark);
        font-size: 1.5rem;
    }

    /* Courses Section */
    .course-card {
        background: var(--white);
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 15px rgba(108, 92, 231, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(108, 92, 231, 0.2);
    }

    .course-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(to right, var(--primary), var(--secondary));
    }

    .course-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .course-meta {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 0.85rem;
        color: var(--primary);
    }

    .course-meta i {
        margin-right: 0.5rem;
    }

    .course-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .course-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        flex: 1;
    }

    .course-btn i {
        margin-right: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        box-shadow: 0 4px 10px rgba(108, 92, 231, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-light), var(--secondary));
        box-shadow: 0 6px 15px rgba(108, 92, 231, 0.4);
        color: white;
    }

    .btn-outline {
        border: 1px solid var(--primary-light);
        color: var(--primary);
        background: rgba(108, 92, 231, 0.05);
    }

    .btn-outline:hover {
        background: rgba(108, 92, 231, 0.1);
    }

    /* Users Section */
    .user-card {
        display: flex;
        align-items: center;
        padding: 1.25rem;
        background: var(--white);
        border-radius: 1rem;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.05);
        margin-bottom: 1rem;
    }

    .user-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(108, 92, 231, 0.2);
        border-color: var(--primary-light);
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.25rem;
        margin-right: 1.25rem;
        flex-shrink: 0;
    }

    .user-info {
        flex-grow: 1;
    }

    .user-name {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.25rem;
        font-size: 1.1rem;
    }

    .user-role {
        font-size: 0.85rem;
        color: var(--primary);
        background: rgba(108, 92, 231, 0.1);
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        display: inline-block;
        font-weight: 500;
    }

    .chat-btn {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 2rem;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 10px rgba(108, 92, 231, 0.3);
        text-decoration: none;
    }

    .chat-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(108, 92, 231, 0.4);
        background: linear-gradient(135deg, var(--primary-light), var(--secondary));
        color: white;
    }

    .chat-btn i {
        margin-right: 0.5rem;
    }

    /* Empty States */
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--dark);
        opacity: 0.7;
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--primary-light);
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state p {
        font-size: 1.1rem;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .chat-sections-container {
            flex-direction: column;
        }
    }
</style>

<div class="chat-sections-container">
    <!-- Courses Section -->
    <div class="chat-section">
        <div class="section-header">
            <i class="fas fa-book-open"></i>
            <h3>Course Chats</h3>
        </div>
        
        @if(count($courses) > 0)
            @foreach($courses as $course)
                <div class="course-card">
                    <h4 class="course-title">{{ $course->title }}</h4>
                    <div class="course-meta">
                        <i class="fas fa-chalkboard-teacher"></i>
                        Instructor: {{ $course->instructor->name }}
                    </div>
                    
                    <div class="course-actions">
                        @if($authUser->role === 'instructor')
                            <a href="{{ route('chat.group', ['course' => $course->id]) }}" class="course-btn btn-primary">
                                <i class="fas fa-users"></i> Group Chat
                            </a>
                        @endif
                        
                        @if($authUser->role === 'parent')
                        <a href="{{ route('chat.group', ['course' => $course->id]) }}" class="course-btn btn-primary">
                            <i class="fas fa-users"></i> Group Chat
                        </a>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fas fa-book-open"></i>
                <p>No courses to chat about</p>
            </div>
        @endif
    </div>

    <!-- Users Section -->
    <div class="chat-section">
        <div class="section-header">
            <i class="fas fa-comments"></i>
            <h3>Start a New Chat</h3>
        </div>
        
        @if(count($users) > 0)
            @foreach($users as $user)
                <div class="user-card">
                    <div class="user-avatar">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ $user->name }}</div>
                        <span class="user-role">{{ ucfirst($user->role) }}</span>
                    </div>
                    <a href="{{ route('chat.show', $user->id) }}" class="chat-btn">
                        <i class="fas fa-paper-plane"></i> Chat
                    </a>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fas fa-user-friends"></i>
                <p>No users available to chat with</p>
            </div>
        @endif
    </div>
</div>
@endsection