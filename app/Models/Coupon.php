<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = [];

    protected $casts = [
        'starts_at' => 'date',
        'expires_at' => 'date',
        'active' => 'boolean'
    ];
}
