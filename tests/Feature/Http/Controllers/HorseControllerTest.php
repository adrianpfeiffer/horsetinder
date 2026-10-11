<?php

use App\Models\Horse;
use App\Models\User;

describe('index', function () {
    it('lists active horses to guests', function () {
        Horse::factory()->create(['name' => 'Spirit']);

        $response = $this->get(route('horses.index'));

        $response->assertOk()->assertSee('Spirit');
    });

    it('does not list hidden horses', function () {
        Horse::factory()->create(['name' => 'Ghost', 'is_active' => false]);

        $response = $this->get(route('horses.index'));

        $response->assertOk()->assertDontSee('Ghost');
    });
});

describe('show', function () {
    it('shows the profile of an active horse to guests', function () {
        $horse = Horse::factory()->create(['name' => 'Spirit']);

        $response = $this->get(route('horses.show', $horse));

        $response->assertOk()->assertSee('Spirit')->assertSee($horse->breed->name);
    });

    it('returns 404 for a hidden horse of another owner', function () {
        $horse = Horse::factory()->create(['is_active' => false]);

        $response = $this->actingAs(User::factory()->create())->get(route('horses.show', $horse));

        $response->assertNotFound();
    });

    it('shows a hidden horse to its owner', function () {
        $horse = Horse::factory()->create(['is_active' => false]);

        $response = $this->actingAs($horse->owner)->get(route('horses.show', $horse));

        $response->assertOk()->assertSee('This horse is hidden');
    });
});
