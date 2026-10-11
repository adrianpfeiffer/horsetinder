<?php

namespace Database\Seeders;

use App\Models\Breed;
use App\Models\Horse;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->admin()->create([
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

        Horse::factory(2)
            ->for($admin, 'owner')
            ->recycle($breeds)
            ->create();

        $horses = Horse::all();

        $this->givePhotos($horses);

        foreach ($horses as $horse) {
            $targets = $horses->except($horse->id)->random(fake()->numberBetween(0, 4));

            foreach ($targets as $target) {
                $this->like($horse, $target);
            }
        }

        foreach (range(1, 5) as $i) {
            $horse = $horses->random();
            $target = $horses->where('user_id', '!=', $horse->user_id)->random();

            $this->like($horse, $target);
            $this->like($target, $horse);
        }

        $this->seedAdminActivity($admin, $horses);
    }

    /**
     * Give every horse one of the photos in database/seeders/photos, removing photos of earlier seeds.
     *
     * @param  Collection<int, Horse>  $horses
     */
    private function givePhotos(Collection $horses): void
    {
        Storage::disk('public')->deleteDirectory('horses');

        $photos = collect(glob(database_path('seeders/photos/*.jpg')))->shuffle()->values();

        foreach ($horses->values() as $index => $horse) {
            $photo = $photos[$index % $photos->count()];

            $horse->update(['photo_path' => Storage::disk('public')->putFile('horses', new File($photo))]);
        }
    }

    /**
     * Give the admin, who evaluators log in as, a match and a like to answer.
     *
     * @param  Collection<int, Horse>  $horses
     */
    private function seedAdminActivity(User $admin, Collection $horses): void
    {
        $adminHorse = $admin->horses()->first();
        $otherHorses = $horses->where('user_id', '!=', $admin->id)->shuffle();

        $match = $otherHorses->first();
        $this->like($adminHorse, $match);
        $this->like($match, $adminHorse);

        $alreadyLiked = Like::whereIn('horse_id', $admin->horses()->pluck('id'))->pluck('target_horse_id');
        $admirer = $otherHorses->whereNotIn('id', $alreadyLiked)->first();
        $this->like($admirer, $adminHorse);
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
