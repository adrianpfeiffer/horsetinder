<?php

use App\Models\Horse;
use App\Models\User;

describe('index', function () {
    it('redirects guests to the login page', function () {
        $response = $this->get(route('my.horses.index'));

        $response->assertRedirect(route('login'));
    });

    it('lists only the horses of the logged-in user, including hidden ones', function () {
        $owner = User::factory()->create();
        Horse::factory()->for($owner, 'owner')->create(['name' => 'Spirit']);
        Horse::factory()->for($owner, 'owner')->create(['name' => 'Ghost', 'is_active' => false]);
        Horse::factory()->create(['name' => 'Stranger']);

        $response = $this->actingAs($owner)->get(route('my.horses.index'));

        $response->assertOk()
            ->assertSee('Spirit')
            ->assertSee('Ghost')
            ->assertDontSee('Stranger');
    });
});
