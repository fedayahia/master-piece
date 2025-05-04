<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CourseSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'user_id',
        'title',
        'start_date',
        'end_date',
        'duration',
        'classroom',
        'building',
        'max_seats',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    
    public $timestamps = true;

public function bookings(): MorphMany
{
    return $this->morphMany(\App\Models\Booking::class, 'booking_for');
}

}
