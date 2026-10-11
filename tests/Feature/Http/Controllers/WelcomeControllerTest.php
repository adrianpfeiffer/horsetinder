<?php

use App\Models\Horse;

it('shows the newest active horses', function () {
    Horse::factory()->create(['name' => 'Oldie', 'created_at' => now()->subDays(5)]);
    Horse::factory()->create(['name' => 'Ghost', 'is_active' => false]);
    Horse::factory(3)->sequence(['name' => 'Spirit'], ['name' => 'Luna'], ['name' => 'Storm'])->create();

    $response = $this->get(route('welcome'));

    $response->assertOk()
        ->assertSee('Neigh')
        ->assertSee(['Spirit', 'Luna', 'Storm'])
        ->assertDontSee('Oldie')
        ->assertDontSee('Ghost');
});
