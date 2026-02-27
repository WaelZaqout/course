<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminTeacherController extends Controller
{
    /**
     * عرض قائمة الأساتذة مع بحث وباجينيشن
     */
    public function index(Request $request)
    {
        $q = $request->query('q', '');

        $teachers = User::query()
            ->where('role', 'teacher')
            ->when($q !== '', function ($query) use ($q) {
                $like = "%{$q}%";
                $query->where(function ($qq) use ($like) {
                    $qq->where('name', 'like', $like)
                        ->orWhere('email', 'like', $like)
                        ->orWhere('phone', 'like', $like);
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'rows'       => view('admin.teachers._rows', compact('teachers'))->render(),
                'pagination' => $teachers->links()->toHtml(),
            ]);
        }

        return view('admin.teachers.index', compact('teachers', 'q'));
    }


    /**
     * عرض بيانات أستاذ واحد
     */
    public function show(User $teacher)
    {
        return view('admin.teachers.show', compact('teacher'));
    }
}
