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
