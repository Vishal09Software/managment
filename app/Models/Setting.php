<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'business_name',
        'business_phone',
        'business_email',
        'business_address',
        'gst_number',
        'business_logo',
        'bank_name',
        'account_no',
        'ifsc_code',
        'account_holder_name',
        'gst_code',
    ];
}
