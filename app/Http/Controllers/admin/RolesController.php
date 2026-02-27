<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    /**
     * عرض صفحة إدارة الصلاحيات
     */
    public function index()
    {
        return view('admin.roles.index');
    }
}
