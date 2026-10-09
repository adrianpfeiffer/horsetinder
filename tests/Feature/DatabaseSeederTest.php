<?php

use App\Models\Breed;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

it('creates an admin who can log in with the default password', function () {
    $admin = User::firstWhere('email', 'admin@admin.com');

    expect(Hash::check('password', $admin->password))->toBeTrue();
});

it('creates 8 breeds', function () {
    expect(Breed::count())->toBe(8);
});

it('creates 10 owners with 1 to 3 horses each', function () {
    $owners = User::where('email', '!=', 'admin@admin.com')->withCount('horses')->get();

    expect($owners)->toHaveCount(10)
        ->and($owners->pluck('horses_count'))->each->toBeGreaterThanOrEqual(1)->toBeLessThanOrEqual(3);
});
