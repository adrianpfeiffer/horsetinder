<?php

use App\Models\Breed;
use App\Models\Horse;

describe('index', function () {
    it('lists breeds with their number of active horses', function () {
        $breed = Breed::factory()->create(['name' => 'Friesian']);
        Horse::factory(2)->for($breed)->create();
        Horse::factory()->for($breed)->create(['is_active' => false]);

        $response = $this->get(route('breeds.index'));

        $response->assertOk()->assertSee('Friesian')->assertSee('2 horses');
    });
});

describe('show', function () {
    it('shows the breed with only its active horses', function () {
        $breed = Breed::factory()->create(['name' => 'Friesian']);
        Horse::factory()->for($breed)->create(['name' => 'Spirit']);
        Horse::factory()->for($breed)->create(['name' => 'Ghost', 'is_active' => false]);
        Horse::factory()->create(['name' => 'Stranger']);

        $response = $this->get(route('breeds.show', $breed));

        $response->assertOk()
            ->assertSee('Friesian')
            ->assertSee('Spirit')
            ->assertDontSee('Ghost')
            ->assertDontSee('Stranger');
    });
});
