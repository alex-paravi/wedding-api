<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Включаем авторизацию для этого запроса
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'user_id' => 'required|exists:users,id',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Пожалуйста, укажите название или номер стола.',
            'name.string' => 'Название стола должно быть строкой.',
            'name.max' => 'Название стола не должно превышать 255 символов.',
            'capacity.required' => 'Укажите вместимость стола.',
            'capacity.integer' => 'Вместимость стола должна быть целым числом.',
            'capacity.min' => 'За столом должно быть как минимум 1 место.',
            'user_id.required' => 'Необходимо указать ID создателя стола.',
            'user_id.exists' => 'Указанный пользователь (создатель) не найден в системе.',
        ];
    }
}
