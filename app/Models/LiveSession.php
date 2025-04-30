<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'meeting_link',
        'platform',
        'is_active',
    ];

    /**
     * Get the users who joined the live session.
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'live_session_user')->withTimestamps()->withPivot('joined_at');
    }
    

    /**
     * Scope a query to only active sessions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if the session is upcoming.
     */
    public function isUpcoming()
    {
        return $this->start_time > now();
    }

    /**
     * Check if the session is ongoing.
     */
    public function isOngoing()
    {
        return now()->between($this->start_time, $this->end_time);
    }

    /**
     * Check if the session has ended.
     */
    public function hasEnded()
    {
        return $this->end_time && $this->end_time < now();
    }
}
