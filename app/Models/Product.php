<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'hsn_code',
        'grade',
        'price',
        'tax_id',
        'image',
        'status'
    ];

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
}
