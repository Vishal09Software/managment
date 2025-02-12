<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    protected $table = 'vehicles';
    use SoftDeletes;

    protected $fillable = [
        'vehicle_name',
        'vehicle_number',
        'owner_name',
        'owner_phone',
        'owner_address',
        'driver_name',
        'driver_phone',
    ];

}
