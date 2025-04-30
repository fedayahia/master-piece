<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_amount',
        'discount_type',
        'applicable_id',
        'applicable_type',
        'status',
        'expires_at',
        'usage_limit',
        'used_count'
    ];

    protected $dates = ['expires_at'];


    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>=', now());
            })
            ->where(function($q) {
                $q->whereNull('usage_limit')
                  ->orWhereRaw('used_count < usage_limit');
            });
    }

    public function scopeValidFor($query, $item)
    {
        return $query->where(function($q) use ($item) {
            $q->whereNull('applicable_type')
              ->orWhere([
                  'applicable_type' => get_class($item),
                  'applicable_id' => $item->id
              ]);
        });
    }

    public function isExpired()
    {
        return $this->expires_at && $this->expires_at < now();
    }

    public function isUsageLimitReached()
    {
        return $this->usage_limit && $this->used_count >= $this->usage_limit;
    }

    public function applicable()
{
    return $this->morphTo(__FUNCTION__, 'applicable_type', 'applicable_id');
}
    public function incrementUsage()
    {
        if ($this->usage_limit) {
            $this->increment('used_count');
        }
    }



}