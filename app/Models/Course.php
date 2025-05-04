<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'instructor_id', 'price', 'duration', 'category', 'image', 'seats_available'
    ];
    

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

  
    public function sessions()
    {
        return $this->hasMany(CourseSession::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    
    public function users()
    {
        return $this->belongsToMany(User::class, 'bookings')
                    ->withPivot('status')
                    ->withTimestamps();
    }
    

public function averageRating()
{
    return $this->reviews()->average('rating');
}



public function bookings()
{
    return $this->morphMany(Booking::class, 'booking_for', 'booking_for_type', 'booking_for_id');
}


public function parents()
{
    return $this->hasManyThrough(
        User::class,       
        Booking::class,     
        'course_id',      
        'id',            
        'id',              
        'user_id'
    )->where('role', 'parent')->distinct();
}


public function coupons()
{
    return $this->morphMany(Coupon::class, 'applicable');
}


    use SoftDeletes;
    
    protected $dates = ['deleted_at'];

    public function scopeForCourse($query, $courseId)
    {
        return $query->where('booking_for_type', Course::class)
                    ->where('booking_for_id', $courseId);
    }

    public function booking_for()
{
    return $this->morphTo(); 
}

public function payments()
{
    return $this->morphMany(Payment::class, 'paymentable');
}

}
