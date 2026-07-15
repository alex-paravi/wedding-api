<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Table>
 */
class TableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Стол №' . $this->faker->unique()->numberBetween(1, 50),
            'capacity' => $this->faker->numberBetween(4, 12),
            'user_id' => User::factory(), // Если ID не передан, фабрика сама создаст фейкового юзера
        ];
    }
}
