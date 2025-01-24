<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StackInfoRequest extends ValidatedRequest
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
            'technology_name' => 'required|string|max:255|min:3',
            'proficiency' => 'required|in:Iesācējs,Lietotājs,Labi Pārzinu,Eksperts',
        ];
    }
}
