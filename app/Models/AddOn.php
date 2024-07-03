<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAddOn extends Model
{
    use HasFactory;

    protected $fillable = [
        'Name',
        'Description',
        'Price',
        'isAddOn',
    ];
}

class AddOn extends Model
{
    use HasFactory;

    protected $table = 'add_ons';

    protected $fillable = [
        'Name',
        'Price',
    ];
}
