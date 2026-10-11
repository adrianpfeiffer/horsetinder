<?php

use App\Models\Horse;
use App\Models\Like;
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

    it('links back to the page the visitor came from', function () {
        $horse = Horse::factory()->create();
        $previousPage = route('horses.index', ['page' => 3]);

        $response = $this->from($previousPage)->get(route('horses.show', $horse));

        $response->assertOk()->assertSee('href="'.$previousPage.'"', false);
    });

    it('offers only my horses that do not like this horse yet', function () {
        $owner = User::factory()->create();
        $alreadyLikes = Horse::factory()->for($owner, 'owner')->create(['name' => 'Bojack']);
        Horse::factory()->for($owner, 'owner')->create(['name' => 'Katarina']);
        $target = Horse::factory()->create(['name' => 'Luna']);
        Like::factory()->for($alreadyLikes, 'horse')->for($target, 'targetHorse')->create();

        $response = $this->actingAs($owner)->get(route('horses.show', $target));

        $response->assertOk()
            ->assertSee('Bojack likes Luna')
            ->assertSee('action="'.route('likes.destroy', $alreadyLikes->givenLikes()->first()).'"', false)
            ->assertSee('<option value="'.$owner->horses()->firstWhere('name', 'Katarina')->id.'"', false)
            ->assertDontSee('<option value="'.$alreadyLikes->id.'"', false);
    });

    it('does not offer a like button on my own horse', function () {
        $horse = Horse::factory()->create();

        $response = $this->actingAs($horse->owner)->get(route('horses.show', $horse));

        $response->assertOk()->assertSee('This is your horse.')->assertDontSee('Like as');
    });

    it('links back to all horses when coming from the same profile', function () {
        $horse = Horse::factory()->create();

        $response = $this->from(route('horses.show', $horse))->get(route('horses.show', $horse));

        $response->assertOk()->assertSee('<a href="'.route('horses.index').'" class="mt-6', false);
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
