@extends('instructor.layouts.app')

@section('title', 'Instructor Reviews')

@section('content')
<style>
:root {
    --primary: #393D72;
    --secondary: rgba(254, 56, 115, 0.15);
    --accent: #1A1C2E;
    --dark: #ff2f6e;
    --light: #F8F9FA;
    --star: #FFD700;
    --shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
    --primary-light: #505498;
    --text-dark: #4a4a4a;
    --text-light: #6c757d;
    --border-radius: 12px;
    --transition: all 0.25s cubic-bezier(0.3, 0.1, 0.2, 1);
}

.reviews-container {
    background-color: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    margin-bottom: 30px;
}

.stats-container {
    display: flex;
    gap: 20px;
    padding: 25px;
    background: var(--secondary);
    border-bottom: 1px solid rgba(254, 56, 115, 0.1);
}

.stat-card {
    flex: 1;
    background: white;
    padding: 20px;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    text-align: center;
    transition: var(--transition);
    border-top: 3px solid var(--primary);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 8px;
}

.stat-label {
    font-size: 14px;
    color: var(--dark);
    font-weight: 600;
    letter-spacing: 0.5px;
}

.tab-container {
    display: flex;
    background: var(--secondary);
    padding: 0 30px;
}

.tab {
    padding: 18px 25px;
    cursor: pointer;
    font-weight: 600;
    color: var(--primary);
    position: relative;
    transition: var(--transition);
    font-size: 0.95rem;
}

.tab:hover {
    color: var(--dark);
    background: rgba(255, 255, 255, 0.3);
}

.tab.active {
    color: var(--dark);
}

.tab.active::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: var(--dark);
}

/* Compact Table Style */
.reviews-table {
    width: 100%;
    border-collapse: collapse;
}

.reviews-table thead {
    background: linear-gradient(to right, var(--primary), var(--primary-light));
    color: white;
}

.reviews-table th {
    padding: 15px 20px;
    text-align: left;
    font-weight: 600;
    font-size: 0.95rem;
}

.reviews-table td {
    padding: 15px 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    vertical-align: middle;
}

.reviews-table tr:last-child td {
    border-bottom: none;
}

.reviews-table tr:hover {
    background-color: rgba(57, 61, 114, 0.03);
}

.user-info-compact {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-avatar-sm {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.rating-stars {
    color: var(--star);
    font-size: 16px;
    display: inline-flex;
    gap: 2px;
}

.course-badge-sm {
    background: rgba(57, 61, 114, 0.1);
    color: var(--primary);
    padding: 4px 12px;
    border-radius: 20px;
    font-weight: 500;
    font-size: 0.8rem;
    white-space: nowrap;
}

.review-content-compact {
    color: var(--text-dark);
    font-size: 0.9rem;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.review-date-sm {
    font-size: 0.8rem;
    color: var(--text-light);
    white-space: nowrap;
}

.action-btns {
    display: flex;
    gap: 8px;
}

.btn-action {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    border: none;
    cursor: pointer;
    transition: var(--transition);
}

.btn-action:hover {
    transform: translateY(-2px);
}

.btn-view {
    background-color: var(--primary);
}

.btn-edit {
    background-color: #17a2b8;
}

.btn-delete {
    background-color: var(--dark);
}

.empty-reviews {
    padding: 60px;
    text-align: center;
    color: var(--text-light);
}

.empty-icon {
    font-size: 60px;
    color: rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .stats-container {
        flex-direction: column;
        gap: 15px;
        padding: 20px;
    }
    
    .stat-card {
        padding: 18px;
    }
    
    .tab-container {
        padding: 0 15px;
    }
    
    .tab {
        padding: 15px;
        font-size: 0.9rem;
    }
    
    .reviews-table th, 
    .reviews-table td {
        padding: 12px 15px;
    }
    
    .review-content-compact {
        -webkit-line-clamp: 3;
    }
}

/* For mobile view - stack table cells */
@media (max-width: 576px) {
    .reviews-table thead {
        display: none;
    }
    
    .reviews-table tr {
        display: block;
        margin-bottom: 15px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        padding-bottom: 15px;
    }
    
    .reviews-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
        border-bottom: none;
    }
    
    .reviews-table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: var(--primary);
        margin-right: 15px;
        flex: 1;
    }
    
    .reviews-table td > div {
        flex: 2;
        text-align: right;
    }
    
    .action-btns {
        justify-content: flex-end;
    }
}
</style>

<div class="reviews-container">
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-value">{{ $totalReviews }}</div>
            <div class="stat-label">Total Reviews</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ number_format($averageRating, 1) }}/5</div>
            <div class="stat-label">Average Rating</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $courses->count() }}</div>
            <div class="stat-label">Courses Taught</div>
        </div>
    </div>

    <div class="tab-container">
        <div class="tab active" onclick="showAllReviews()">All Reviews</div>
        <div class="tab" onclick="showCourseReviews()">By Course</div>
    </div>

    <!-- All Reviews Section -->
    <div id="all-reviews-section" class="p-4">
        @if($reviews->count() > 0)
            <div class="table-responsive">
                <table class="reviews-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Rating</th>
                            <th>Course</th>
                            <th>Review</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $review)
                        <tr>
                            <td data-label="Student">
                                <div class="user-info-compact">
                                    <img src="{{ asset('storage/profile_images/'.$review->user->image) }}" class="user-avatar-sm" alt="{{ $review->user->name }}">
                                    <span>{{ $review->user->name }}</span>
                                </div>
                            </td>
                            <td data-label="Rating">
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                    @endfor
                                </div>
                            </td>
                            <td data-label="Course">
                                <span class="course-badge-sm">{{ $review->course->title }}</span>
                            </td>
                            <td data-label="Review">
                                <div class="review-content-compact" title="{{ $review->comment }}">
                                    {{ $review->comment }}
                                </div>
                            </td>
                            <td data-label="Date">
                                <div class="review-date-sm">
                                    {{ $review->created_at ? $review->created_at->format('M d, Y') : '—' }}
                                </div>
                            </td>
                        
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-reviews">
                <div class="empty-icon">
                    <i class="far fa-comment-dots"></i>
                </div>
                <h4>No Reviews Yet</h4>
                <p>You haven't received any reviews for your courses yet.</p>
            </div>
        @endif
    </div>

    <!-- Course Reviews Section -->
    <div id="course-reviews-section" class="p-4" style="display: none;">
        @foreach($courses as $course)
        <div class="mb-5">
            <div style="padding: 15px 20px; background: #f9f9f9; border-radius: var(--border-radius) var(--border-radius) 0 0;">
                <h5 style="margin: 0; color: var(--primary);">{{ $course->title }}</h5>
                @if($course->reviews->count() > 0)
                <div style="display: flex; align-items: center; gap: 10px; margin-top: 8px;">
                    <div class="rating-stars">
                        @php $avgRating = $course->reviews->avg('rating') @endphp
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $avgRating ? '' : '-o' }}"></i>
                        @endfor
                    </div>
                    <small style="color: var(--text-light);">
                        {{ number_format($avgRating, 1) }} ({{ $course->reviews->count() }} reviews)
                    </small>
                </div>
                @endif
            </div>
            
            @if($course->reviews->count() > 0)
                <div class="table-responsive">
                    <table class="reviews-table">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($course->reviews as $review)
                            <tr>
                                <td data-label="Student">
                                    <div class="user-info-compact">
                                        <img src="{{ asset('storage/profile_images/' . $review->user->image) }}" class="user-avatar-sm" alt="{{ $review->user->name }}">
                                        
                                        <span>{{ $review->user->name }}</span>
                                    </div>
                                </td>
                                <td data-label="Rating">
                                    <div class="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                </td>
                                <td data-label="Review">
                                    <div class="review-content-compact" title="{{ $review->comment }}">
                                        {{ $review->comment }}
                                    </div>
                                </td>
                                <td data-label="Date">
                                    <div class="review-date-sm">
                                        {{ $review->created_at ? $review->created_at->format('M d, Y') : '—' }}
                                    </div>
                                </td>
                             
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="padding: 30px; text-align: center; color: var(--text-light); background: white; border-radius: 0 0 var(--border-radius) var(--border-radius);">
                    <i class="far fa-comment-alt" style="font-size: 30px; opacity: 0.2; margin-bottom: 15px;"></i>
                    <p style="margin-top: 10px; font-size: 0.95rem;">No reviews for this course yet</p>
                </div>
            @endif
        </div>
        @endforeach
    </div>
</div>

<script>
    function showAllReviews() {
        document.getElementById('all-reviews-section').style.display = 'block';
        document.getElementById('course-reviews-section').style.display = 'none';
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('active');
        });
        document.querySelectorAll('.tab')[0].classList.add('active');
    }

    function showCourseReviews() {
        document.getElementById('all-reviews-section').style.display = 'none';
        document.getElementById('course-reviews-section').style.display = 'block';
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('active');
        });
        document.querySelectorAll('.tab')[1].classList.add('active');
    }

    function viewReview(reviewId) {
        // Implement view functionality
        alert('View review ID: ' + reviewId);
        // window.location.href = `/instructor/reviews/${reviewId}`;
    }

    function editReview(reviewId) {
        // Implement edit functionality
        alert('Edit review ID: ' + reviewId);
        // window.location.href = `/instructor/reviews/${reviewId}/edit`;
    }

    function deleteReview(reviewId) {
        if (confirm('Are you sure you want to delete this review?')) {
            // Implement delete functionality
            alert('Delete review ID: ' + reviewId);
            // You can use fetch API to send a delete request
            /*
            fetch(`/instructor/reviews/${reviewId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                }
            });
            */
        }
    }
</script>
@endsection