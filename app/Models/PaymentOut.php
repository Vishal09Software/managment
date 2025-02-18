<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PaymentOut extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'type',
        'vendor_id',
        'vehicle_id',
        'amount',
        'payment_method',
        'payment_date',
        'reference_no',
        'remarks',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
