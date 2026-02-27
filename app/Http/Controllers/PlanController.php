<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{

    public function index(Request $request)
    {

        $user = auth()->user();
        $aud  = $request->get('aud') ?: ($user?->hasRole('teacher') ? 'teacher' : 'student');
        $categories = Category::query()->active()->get();

        $teacherPlans = Plan::where('audience', 'teacher')->where('is_active', true)->orderBy('price')->get();
        $studentPlans = Plan::where('audience', 'student')->where('is_active', true)->orderBy('price')->get();
        $courses = Course::withCount('lessons')->get();

        return view('index', compact('aud', 'teacherPlans', 'studentPlans', 'categories', 'courses'));
    }
}
