<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class Admincontroller extends Controller
{
    /**
     * عرض لوحة التحكم الرئيسية
     */
    public function index()
    {
        return view('admin.master');
    }
}
