<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            if ($product->isDirty('name')) {
                $slug = Str::slug($product->name);

                // تأكد إنه unique
                $count = static::where('slug', 'like', "$slug%")
                    ->where('id', '!=', $product->id)
                    ->count();

                $product->slug = $count ? "{$slug}-{$count}" : $slug;
            }
        });
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable')->orderBy('sort_order');
    }
}
