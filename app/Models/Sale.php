<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'date',
        'vendor_id',
        'vendor_name',
        'vendor_mobile',
        'customer_id',
        'customer_name',
        'customer_mobile',
        'eway_bill_number',
        'vehicle_id',
        'vehicle_number',
        'driver_name',
        'driver_phone',
        'vehicle_rate',
        'image',
        'r_weight',
        'k_weight',
        'product_id',
        'p_price',
        's_price',
        'tax_id',
        'tax_name',
        'tax_rate',
        'remark',
        'p_total',
        's_total',
        'v_total'
    ];
}
