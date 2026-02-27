<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id'
        ]);

        Section::create([
            'title'     => $request->title,
            'course_id' => $request->course_id,
        ]);

        return back()->with('success', 'تمت إضافة السكشن بنجاح ✅');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return back()->with('success', 'تم حذف السكشن بنجاح ✅');
    }
}

