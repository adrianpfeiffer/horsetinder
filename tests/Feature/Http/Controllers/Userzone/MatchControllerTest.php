<?php

use App\Models\Horse;
use App\Models\Like;
use App\Models\User;

describe('index', function () {
    it('redirects guests to the login page', function () {
        $response = $this->get(route('matches.index'));

        $response->assertRedirect(route('login'));
    });

    it('shows a match with the other owner\'s email', function () {
        $myHorse = Horse::factory()->create(['name' => 'Bojack']);
        $otherOwner = User::factory()->create(['email' => 'luna.owner@example.com']);
        $theirHorse = Horse::factory()->for($otherOwner, 'owner')->create(['name' => 'Luna']);
        Like::factory()->for($myHorse, 'horse')->for($theirHorse, 'targetHorse')->create();
        Like::factory()->for($theirHorse, 'horse')->for($myHorse, 'targetHorse')->create();

        $response = $this->actingAs($myHorse->owner)->get(route('matches.index'));

        $response->assertOk()
            ->assertSee('Bojack & Luna', false)
            ->assertSee('mailto:luna.owner@example.com', false);
    });

    it('does not show likes that were not returned', function () {
        $myHorse = Horse::factory()->create();
        $iLike = Horse::factory()->create(['name' => 'Luna']);
        $likesMe = Horse::factory()->create(['name' => 'Storm']);
        Like::factory()->for($myHorse, 'horse')->for($iLike, 'targetHorse')->create();
        Like::factory()->for($likesMe, 'horse')->for($myHorse, 'targetHorse')->create();

        $response = $this->actingAs($myHorse->owner)->get(route('matches.index'));

        $response->assertOk()->assertSee('No matches yet')->assertDontSee('Luna')->assertDontSee('Storm');
    });

    it('does not show matches between other owners\' horses', function () {
        $horseA = Horse::factory()->create(['name' => 'Luna']);
        $horseB = Horse::factory()->create(['name' => 'Storm']);
        Like::factory()->for($horseA, 'horse')->for($horseB, 'targetHorse')->create();
        Like::factory()->for($horseB, 'horse')->for($horseA, 'targetHorse')->create();

        $response = $this->actingAs(User::factory()->create())->get(route('matches.index'));

        $response->assertOk()->assertSee('No matches yet')->assertDontSee('Luna');
    });
});
