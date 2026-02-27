<?php

namespace App\Models;

use App\Models\Progress;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{

    protected $fillable = [
        'course_id',
        'title',
        'slug',
        'sort_order',
        'section_id',  // ✅
        'duration_sec',
        'free_preview',
        'content_type',
        'video_path',
        'file_path',
        'body',
        'live_starts_at'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function progress()
    {
        return $this->hasMany(Progress::class);
    }
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    protected $casts = [
        'free_preview'   => 'boolean',
        'live_starts_at' => 'datetime',
        'duration_sec'   => 'integer',
    ];
    // في موديل Lesson مثلاً
    public function getDurationFormattedAttribute()
    {
        if (!$this->duration_sec) {
            return 'غير محددة';
        }

        $hours = floor($this->duration_sec / 3600);
        $minutes = floor(($this->duration_sec % 3600) / 60);

        if ($hours > 0) {
            $hourLabel = $hours === 1 ? 'ساعة' : ($hours === 2 ? 'ساعتين' : $hours . ' ساعات');
            return $hourLabel . ($minutes > 0 ? " و $minutes دقيقة" : '');
        }

        return $minutes . ' دقيقة';
    }
}
