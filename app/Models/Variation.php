<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    protected $guarded = [];

    public function values()
    {
        return $this->hasMany(VariationValue::class);
    }
}
