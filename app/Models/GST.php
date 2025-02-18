<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GST extends Model
{
    protected $fillable = ['name', 'gst_code', 'status'];
}
