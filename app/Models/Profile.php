<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Profile extends Model
{
    protected $fillable = [
        'headline',
        'user_id',
        'bio',
        'social',
    ];

    protected $casts = [
        'social' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
