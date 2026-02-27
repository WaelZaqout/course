<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

abstract class Controller
{
    /**
     * Override failed validation to preserve input and show toast message
     */
    protected function failedValidation(Validator $validator) {
        throw new ValidationException($validator, back()
            ->withInput()
            ->with('toast', [
                'type'    => 'error',
                'message' => 'يرجى التحقق من البيانات المدخلة'
            ]));
    }
}
