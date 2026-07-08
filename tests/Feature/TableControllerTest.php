<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Table;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TableControllerTest extends TestCase
{
    // Этот трейт автоматически очищает базу данных (в памяти или sqlite) перед каждым тестом
    use RefreshDatabase;

    /**
     * Тест: Гость (неавторизованный пользователь) не может получить список столов.
     */
    public function test_unauthenticated_user_cannot_access_tables(): void
    {
        $response = $this->getJson('/api/tables');

        // Ждем 401 Unauthorized от Laravel Sanctum
        $response->assertStatus(401);
    }

    /**
     * Тест: Авторизованный пользователь может успешно создать стол.
     */
    public function test_authenticated_user_can_create_table(): void
    {
        // 1. Создаем фейкового пользователя
        $user = User::factory()->create();

        // 2. Генерируем данные для стола
        $tableData = [
            'name' => 'Стол №1',
            'capacity' => 8,
            'user_id' => $user->id,
        ];

        // 3. Делаем POST-запрос, принудительно авторизовав пользователя через actingAs
        $response = $this->actingAs($user)
            ->postJson('/api/tables', $tableData);

        // 4. Проверяем, что сервер ответил 201 Created
        $response->assertStatus(201);

        // 5. Проверяем структуру JSON-ответа (что она идет через наш TableResource)
        $response->assertJsonPath('data.name', 'Стол №1');
        $response->assertJsonPath('data.capacity', 8);

        // 6. Проверяем, что запись реально появилась в базе данных SQLite
        $this->assertDatabaseHas('tables', [
            'name' => 'Стол №1',
            'capacity' => 8,
        ]);
    }

    /**
     * Тест: Валидация выдает ошибку на русском языке, если не передать имя стола.
     */
    public function test_create_table_validation_fails_without_name(): void
    {
        $user = User::factory()->create();

        // Передаем пустую строку вместо имени
        $response = $this->actingAs($user)
            ->postJson('/api/tables', [
                'name' => '',
                'capacity' => 5,
                'user_id' => $user->id,
            ]);

        // Ждем статус 422 Unprocessable Content (ошибка валидации)
        $response->assertStatus(422);

        // Проверяем, что вернулось наше кастомное сообщение из StoreTableRequest
        $response->assertJsonValidationErrors(['name']);
        $response->assertJsonFragment([
            'name' => ['Пожалуйста, укажите название или номер стола.']
        ]);
    }
}
