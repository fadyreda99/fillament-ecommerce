<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'file_path',
        'file_name',
        'sort_order',
    ];

    public function mediable()
    {
        return $this->morphTo();
    }
}
