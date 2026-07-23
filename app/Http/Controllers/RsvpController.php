<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RsvpController extends Controller
{
    /**
     * Принять ответ на приглашение от гостя по токену.
     */
    public function __invoke(Request $request, string $token): JsonResponse
    {
        // 1. Ищем гостя по токену из URL (если не найден — Laravel вернет 404)
        $guest = Guest::where('invitation_token', $token)->firstOrFail();

        // 2. Валидируем входящие данные от гостя
        $validated = $request->validate([
            'status' => 'required|in:confirmed,declined',
            'dietary_preferences' => 'nullable|string|max:255',
        ]);

        // 3. Обновляем статус и пожелания гостя в базе
        $guest->update([
            'status' => $validated['status'],
            'dietary_preferences' => $validated['dietary_preferences'] ?? $guest->dietary_preferences,
        ]);

        // 4. Возвращаем вежливый JSON-ответ
        return response()->json([
            'success' => true,
            'message' => 'Спасибо за ваш ответ!',
            'data' => [
                'guest_name' => $guest->name,
                'status'     => $guest->status,
            ]
        ]);
    }
}
