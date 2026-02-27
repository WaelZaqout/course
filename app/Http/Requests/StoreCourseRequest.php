<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'         => 'required|string|max:255',
            'slug'          => 'nullable|string|max:255|unique:courses,slug',
            'category_id'   => 'required|exists:categories,id',
            'teacher_id'    => 'required|exists:users,id',
            'summary'       => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'sale_price'    => 'nullable|numeric|min:0|lt:price',
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

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->any()) {
                session()->flash('toast', [
                    'type' => 'error',
                    'message' => 'يرجى التحقق من البيانات المدخلة'
                ]);
            }
        });
    }
}
