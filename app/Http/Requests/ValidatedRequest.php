<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidatedRequest extends FormRequest
{
    /**
     * Handle failed validation.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // If validation fails, the errors are automatically returned as JSON response
        throw new \Illuminate\Validation\ValidationException($validator, response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
