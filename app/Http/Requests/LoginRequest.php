<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class LoginRequest extends ValidatedRequest
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
        Log::info('Validating rules:', $this->all());
        return [
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:8',
        ];
    }


    // protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    // {
    //     Log::error('Validation failed:', $validator->errors()->toArray());
    //     parent::failedValidation($validator);
    // }
}
