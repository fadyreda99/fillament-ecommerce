<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($category) {
            if ($category->isDirty('name')) {
                $slug = Str::slug($category->name);

                // تأكد إنه unique
                $count = static::where('slug', 'like', "$slug%")
                    ->where('id', '!=', $category->id)
                    ->count();

                $category->slug = $count ? "{$slug}-{$count}" : $slug;
            }
        });
    }

    // Self-referential relationship for parent category
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Self-referential relationship for child categories
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
