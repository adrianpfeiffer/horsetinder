<?php

use App\Models\Breed;
use App\Models\Horse;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

it('forbids users who are not admins', function () {
    $response = $this->actingAs(User::factory()->create())->get(route('admin.breeds.index'));

    $response->assertForbidden();
});

describe('index', function () {
    it('lists the breeds with their number of horses', function () {
        $breed = Breed::factory()->create(['name' => 'Friesian']);
        Horse::factory(2)->for($breed)->create();

        $response = $this->actingAs($this->admin)->get(route('admin.breeds.index'));

        $response->assertOk()->assertSee('Friesian')->assertViewHas('breeds', fn ($breeds) => $breeds->first()->horses_count === 2);
    });
});

describe('create', function () {
    it('shows an empty form', function () {
        $response = $this->actingAs($this->admin)->get(route('admin.breeds.create'));

        $response->assertOk()->assertSee('Add breed');
    });
});

describe('store', function () {
    it('adds a breed', function () {
        $response = $this->actingAs($this->admin)->post(route('admin.breeds.store'), [
            'name' => 'Friesian',
            'origin_country' => 'Netherlands',
            'description' => 'Black and elegant.',
        ]);

        $response->assertRedirect(route('admin.breeds.index'))->assertSessionHas('status', 'Friesian was added.');
        $this->assertDatabaseHas('breeds', ['name' => 'Friesian', 'origin_country' => 'Netherlands']);
    });

    it('requires all fields', function () {
        $response = $this->actingAs($this->admin)->post(route('admin.breeds.store'), []);

        $response->assertSessionHasErrors([
            'name' => 'The name field is required.',
            'origin_country' => 'The country of origin field is required.',
            'description' => 'The description field is required.',
        ]);
        expect(Breed::count())->toBe(0);
    });

    it('rejects a name that already exists', function () {
        Breed::factory()->create(['name' => 'Friesian']);

        $response = $this->actingAs($this->admin)->post(route('admin.breeds.store'), [
            'name' => 'Friesian',
            'origin_country' => 'Netherlands',
            'description' => 'Black and elegant.',
        ]);

        $response->assertSessionHasErrors(['name' => 'The name has already been taken.']);
        expect(Breed::count())->toBe(1);
    });
});

describe('show', function () {
    it('shows the breed with all its horses, also hidden ones', function () {
        $breed = Breed::factory()->create(['name' => 'Friesian']);
        Horse::factory()->for($breed)->create(['name' => 'Ghost', 'is_active' => false]);

        $response = $this->actingAs($this->admin)->get(route('admin.breeds.show', $breed));

        $response->assertOk()->assertSee('Friesian')->assertSee('Ghost')->assertSee('Hidden');
    });
});

describe('edit', function () {
    it('shows the form filled in with the breed', function () {
        $breed = Breed::factory()->create(['name' => 'Friesian']);

        $response = $this->actingAs($this->admin)->get(route('admin.breeds.edit', $breed));

        $response->assertOk()->assertSee('value="Friesian"', false);
    });
});

describe('update', function () {
    it('saves the changes and allows keeping the same name', function () {
        $breed = Breed::factory()->create(['name' => 'Friesian']);

        $response = $this->actingAs($this->admin)->put(route('admin.breeds.update', $breed), [
            'name' => 'Friesian',
            'origin_country' => 'Friesland',
            'description' => 'Updated.',
        ]);

        $response->assertRedirect(route('admin.breeds.index'))->assertSessionHas('status', 'Friesian was updated.');
        expect($breed->fresh())->origin_country->toBe('Friesland')->description->toBe('Updated.');
    });

    it('rejects the name of another breed', function () {
        Breed::factory()->create(['name' => 'Arabian']);
        $breed = Breed::factory()->create(['name' => 'Friesian']);

        $response = $this->actingAs($this->admin)->put(route('admin.breeds.update', $breed), [
            'name' => 'Arabian',
            'origin_country' => 'Netherlands',
            'description' => 'Black and elegant.',
        ]);

        $response->assertSessionHasErrors(['name' => 'The name has already been taken.']);
        expect($breed->fresh()->name)->toBe('Friesian');
    });
});

describe('destroy', function () {
    it('deletes a breed without horses', function () {
        $breed = Breed::factory()->create(['name' => 'Friesian']);

        $response = $this->actingAs($this->admin)->delete(route('admin.breeds.destroy', $breed));

        $response->assertRedirect(route('admin.breeds.index'))->assertSessionHas('status', 'Friesian was deleted.');
        $this->assertModelMissing($breed);
    });

    it('keeps a breed that still has horses', function () {
        $breed = Breed::factory()->create(['name' => 'Friesian']);
        Horse::factory()->for($breed)->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.breeds.destroy', $breed));

        $response->assertRedirect(route('admin.breeds.index'))
            ->assertSessionHas('error', "Friesian still has horses, so it can't be deleted.");
        $this->assertModelExists($breed);
    });
});
