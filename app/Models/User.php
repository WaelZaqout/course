<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, Billable;

    protected $guard_name = 'web';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'phone',
        'country',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments');
    }

    /**
     * احصل على خطة الاشتراك النشطة
     */
    public function activePlan(): ?Plan
    {
        $subscription = $this->subscription('default');
        if ($subscription && $subscription->active()) {
            return Plan::where('stripe_price_id', $subscription->stripe_price)->first();
        }
        return null;
    }

    /**
     * تحقق إذا المستخدم معلم (لديه صلاحية إنشاء كورسات)
     * يتم التحقق من دور المستخدم أو من الاشتراك النشط للمعلمين
     */
    public function isTeacher(): bool
    {
        // إذا كان دور المستخدم هو معلم
        if ($this->role === 'teacher') {
            return true;
        }

        // التحقق من الاشتراك النشط للمعلمين
        return $this->hasActivePlan('teacher');
    }

    /**
     * تحقق إذا للمستخدم اشتراك نشط
     * وإذا انتهت الاشتراك يتم سحب صلاحيات المعلم تلقائيًا
     */
    public function hasActivePlan($audience = null)
    {
        $subscription = $this->subscription('default');

        if (! $subscription) {
            return false;
        }

        $isActive = $subscription->active() || $subscription->onGracePeriod();

        if (! $isActive) {
            return false;
        }

        if ($audience) {
            $plan = Plan::where('stripe_price_id', $subscription->stripe_price)->first();
            return $plan && $plan->audience === $audience;
        }

        return true;
    }

    public function hasActiveCourseSubscription($courseId): bool
    {
        return $this->subscriptions()
            ->where('course_id', $courseId)
            ->where('stripe_status', 'active')
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
            })
            ->exists();
    }
    public static function teachers()
    {
        return self::where('role', 'teacher')->get();
    }
    public function publishedCourses()
    {
        return $this->courses()
            ->whereNotNull('published_at');
    }
      public function isSubscribedToCourse($courseId)
    {
        return $this->courses()->where('course_id', $courseId)->exists();
    }
}

