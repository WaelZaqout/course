<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $fillable = [
        'user_id',
        'lesson_id',
        'status',
        'last_watched_sec',
        'completed_at',
    ];

    protected $casts = [
        'last_watched_sec' => 'integer',
        'completed_at'     => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
