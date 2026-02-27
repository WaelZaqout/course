<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'teacher_id',
        'summary',
        'level',
        'language',
        'price',
        'sale_price',
        'currency',
        'is_published',
        'cover',
        'intro_video',
        'total_minutes',
        'published_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id')
            ->withTimestamps();
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function enrollment()
    {
        return $this->hasMany(Enrollment::class);
    }
    public static function forTeacher($teacherId)
    {
        return self::withCount('lessons')
            ->where('teacher_id', $teacherId)
            ->get();
    }

}
