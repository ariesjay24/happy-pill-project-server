<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'BookingID';

    protected $fillable = [
        'UserID',
        'ServiceID',
        'BookingDate',
        'BookingTime',
        'Location',
        'AddOns',
        'Price',
        'Status',
        'payment_status', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'ServiceID', 'ServiceID');
    }
}
