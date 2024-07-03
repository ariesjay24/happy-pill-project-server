<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Service;
use App\Models\Availability;

class Photographer extends Model
{
    use HasFactory;

    protected $fillable = [
        'FullName',  // Adjusted column name
        'Email',
        'PhoneNumber',
        'Portfolio',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'PhotographerID');
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(Availability::class, 'PhotographerID')->orderBy('Date', 'asc')->orderBy('StartTime', 'asc');
    }
}