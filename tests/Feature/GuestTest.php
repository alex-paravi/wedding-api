<?php

namespace Tests\Feature;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Guest;

class GuestTest extends TestCase
{
    // ВОТ ОН! Говорим Laravel обновлять базу перед тестами
    use RefreshDatabase;
    /**
     * Проверяем, что неавторизованный пользователь получает 401 ошибку.
     */
    public function test_unauthenticated_user_cannot_get_guests_list(): void
    {
        // 1. Делаем GET-запрос на роут списка гостей
        $response = $this->getJson('/api/guests');

        // 2. Проверяем, что сервер вернул статус 401 (Unauthorized)
        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_create_guest(): void
    {
        // 1. Создаем фейкового пользователя в нашей временной базе данных.
        // Метод factory() сам сгенерирует ему имя, почту и пароль.
        $user = User::factory()->create();

        // 2. Данные ковбоя, которые мы будем отправлять в POST-запросе
        $guestData = [
            'name' => 'Иван Иванов',
            'phone' => '+79991112233',
            'side' => 'groom',
            'category' => 'friend',
            'status' => 'pending',
        ];

        // 3. Делаем POST-запрос, но с помощью метода actingAs() 
        // мы говорим Laravel: "Симулируй, что этот запрос отправляет наш $user"
        $response = $this->actingAs($user)
            ->postJson('/api/guests', $guestData);

        // 4. Проверяем, что сервер ответил статусом 201 Created
        $response->assertStatus(201);

        // 5. Проверяем, что в JSON-ответе вернулись данные нашего созданного гостя
        $response->assertJsonFragment(['name' => 'Иван Иванов']);

        // 6. ФИНАЛОЧКА: Проверяем, что в тестовой базе данных РЕАЛЬНО появилась эта запись
        $this->assertDatabaseHas('guests', [
            'name' => 'Иван Иванов',
            'user_id' => $user->id // Проверяем, что контроллер правильно привязал ID юзера!
        ]);
    }

    /**
     * Проверяем, что юзер не может обновить чужого гостя.
     */
    /**
     * Проверяем, что юзер не может обновить чужого гостя.
     */
    public function test_user_cannot_update_someone_elses_guest(): void
    {
        // 1. Создаём двух разных пользователей
        $userOwner = User::factory()->create();
        $userStranger = User::factory()->create();

        // 2. Создаём гостя, который принадлежит первому пользователю (userOwner)
        $guest = Guest::factory()->create([
            'user_id' => $userOwner->id,
        ]);

        // 3. Данные для обновления
        $updateData = [
            'name' => 'Злобный Хакер',
        ];

        // 4. Пытаемся сделать PATCH-запрос от имени ВТОРОГО пользователя (userStranger)
        $response = $this->actingAs($userStranger)
            ->patchJson("/api/guests/{$guest->id}", $updateData);

        // 5. Утверждаем, что сервер вернул статус 403 (Forbidden) — доступ запрещен!
        $response->assertStatus(403);

        // 6. Проверяем в базе, что имя гостя НЕ изменилось
        $this->assertDatabaseHas('guests', [
            'id' => $guest->id,
            'name' => $guest->name, // осталось старым
        ]);
    }
}
