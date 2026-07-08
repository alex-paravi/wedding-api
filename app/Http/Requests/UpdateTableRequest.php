<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'capacity' => 'sometimes|integer|min:1',
            'user_id' => 'sometimes|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Название стола должно быть строкой.',
            'name.max' => 'Название стола не должно превышать 255 символов.',
            'capacity.integer' => 'Вместимость стола должна быть целым числом.',
            'capacity.min' => 'За столом должно быть как минимум 1 место.',
            'user_id.exists' => 'Указанный пользователь не найден в системе.',
        ];
    }
}
