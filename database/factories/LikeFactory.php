<?php

namespace Database\Factories;

use App\Models\Horse;
use App\Models\Like;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'horse_id' => Horse::factory(),
            'target_horse_id' => Horse::factory(),
        ];
    }
}
