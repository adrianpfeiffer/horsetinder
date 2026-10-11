<?php

use App\Models\Horse;
use App\Models\Like;
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

it('counts the matches of all my horses, not one-way likes', function () {
    $owner = User::factory()->create();
    [$bojack, $katarina] = Horse::factory(2)->for($owner, 'owner')->create();
    [$luna, $storm, $spirit] = Horse::factory(3)->create();
    Like::create(['horse_id' => $bojack->id, 'target_horse_id' => $luna->id]);
    Like::create(['horse_id' => $luna->id, 'target_horse_id' => $bojack->id]);
    Like::create(['horse_id' => $katarina->id, 'target_horse_id' => $storm->id]);
    Like::create(['horse_id' => $storm->id, 'target_horse_id' => $katarina->id]);
    Like::create(['horse_id' => $bojack->id, 'target_horse_id' => $spirit->id]);

    expect($owner->matchCount())->toBe(2);
});
