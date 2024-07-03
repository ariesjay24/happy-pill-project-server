<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Booking;
use App\Models\User;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'BookingID',
        'UserID',
        'Amount',
        'PaymentDate',
        'PaymentMethod',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'BookingID');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('PaymentDate', 'desc');
    }
}