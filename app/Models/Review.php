<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Service;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'UserID',
        'ServiceID',
        'Rating',
        'Comment',
        'ReviewDate',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'ServiceID');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('Rating', 'desc');
    }
}