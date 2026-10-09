<?php

namespace Database\Seeders;

use App\Models\Breed;
use App\Models\Horse;
use App\Models\Like;
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
        User::factory()->admin()->create([
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

        $horses = Horse::all();

        foreach ($horses as $horse) {
            $targets = $horses->except($horse->id)->random(fake()->numberBetween(0, 4));

            foreach ($targets as $target) {
                $this->like($horse, $target);
            }
        }

        // TODO: seed mutual likes so there are matches to show
    }

    /**
     * Let one horse like another, unless it already does.
     */
    private function like(Horse $horse, Horse $target): void
    {
        if ($horse->givenLikes()->where('target_horse_id', $target->id)->exists()) {
            return;
        }

        Like::factory()
            ->for($horse, 'horse')
            ->for($target, 'targetHorse')
            ->create();
    }
}
