<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\PrivateSession;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;


class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'method',
        'payment_date',
        'user_id',
        'payment_for_type',
        'payment_for_id',
        'amount',
        'booking_id',
        'payment_method',
        'status',
        'transaction_id',
        'paid_at',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'paid_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        Relation::morphMap([
            'Course' => \App\Models\Course::class,
            'PrivateSession' => \App\Models\PrivateSession::class,
        ]);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function paymentable()
    {
        return $this->morphTo();
    }
    
protected $appends = ['item_name', 'item_type'];

public function getItemNameAttribute()
{
    if (!$this->paymentable) return 'Unknown';
    
    return $this->paymentable instanceof Course 
        ? $this->paymentable->name 
        : $this->paymentable->title;
}

public function getItemTypeAttribute()
{
    if (!$this->paymentable) return 'Unknown';
    
    return $this->paymentable instanceof Course 
        ? 'Course' 
        : 'Private Session';
}

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
