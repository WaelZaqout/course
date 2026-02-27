<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'slug',
        'description',
        'sort_order',
        'is_active',
        'icon',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function scopeSearch($query, ?string $term)
    {
        $term = trim((string) $term);
        if ($term === '') {
            return $query;
        }

        $like = "%{$term}%";

        return $query->where(function ($qq) use ($like) {
            $qq->where('name', 'like', $like)
                ->orWhere('slug', 'like', $like)
                ->orWhere('description', 'like', $like);
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderByDesc('id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
