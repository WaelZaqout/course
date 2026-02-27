<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Traits\HandlesCourseMedia;

class CourseController extends Controller
{
    use HandlesCourseMedia;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query()->active()->get();
        $teachers   = User::where('role', 'teacher')->get();
        $courses    = Course::forTeacher(Auth::id());

        return view('profile.teachers.courses', compact('courses', 'teachers', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        // if (!$user->hasActivePlan('teacher')) {
        //     return redirect()->route('profile.index')
        //         ->with('error', __('messages.teacher_plan_expired'));
        // }

        $teachers   = User::teachers();
        $categories = Category::query()->active()->get();
        $courses    = [];

        return view('profile.teachers.courses', compact('categories', 'teachers', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $user = Auth::user();
        // if (!$user->hasActivePlan('teacher')) {
        //     return redirect()->route('profile.index')
        //         ->with('error', 'انتهت صلاحيات المعلم، يرجى تجديد الاشتراك.');
        // }

        $data = $request->validated();

        $slug = Str::slug($data['title']);
        $count = Course::where('slug', 'like', $slug . '%')->count();

        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $data['slug'] = $slug;


        $data['published_at'] = now();
        $data['teacher_id']   = $user->id;

        // إنشاء الكورس
        $course = Course::create($data);

        // رفع الميديا وتحديثها
        $mediaData = $this->handleMediaUpload($request, $course);
        if (!empty($mediaData)) {
            $course->update($mediaData);
        }

        return redirect()->route('profile.courses.index')->with('toast', [
            'type'    => 'success',
            'message' => 'تمت إضافة الكورس بنجاح'
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function show(Course $course)
    {
        // التأكد أن الكورس يخص المعلم الحالي
        if ($course->teacher_id != Auth::id()) {
            abort(403, 'ليس لديك صلاحية مشاهدة هذا الكورس.');
        }

        $categories = Category::query()->active()->get();
        $teachers   = User::where('role', 'teacher')->get();

        return view('profile.teachers.coursedetails', compact('course', 'categories', 'teachers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        if ($course->teacher_id != Auth::id()) {
            abort(403, 'ليس لديك صلاحية تعديل هذا الكورس.');
        }

        $teachers   = User::where('role', 'teacher')->get();
        $categories = Category::query()->active()->get();

        return view('profile.teachers.courses', compact('course', 'categories', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        if ($course->teacher_id != Auth::id()) {
            abort(403, 'ليس لديك صلاحية تعديل هذا الكورس.');
        }

        $data = $request->validated();

        // تحديث بيانات الكورس
        $course->update($data);

        // تحديث الملفات لو تم رفع جديدة
        $mediaData = $this->handleMediaUpload($request, $course);
        if (!empty($mediaData)) {
            $course->update($mediaData);
        }

        return redirect()->route('profile.courses.index')->with('toast', [
            'type'    => 'success',
            'message' => 'تم تحديث الكورس بنجاح'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        if ($course->teacher_id != Auth::id()) {
            abort(403, 'ليس لديك صلاحية حذف هذا الكورس.');
        }

        try {
            // حذف الملفات المرتبطة
            $this->deleteMedia($course);

            $course->delete();

            return redirect()->route('profile.courses.index')->with('toast', [
                'type'    => 'success',
                'message' => 'تم حذف الكورس بنجاح'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('profile.courses.index')->with('toast', [
                'type'    => 'error',
                'message' => 'حدث خطأ أثناء حذف الكورس'
            ]);
        }
    }
    /**
     * عرض الكورسات المتاحة للطلاب
     */
    // عرض قائمة الكورسات للطالب
    public function studentIndex()
    {
        $user = Auth::user();
        $courses = $user->publishedCourses()->get();

        return view('profile.students.courses', compact('courses'));
    }

    // عرض تفاصيل كورس واحد للطالب
    public function studentShow(Course $course)
    {
        $user = Auth::user();
        if (!$course->published_at) {
            abort(404, 'الكورس غير متاح حالياً');
        }

        if (!$user->isSubscribedToCourse($course->id)) {
            abort(403, 'ليس لديك صلاحية مشاهدة هذا الكورس. يرجى الاشتراك أولاً.');
        }

        $course->load('lessons', 'sections', 'teacher', 'category');

        return view('profile.students.coursedetails', compact('course'));
    }
}
