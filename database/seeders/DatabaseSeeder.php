<?php

namespace Database\Seeders;

use App\Models\Breed;
use App\Models\Horse;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
        ]);

        $breeds = Breed::factory(8)->create();

        $owners = User::factory(10)->create();

        foreach ($owners as $owner) {
            Horse::factory(fake()->numberBetween(1, 3))
                ->for($owner, 'owner')
                ->recycle($breeds)
                ->create();
        }

        // TODO: seed likes between horses
    }
}
