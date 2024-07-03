<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Communication extends Model
{
    use HasFactory;

    protected $fillable = [
        'UserID',
        'Type',
        'Content',
        'TimeStamp',
        'MessengerLink',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('TimeStamp', 'desc');
    }
}