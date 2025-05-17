<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'user_id',
        'title',
        'session_date',
        'duration',
        'price',
        'status',
        'is_online',

    ];
    protected $table = 'private_sessions'; 
    public function coupons()
    {
        return $this->morphMany(Coupon::class, 'applicable');
    }
    
    

    public function booking_for()
{
    return $this->morphTo();
}

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function bookings()
    {
        return $this->morphMany(Booking::class, 'booking_for', 'booking_for_type', 'booking_for_id');
    }
    

    public function payments()
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }
    

    public function isAvailableAt($datetime)
    {
        return !Booking::where('booking_for_type', self::class)
            ->where('booking_for_id', $this->id)
            ->where('booking_date', $datetime)
            ->whereIn('status', ['enrolled'])
            ->exists();
    }

    public function scopeForPrivateSession($query, $sessionId)
{
    return $query->where('booking_for_type', PrivateSession::class)
                ->where('booking_for_id', $sessionId);
}

public function availableTimes()
{
    return $this->hasMany(AvailableTime::class);
}

public function scopeActive($query)
{
    return $query->where('status', 'active');
}

}
