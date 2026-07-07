<?php

namespace Database\Factories;

use App\Models\Guest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Guest>
 */
class GuestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // fake() — это встроенная библиотека Faker. Она генерирует реалистичный мусор.
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'side' => fake()->randomElement(['groom', 'bride']),
            'category' => fake()->randomElement(['friend', 'relative', 'colleague']),
            'status' => 'pending', // по умолчанию все "в ожидании"
            'table_id' => null, // теперь гость ссылается на ID стола, а не на номер

            // Магия: если мы не передали user_id руками, фабрика сама создаст 
            // фейкового юзера "на лету" и возьмет его ID!
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
