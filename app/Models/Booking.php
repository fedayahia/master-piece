<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Course;  
use App\Models\PrivateSession;  
use App\Models\CourseSession;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_date',
        'seat_number',
        'status',
        'user_id',
        'available_time_id',
        'booking_for_type',
        'booking_for_id',
    ];

    protected $casts = [
        'booking_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function session()
    {
        return $this->belongsTo(CourseSession::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);  
    }


public function bookingable()
{
    return $this->morphTo(__FUNCTION__, 'booking_for_type', 'booking_for_id');
}


    public function getBookingTypeLabelAttribute()
    {
        if ($this->booking_for_type === \App\Models\Course::class) {
            return 'Course';
        }

        if ($this->booking_for_type === \App\Models\PrivateSession::class) {
            return 'Private Session';
        }

        if ($this->booking_for_type === \App\Models\CourseSession::class) {
            return 'Session';
        }

        return 'Unknown';
    }

    public static function generateSeatNumber()
    {
        return 'SEAT-' . strtoupper(Str::random(6));
    }

    public function booking_for()
    {
        return $this->morphTo(__FUNCTION__, 'booking_for_type', 'booking_for_id');
    }

    public function getBookingForName()
    {
        if ($this->booking_for_type === Course::class) {
            return $this->booking_for ? $this->booking_for->title : 'No Course';
        }

        if ($this->booking_for_type === \App\Models\PrivateSession::class) {
            return $this->booking_for ? $this->booking_for->title : 'No Private Session';
        }

        return 'No Name';
    }

    public function privateSession()
    {
        return $this->belongsTo(PrivateSession::class, 'booking_for_id'); 
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function availableTime()
    {
        return $this->belongsTo(\App\Models\AvailableTime::class);
    }
}
