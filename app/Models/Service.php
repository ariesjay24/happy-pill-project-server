<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'Name',
        'Description',
        'Price',
        'isAddOn',  // Include the 'isAddOn' field
    ];

    protected $primaryKey = 'ServiceID';

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'ServiceID', 'ServiceID')->orderBy('BookingDate', 'asc')->orderBy('BookingTime', 'asc');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'ServiceID', 'ServiceID')->orderBy('Rating', 'desc');
    }
}
