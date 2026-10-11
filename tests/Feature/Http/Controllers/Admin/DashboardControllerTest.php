<?php

use App\Models\Horse;
use App\Models\Like;
use App\Models\User;

it('redirects guests to the login page', function () {
    $response = $this->get(route('admin.dashboard'));

    $response->assertRedirect(route('login'));
});

it('forbids users who are not admins', function () {
    $response = $this->actingAs(User::factory()->create())->get(route('admin.dashboard'));

    $response->assertForbidden();
});

it('shows admins how many records there are', function () {
    $horseA = Horse::factory()->create();
    $horseB = Horse::factory()->create();
    $horseC = Horse::factory()->create();
    Like::factory()->for($horseA, 'horse')->for($horseB, 'targetHorse')->create();
    Like::factory()->for($horseB, 'horse')->for($horseA, 'targetHorse')->create();
    Like::factory()->for($horseC, 'horse')->for($horseA, 'targetHorse')->create();

    $response = $this->actingAs(User::factory()->admin()->create())->get(route('admin.dashboard'));

    $response->assertOk()->assertViewHas('stats', [
        'Owners' => 3,
        'Horses' => 3,
        'Breeds' => 3,
        'Likes' => 3,
        'Matches' => 1,
    ]);
});
