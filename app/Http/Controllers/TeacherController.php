<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $categories = Category::query()->active()->get();
        $teachers   = User::where('role', 'teacher')->get();

        // عرض الكورسات الخاصة بالمعلم الحالي فقط
        $courses = Course::withCount('lessons')
            ->where('teacher_id', auth()->id())
            ->get();

        return view('profile.teachers.courses', compact('courses', 'teachers', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        if (!$user->hasActivePlan('teacher')) {
            return redirect()->route('profile.index')
                ->with('error', 'انتهت صلاحيات المعلم، يرجى تجديد الاشتراك.');
        }

        $teachers   = User::where('role', 'teacher')->get();
        $categories = Category::all();
        $courses    = []; // الكورسات سيتم جلبها من index

        return view('profile.teachers.courses', compact('categories', 'teachers', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $user = auth()->user();
        if (!$user->hasActivePlan('teacher')) {
            return redirect()->route('profile.index')
                ->with('error', 'انتهت صلاحيات المعلم، يرجى تجديد الاشتراك.');
        }


        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('courses', 'public');
        }

        if ($request->hasFile('intro_video')) {
            $data['intro_video'] = $request->file('intro_video')->store('courses/videos', 'public');
        }

        $data['published_at'] = now();
        $data['teacher_id']   = $user->id;

        Course::create($data);

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
        if ($course->teacher_id != auth()->id()) {
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
        if ($course->teacher_id != auth()->id()) {
            abort(403, 'ليس لديك صلاحية تعديل هذا الكورس.');
        }

        $teachers   = User::where('role', 'teacher')->get();
        $categories = Category::all();

        return view('profile.teachers.courses', compact('course', 'categories', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        if ($course->teacher_id != auth()->id()) {
            abort(403, 'ليس لديك صلاحية تعديل هذا الكورس.');
        }

        $course->update($request->validated());

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
        if ($course->teacher_id != auth()->id()) {
            abort(403, 'ليس لديك صلاحية حذف هذا الكورس.');
        }

        $course->delete();

        return redirect()->route('profile.courses.index')->with('toast', [
            'type'    => 'success',
            'message' => 'تم حذف الكورس بنجاح'
        ]);
    }
}
