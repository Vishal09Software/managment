<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentIn extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'customer_id',
        'reference_no',
        'amount',
        'payment_method',
        'payment_date',
        'remarks',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
