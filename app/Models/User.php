<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Communication;
use App\Models\Photographer;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'FirstName',
        'LastName',
        'Email',
        'PhoneNumber',
        'Password',
        'Address',
        'Role',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    protected $primaryKey = 'UserID';

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'UserID')->orderBy('BookingDate', 'asc')->orderBy('BookingTime', 'asc');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'UserID')->orderBy('ReviewDate', 'desc');
    }

    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class, 'UserID')->orderBy('TimeStamp', 'desc');
    }

    public function photographer(): HasOne
    {
        return $this->hasOne(Photographer::class, 'UserID');
    }
}
