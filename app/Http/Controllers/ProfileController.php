<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // عرض تبويب الحساب
    public function account()
    {
        return view('profile.partials.account');
    }

    // عرض تبويب الأمان
    public function security()
    {
        return view('profile.partials.security');
    }

    // عرض تبويب الإشعارات
    public function notifications()
    {
        return view('profile.partials.notifications');
    }

    // عرض تبويب الخصوصية
    public function privacy()
    {
        return view('profile.partials.privacy');
    }

    // تحديث بيانات الحساب
    public function updateAccount(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'   => 'required|string|max:255',
            'phone'  => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->country = $request->country;

        if ($request->hasFile('avatar')) {
            // حذف الصورة القديمة
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // رفع الصورة الجديدة
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return response()->json([
            'message' => 'تم تحديث الحساب بنجاح',
            'avatar'  => $user->avatar ? asset('storage/' . $user->avatar) : null
        ]);
    }

    // التحقق من كلمة المرور الحالية
    public function checkPassword(Request $request)
    {
        $valid = Hash::check($request->password, auth()->user()->password);
        return response()->json(['valid' => $valid]);
    }

    // تحديث كلمة المرور (بعد التحقق من الحالية)
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'تم تغيير كلمة المرور بنجاح']);
    }

    // تحديث إعدادات الخصوصية
    public function updatePrivacy(Request $request)
    {
        $user = auth()->user();
        $user->profile_public = $request->has('profile_public');
        $user->show_progress = $request->has('show_progress');
        $user->show_certificates = $request->has('show_certificates');
        $user->show_achievements = $request->has('show_achievements');
        $user->save();

        return response()->json(['message' => 'تم تحديث الخصوصية بنجاح']);
    }

    // حذف الحساب مع التحقق من كلمة المرور
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = auth()->user();

        // حذف الصورة القديمة إن وجدت
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'تم حذف الحساب بنجاح']);
    }
}
