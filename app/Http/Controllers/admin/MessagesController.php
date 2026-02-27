<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    /**
     * عرض صفحة الرسائل
     */
    public function index()
    {
        return view('admin.messages.index');
    }
}
