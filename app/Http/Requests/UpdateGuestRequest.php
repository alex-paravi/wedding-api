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
            'name' => [
                'sometimes',
                'string',
                'min:2',
                'max:100',
                'regex:/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u'
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'side' => ['sometimes', 'string', 'in:groom,bride'],
            'category' => ['sometimes', 'string', 'in:friend,relative,colleague'],
            'status' => ['sometimes', 'string', 'in:confirmed,pending,declined'],
            'table_id' => ['sometimes', 'nullable', 'exists:tables,id'],
        ];
    }
    public function messages()
    {
        return [
            'name.regex' => 'Имя может содержать только буквы, пробелы и дефисы.',
            'side.in' => 'Сторона должна быть строго: groom (жених) или bride (невеста).',
            'category.in' => 'Категория должна быть: friend, relative или colleague.',
            'status.in' => 'Статус должен быть: confirmed, pending или declined.',
            'table_id.exists' => 'Выбранного стола не существует в системе.',
        ];
    }
}
