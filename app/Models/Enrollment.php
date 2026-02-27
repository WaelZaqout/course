<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'access_type',
        'status',
        'starts_at',
        'ends_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * الدروس التابعة للكورس المشترك فيه (عبر الجدول الوسيط courses)
     */
    public function lessons()
    {
        return $this->hasManyThrough(
            Lesson::class,
            Course::class,
            'id',           // مفتاح الجدول الوسيط (courses) الذي يشير إليه enrollment
            'course_id',    // مفتاح lessons الذي يشير إلى courses
            'course_id',    // مفتاح enrollment المحلي
            'id'
        );
    }
}
