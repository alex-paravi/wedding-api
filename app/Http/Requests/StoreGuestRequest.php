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
     */
    public function rules(): array
    {
        // ЗДЕСЬ ДОЛЖНЫ БЫТЬ ТОЛЬКО ПРАВИЛА ВАЛИДАЦИИ!
        return [
            'name' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u'],
            'phone' => ['nullable', 'string', 'max:20'],
            'side' => ['required', 'string', 'in:groom,bride'],
            'category' => ['required', 'string', 'in:friend,relative,colleague'],
            'status' => ['required', 'string', 'in:confirmed,pending,declined'],
            'table_number' => ['nullable', 'integer'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        // А ЗДЕСЬ — КАСТОМНЫЕ ТЕКСТЫ ОШИБОК ДЛЯ РУССКОЯЗЫЧНЫХ ПОЛЬЗОВАТЕЛЕЙ
        return [
            // Ошибки для имени
            'name.required' => 'Имя гостя обязательно для заполнения.',
            'name.regex' => 'Имя может содержать только буквы, пробелы и дефисы.',

            // Ошибки обязательности (required)
            'side.required' => 'Укажите сторону: groom (жених) или bride (невеста).',
            'category.required' => 'Укажите категорию гостя (friend, relative, colleague).',
            'status.required' => 'Укажите статус присутствия гостя.',

            // Ошибки соответствия спискам (in)
            'side.in' => 'Выберите сторону: groom (жених) или bride (невеста).',
            'category.in' => 'Категория должна быть строго: friend, relative или colleague.',
            'status.in' => 'Статус должен быть одним из следующих: confirmed, pending, declined.',
        ];
    }
}
