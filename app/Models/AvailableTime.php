<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'private_session_id',
        'available_date',
        'is_available',
    ];

    public function bookings()
    {
        return $this->hasMany(\App\Models\Booking::class);
    }
    
    public function privateSession()
    {
        return $this->belongsTo(PrivateSession::class, 'private_session_id');
    }
}
