<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use getID3;

class LessonController extends Controller
{
    /**
     * عرض جميع الدروس
     */
    public function index()
    {
        $categories = Category::query()->active()->get();
        $lessons    = Lesson::all();
        $courses    = Course::all();
        $sections   = Section::all();
        return view('profile.teachers.coursedetails', compact('lessons', 'categories', 'courses', 'sections'));
    }

    /**
     * عرض فورم إنشاء درس جديد
     */
    public function create(Request $request)
    {
        $categories = Category::query()->active()->get();
        $lesson     = new Lesson();
        $courses    = Course::all();
        $sections = [];
        if ($request->has('course_id')) {
            $sections = Section::where('course_id', $request->course_id)->get();
        }
        return view('profile.teachers.coursedetails', compact('categories', 'lesson', 'courses', 'sections'));
    }

    /**
     * تخزين درس جديد
     */

    public function store(StoreLessonRequest $request)
    {
        // التحقق من البيانات
        $data = $request->validated();
        if ($request->has('section_id')) {
            $data['section_id'] = $request->section_id;
        }
        // إنشاء slug تلقائي إذا لم يُرسل
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $originalSlug = $data['slug'];
        $counter = 1;

        // تأكد أن slug فريد داخل نفس الكورس
        while (Lesson::where('course_id', $data['course_id'])
            ->where('slug', $data['slug'])
            ->exists()
        ) {
            $data['slug'] = $originalSlug . '-' . $counter++;
        }


        // رفع الفيديو إلى مجلد lessons_videos داخل storage/public
        if ($request->hasFile('video_path')) {
            $file = $request->file('video_path');
            $path = $file->store('lessons_videos', 'public');
            $data['video_path'] = $path;

            // استخراج مدة الفيديو
            $getID3 = new getID3;
            $fileInfo = $getID3->analyze(storage_path('app/public/' . $path));
            $data['duration_sec'] = isset($fileInfo['playtime_seconds'])
                ? round($fileInfo['playtime_seconds'])
                : null;
        }

        // رفع ملف مرفق (مثل PDF أو ZIP)
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $path = $file->store('lesson_files', 'public');
            $data['file_path'] = $path;
        }

        // حفظ الدرس
        Lesson::create($data);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()
            ->route('profile.courses.show', $request->course_id)
            ->with('toast', [
                'type' => 'success',
                'message' => 'تمت إضافة الدرس بنجاح ✅'
            ]);
    }


    /**
     * عرض تفاصيل درس واحد
     */
    public function show($id)
    {
        $lesson = Lesson::with('section.course')->findOrFail($id);
        return view('lessons.show', compact('lesson'));
    }


    /**
     * عرض فورم تعديل الدرس
     */
    public function edit(Lesson $lesson)
    {
        $categories = Category::query()->active()->get();
        $courses    = Course::all();
        $sections = Section::where('course_id', $lesson->course_id)->get();

        return view('profile.teachers.coursedetails', compact('lesson', 'categories', 'courses', 'sections'));
    }

    /**
     * تحديث بيانات الدرس
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $data = $request->validated();
        if ($request->has('section_id')) {
            $data['section_id'] = $request->section_id;
        }

        // تحديث الفيديو لو تم رفعه من جديد
        if ($request->hasFile('video_path')) {
            $file = $request->file('video_path');
            $path = $file->store('', 'google');
            $data['video_path'] = $path;
        }

        $lesson->update($data);

        return redirect()
            ->route('lessons.show', $lesson->course_id)
            ->with('toast', [
                'type' => 'success',
                'message' => 'تم تحديث الدرس بنجاح'
            ]);
    }

    /**
     * حذف الدرس
     */
    public function destroy(Lesson $lesson)
    {
        $courseId = $lesson->course_id;
        $lesson->delete();

        return redirect()
            ->route('profile.courses.show', $courseId)
            ->with('toast', [
                'type' => 'success',
                'message' => 'تم حذف الدرس بنجاح'
            ]);
    }
}
