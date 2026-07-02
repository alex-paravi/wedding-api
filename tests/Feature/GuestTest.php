<?php

namespace Tests\Feature;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

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
}
