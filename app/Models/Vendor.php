<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Vendor extends Model
{
    protected $table = 'vendors';
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'gender',
        'dob',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'image',
        'status',
        'gst_number',
        'gst_code',
    ];

}
