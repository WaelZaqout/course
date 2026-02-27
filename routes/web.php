<?php

use Illuminate\Support\Facades\Route;

// === Controllers (فرونت) ===
use App\Http\Controllers\LessonController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PlanController;        // الباقات
use App\Http\Controllers\CourseController;      // الكورسات
use App\Http\Controllers\ProfileController;     // البروفايل
use App\Http\Controllers\FrontController;       // صفحات عامة
use App\Http\Controllers\SubscriptionController; // الاشتراكات
use App\Http\Controllers\TeacherController;     // واجهة المعلم

// =====================
// صفحات عامة (بدون تسجيل)
// =====================



Route::get('/',              [FrontController::class, 'index'])->name('site.home');

Route::get('/courses',       [FrontController::class, 'courses'])->name('courses');

Route::get('/coursedetails', [FrontController::class, 'coursedetails'])->name('details');
Route::get('/coursedetails/{id}', [FrontController::class, 'coursedetails'])->name('coursedetails');
Route::get('/lesson', [FrontController::class, 'lesson'])->name('lessons.list'); // قائمة الدروس
Route::get('/lesson/{id}', [FrontController::class, 'lesson'])->name('lesson.show'); // مشاهدة درس محدد

// =====================
// صفحات البروفايل (محمية)
// فقط للطالب أو المدرس (الأدمن ممنوع)
// =====================
Route::middleware(['auth', 'role:student|teacher'])
    ->prefix('profile')
    ->name('profile.')
    ->group(function () {
        Route::get('/', [FrontController::class, 'profile'])->name('index');
        Route::resource('courses', CourseController::class);
        Route::resource('lesson', LessonController::class);
        Route::resource('sections', SectionController::class);
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        // صفحات الأقسام
        Route::get('/account', [ProfileController::class, 'account'])->name('account');
        Route::get('/security', [ProfileController::class, 'security'])->name('security');
        Route::get('/notifications', [ProfileController::class, 'notifications'])->name('notifications');
        Route::get('/privacy', [ProfileController::class, 'privacy'])->name('privacy');

        Route::put('/account', [ProfileController::class, 'updateAccount'])->name('settings.updateAccount');
        Route::put('/security', [ProfileController::class, 'updatePassword'])->name('settings.updatePassword');
        Route::put('/privacy', [ProfileController::class, 'updatePrivacy'])->name('settings.updatePrivacy');

        Route::post('/check-password', [ProfileController::class, 'checkPassword'])->name('check_password');
        Route::delete('/delete', [ProfileController::class, 'destroy'])->name('destroy');

        // حذف الحساب
        Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

Route::middleware(['auth', 'role:student|teacher'])

    ->prefix('student')
    ->name('student.')
    ->group(function () {
        // عرض جميع الكورسات المتاحة للطالب
        Route::get('/courses', [CourseController::class, 'studentIndex'])->name('courses.index');
        // عرض تفاصيل كورس معين
        Route::get('/courses/{course}', [CourseController::class, 'studentShow'])->name('courses.show');
    });

// =====================
// الاشتراكات
// =====================
Route::middleware('auth')->group(function () {
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');

    Route::post('/subscribe/{plan}', [SubscriptionController::class, 'checkout'])
        ->middleware('auth')
        ->name('subscribe.checkout');
    Route::post('/courses/{course}/checkout', [SubscriptionController::class, 'checkoutCourse'])
        ->name('courses.checkout')
        ->middleware('auth');

    Route::get('/subscribe/success', [SubscriptionController::class, 'success'])
        ->middleware('auth')
        ->name('subscribe.success');

    Route::get('/courses/{course}/success', [SubscriptionController::class, 'courseSuccess'])
        ->name('subscribe.courses');
});

// =====================
// صفحات خاصة تحتاج اشتراك
// =====================
Route::middleware(['auth', 'role:teacher', 'subscribed:teacher'])->group(function () {
    // Routes للمدرس التي تحتاج اشتراك
    // مثال:
    // Route::get('/teacher/courses/create', [CourseController::class, 'create'])->name('teacher.courses.create');
});

Route::middleware(['auth', 'role:student', 'subscribed:student'])->group(function () {
    // Routes للطالب التي تحتاج اشتراك
});

// =====================
// Stripe Webhook
// =====================
Route::post('/stripe/webhook', [\Laravel\Cashier\Http\Controllers\WebhookController::class, 'handleWebhook'])
    ->name('stripe.webhook')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// =====================
// مصادقة (Breeze/Fortify/UI)
// =====================

require __DIR__ . '/auth.php';
