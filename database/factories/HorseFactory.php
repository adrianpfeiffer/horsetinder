<?php

namespace Database\Factories;

use App\Models\Breed;
use App\Models\Horse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Horse>
 */
class HorseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'breed_id' => Breed::factory(),
            'name' => fake()->firstName(),
            'gender' => fake()->randomElement(Horse::GENDERS),
            'birth_date' => fake()->dateTimeBetween('-25 years', '-2 years'),
            'discipline' => fake()->randomElement(Horse::DISCIPLINES),
            'city' => fake()->city(),
            'bio' => fake()->sentences(3, true),
            'photo_path' => null,
            'is_active' => true,
        ];
    }
}
