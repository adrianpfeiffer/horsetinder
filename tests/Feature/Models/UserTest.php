<?php

use App\Models\User;

it('registers new users as regular users, not admins', function () {
    $this->post('/register', [
        'name' => 'Test Owner',
        'email' => 'owner@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    expect(User::firstWhere('email', 'owner@example.com')->isAdmin())->toBeFalse();
});
