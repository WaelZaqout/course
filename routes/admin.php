<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Admincontroller;
use App\Http\Controllers\Admin\AdminTeacherController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\CoursesController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\StudentsController;
use App\Http\Controllers\Admin\TeachersController;

Route::middleware(['auth', 'role:admin'])->group(function () {

    // يُفضل أن تكون الصفحة الرئيسية للأدمن هي /admin/dashboard
    Route::get('/', [Admincontroller::class, 'index'])->name('index');

    // إدارة المستخدمين (طلاب/معلمين) - إدارية
    Route::get('/students',  [StudentsController::class, 'index'])->name('students.index');
    Route::get('/students/{student}', [StudentsController::class, 'show'])->name('students.show');

    Route::get('/teachers',  [AdminTeacherController::class,  'index'])->name('teachers.index');
    Route::get('/teachers/{teacher}', [AdminTeacherController::class, 'show'])->name('teachers.show');

    // إدارة الدورات/التصنيفات/الرسائل/الإعدادات - إدارية
    // Route::get('/courses',   [CoursesController::class,   'index'])->name('courses.index');
    Route::get('/roles',     [RolesController::class,     'index'])->name('roles.index');
    Route::get('/settings',  [SettingsController::class,  'index'])->name('settings.index');
    Route::get('/messages',  [MessagesController::class,  'index'])->name('messages.index');

    // التصنيفات
    Route::get('categories',               [CategoryController::class, 'index'])->name('categories.index');
    Route::post('categories',              [CategoryController::class, 'store'])->name('categories.store');
    Route::put('categories/{category}',    [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::patch('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])
        ->name('categories.toggle-active');

    Route::middleware('permission:عرض المستخدمين')->group(function () {
        Route::resource('users', UserController::class);
    });
});
require __DIR__ . '/auth.php';
