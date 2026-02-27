<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // اسمح للمستخدمين (حسب ما عامل Middleware)
    }

    public function rules(): array
    {
        return [
            'title'         => 'required|string|max:255',
            'slug'          => [
                'required',
                'string',
                'max:255',
                // تجاهل الكورس الحالي عند التحقق من الـ unique
                Rule::unique('courses', 'slug')->ignore($this->course),
            ],
            'category_id'   => 'required|exists:categories,id',
            'teacher_id'    => 'required|exists:users,id',
            'summary'       => 'nullable|string',
            'level'         => 'required|in:beginner,intermediate,advanced',
            'language'      => 'required|string|max:50',
            'price'         => 'required|numeric|min:0',
            'sale_price'    => 'nullable|numeric|min:0|lt:price',
            'currency'      => 'required|string|size:3',
            'is_published'  => 'boolean',
            'cover'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10000',
            'intro_video'   => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg|max:10240',
            'total_minutes' => 'nullable|integer|min:1',
            'published_at'  => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'عنوان الكورس مطلوب.',
            'slug.required'        => 'الـ slug مطلوب.',
            'slug.unique'          => 'هذا الـ slug مستخدم من قبل.',
            'category_id.required' => 'اختر تصنيف للكورس.',
            'teacher_id.required'  => 'اختر مدرس للكورس.',
            'price.required'       => 'سعر الكورس مطلوب.',
            'sale_price.lt'        => 'سعر الخصم يجب أن يكون أقل من السعر الأصلي.',
        ];
    }
}
