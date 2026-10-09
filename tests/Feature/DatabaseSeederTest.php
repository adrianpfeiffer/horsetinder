<?php

use App\Models\Breed;
use App\Models\Like;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

it('creates an admin who can log in with the default password', function () {
    $admin = User::firstWhere('email', 'admin@admin.com');

    expect($admin->isAdmin())->toBeTrue()
        ->and(Hash::check('password', $admin->password))->toBeTrue();
});

it('creates 8 breeds', function () {
    expect(Breed::count())->toBe(8);
});

it('creates 10 owners with 1 to 3 horses each', function () {
    $owners = User::where('role', 'user')->withCount('horses')->get();

    expect($owners)->toHaveCount(10)
        ->and($owners->pluck('horses_count'))->each->toBeGreaterThanOrEqual(1)->toBeLessThanOrEqual(3);
});

it('never lets a horse like itself', function () {
    expect(Like::whereColumn('horse_id', 'target_horse_id')->exists())->toBeFalse();
});
