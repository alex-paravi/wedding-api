<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreGuestRequest extends FormRequest
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
            'name' =>
            [
                'required',
                'string',
                'min:2',
                'max:100',
                'regex:/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u',
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'name.regex' => 'Имя может содержать только буквы, пробелы и дефисы.'
        ];
    }
}
