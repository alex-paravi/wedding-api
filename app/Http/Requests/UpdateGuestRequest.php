<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class UpdateGuestRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'is_confirmed' =>
            [
                'required',
                'boolean',
            ],
        ];
    }
    public function messages()
    {
        return [
            'is_confirmed.required' => 'Статус подтверждения обязателен для заполнения.',
            'is_confirmed.boolean' => 'Статус подтверждения должен быть логического типа (true/false или 1/0).',
        ];
    }
}
