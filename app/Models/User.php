<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone_number', 'image'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function enrollments()
    {
        return $this->hasMany(\App\Models\Enrollment::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'bookings')
                    ->withPivot('status')
                    ->withTimestamps();
    }
    

    public function managedCourses()
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    

    public function isParent()
    {
        return $this->role === 'parent';
    }
    public function payments() {
        return $this->hasManyThrough(Payment::class, Booking::class);
    }

public function bookings()
{
    return $this->hasMany(Booking::class); 
}

    

public function reviews()
{
    return $this->hasMany(Review::class);
}

public function hasReviewedCourse($courseId)
{
    return $this->reviews()->where('course_id', $courseId)->exists();
}

public function hasBookedCourse($courseId)
{
    return $this->bookings()->where('course_id', $courseId)->exists();
}

public function averageRating()
{
    return $this->hasMany(Review::class)->avg('rating'); 
}

public function totalReviews()
{
    return $this->hasMany(Review::class)->count(); 
}

public function enrolledCourses()
{
    return $this->belongsToMany(Course::class, 'course_parent', 'parent_id', 'course_id');
}

use HasFactory, Notifiable, SoftDeletes;
public function joinedLiveSessions()
{
    return $this->belongsToMany(LiveSession::class, 'live_session_user')->withTimestamps()->withPivot('joined_at');
}


public function courseReviews()
{
    return $this->hasManyThrough(
        \App\Models\Review::class,
        \App\Models\Course::class,
        'instructor_id',
        'course_id',    
        'id',          
        'id'            
    );
}
}
