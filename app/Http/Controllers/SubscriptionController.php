<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * اشتراك المعلم في خطة (شهري)
     */
    public function checkout(Request $request, $planId)
    {
        $plan = Plan::findOrFail($planId);
        $user = $request->user();

        // ضمان وجود Stripe Customer
        if (! $user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }

        // إنشاء الاشتراك الشهري
        return $user->newSubscription('default', $plan->stripe_price_id)
            ->checkout([
                'success_url' => route('subscribe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'  => route('plans.index'),
            ]);
    }

    /**
     * شراء كورس (مرة واحدة)
     */
    public function checkoutCourse(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);
        $user = $request->user();

        if (! $user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }

        // عملية شراء لمرة واحدة (checkoutCharge)
        return $user->checkoutCharge(
            intval($course->price * 100), // Stripe يتعامل بالـ "هللات/سنتات"
            $course->title,
            1,
            [
                'success_url' => route('subscribe.courses', $course->id) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'  => route('profile.courses.show', $course->id),
            ]
        );
    }

    /**
     * نجاح اشتراك الخطة (معلم/طالب)
     */
    public function success(Request $request)
    {
        $user = Auth::user();

        // الحصول على الاشتراك الجديد
        $subscription = $user->subscription('default');

        if ($subscription && $subscription->active()) {
            // التحقق من نوع الخطة (معلم أو طالب)
            $plan = Plan::where('stripe_price_id', $subscription->stripe_price)->first();

            if ($plan && $plan->audience === 'teacher') {
                // تحديث المستخدم ليصبح معلم
                $user->role = 'teacher';
                $user->save();
            }
        }

        return view('subscriptions.success');
    }

    /**
     * نجاح شراء كورس (طالب)
     */
    public function courseSuccess($courseId)
    {
        $course = Course::findOrFail($courseId);

        // تسجيل الطالب بالكورس تلقائيًا بعد الدفع
        Auth::user()->enrollments()->firstOrCreate([
            'course_id' => $course->id,
        ]);

        return view('subscriptions.courses', compact('course'));
    }
}
