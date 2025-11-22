<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariationValue extends Model
{
    protected $guarded = [];
    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }
}
