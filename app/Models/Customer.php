<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'address',
        'gender',
        'dob',
        'image',
        'gst_number',
        'gst_code',
        'status',
        'city',
        'state',
        'country',
        'zipcode'
    ];

    use SoftDeletes;
}
