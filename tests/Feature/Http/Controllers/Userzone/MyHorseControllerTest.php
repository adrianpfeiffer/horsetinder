<?php

use App\Models\Breed;
use App\Models\Horse;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

describe('create', function () {
    it('shows the form with the breeds to choose from', function () {
        Breed::factory()->create(['name' => 'Friesian']);

        $response = $this->actingAs(User::factory()->create())->get(route('my.horses.create'));

        $response->assertOk()->assertSee('Friesian');
    });
});

describe('store', function () {
    it('redirects guests to the login page', function () {
        $response = $this->post(route('my.horses.store'), []);

        $response->assertRedirect(route('login'));
        expect(Horse::count())->toBe(0);
    });

    it('adds a horse owned by the logged-in user', function () {
        $owner = User::factory()->create();
        $breed = Breed::factory()->create();

        $response = $this->actingAs($owner)->post(route('my.horses.store'), [
            'name' => 'Spirit',
            'breed_id' => $breed->id,
            'gender' => 'mare',
            'birth_date' => '2018-05-01',
            'discipline' => 'jumping',
            'city' => 'Brussels',
            'bio' => 'Loves apples.',
            'user_id' => User::factory()->create()->id,
        ]);

        $response->assertRedirect(route('my.horses.index'))->assertSessionHas('status', 'Spirit was added.');
        $this->assertDatabaseHas('horses', [
            'user_id' => $owner->id,
            'breed_id' => $breed->id,
            'name' => 'Spirit',
            'gender' => 'mare',
            'discipline' => 'jumping',
            'city' => 'Brussels',
            'is_active' => true,
        ]);
    });

    it('requires all fields except the bio', function () {
        $response = $this->actingAs(User::factory()->create())->post(route('my.horses.store'), []);

        $response->assertSessionHasErrors([
            'name' => 'The name field is required.',
            'breed_id' => 'The breed field is required.',
            'gender' => 'The gender field is required.',
            'birth_date' => 'The birth date field is required.',
            'discipline' => 'The discipline field is required.',
            'city' => 'The city field is required.',
        ])->assertSessionDoesntHaveErrors('bio');
        expect(Horse::count())->toBe(0);
    });

    it('rejects values that are not allowed', function () {
        $response = $this->actingAs(User::factory()->create())->post(route('my.horses.store'), [
            'name' => 'Spirit',
            'breed_id' => 999,
            'gender' => 'unicorn',
            'birth_date' => now()->addDay()->toDateString(),
            'discipline' => 'racing',
            'city' => 'Brussels',
        ]);

        $response->assertSessionHasErrors([
            'breed_id' => 'The selected breed is invalid.',
            'gender' => 'The selected gender is invalid.',
            'birth_date' => 'The birth date field must be a date before or equal to today.',
            'discipline' => 'The selected discipline is invalid.',
        ]);
        expect(Horse::count())->toBe(0);
    });
});

describe('edit', function () {
    it('shows the form filled in with the horse', function () {
        $horse = Horse::factory()->create(['name' => 'Spirit', 'city' => 'Brussels']);

        $response = $this->actingAs($horse->owner)->get(route('my.horses.edit', $horse));

        $response->assertOk()->assertSee('value="Spirit"', false)->assertSee('value="Brussels"', false);
    });

    it('forbids editing a horse of another owner', function () {
        $horse = Horse::factory()->create();

        $response = $this->actingAs(User::factory()->create())->get(route('my.horses.edit', $horse));

        $response->assertForbidden();
    });
});

describe('update', function () {
    it('saves the changes, including hiding the horse', function () {
        $horse = Horse::factory()->create(['name' => 'Spirit']);
        $breed = Breed::factory()->create();

        $response = $this->actingAs($horse->owner)->put(route('my.horses.update', $horse), [
            'name' => 'Storm',
            'breed_id' => $breed->id,
            'gender' => 'gelding',
            'birth_date' => '2015-03-10',
            'discipline' => 'dressage',
            'city' => 'Ghent',
            'bio' => 'Calm and kind.',
            'is_active' => '0',
        ]);

        $response->assertRedirect(route('my.horses.index'))->assertSessionHas('status', 'Storm was updated.');
        expect($horse->fresh())
            ->name->toBe('Storm')
            ->breed_id->toBe($breed->id)
            ->city->toBe('Ghent')
            ->is_active->toBeFalse();
    });

    it('rejects invalid input and keeps the horse unchanged', function () {
        $horse = Horse::factory()->create(['name' => 'Spirit']);

        $response = $this->actingAs($horse->owner)->put(route('my.horses.update', $horse), ['name' => '']);

        $response->assertSessionHasErrors(['name' => 'The name field is required.']);
        expect($horse->fresh()->name)->toBe('Spirit');
    });

    it('forbids updating a horse of another owner', function () {
        $horse = Horse::factory()->create(['name' => 'Spirit']);

        $response = $this->actingAs(User::factory()->create())->put(route('my.horses.update', $horse), [
            'name' => 'Stolen',
            'breed_id' => $horse->breed_id,
            'gender' => $horse->gender,
            'birth_date' => '2015-03-10',
            'discipline' => $horse->discipline,
            'city' => $horse->city,
        ]);

        $response->assertForbidden();
        expect($horse->fresh()->name)->toBe('Spirit');
    });
});

describe('destroy', function () {
    it('deletes the horse and its likes', function () {
        $horse = Horse::factory()->create(['name' => 'Spirit']);
        $like = Like::factory()->for($horse, 'horse')->create();

        $response = $this->actingAs($horse->owner)->delete(route('my.horses.destroy', $horse));

        $response->assertRedirect(route('my.horses.index'))->assertSessionHas('status', 'Spirit was deleted.');
        $this->assertModelMissing($horse);
        $this->assertModelMissing($like);
    });

    it('forbids deleting a horse of another owner', function () {
        $horse = Horse::factory()->create();

        $response = $this->actingAs(User::factory()->create())->delete(route('my.horses.destroy', $horse));

        $response->assertForbidden();
        $this->assertModelExists($horse);
    });
});

describe('photo', function () {
    beforeEach(function () {
        Storage::fake('public');
    });

    it('stores the uploaded photo when adding a horse', function () {
        $owner = User::factory()->create();

        $this->actingAs($owner)->post(route('my.horses.store'), [
            'name' => 'Spirit',
            'breed_id' => Breed::factory()->create()->id,
            'gender' => 'mare',
            'birth_date' => '2018-05-01',
            'discipline' => 'jumping',
            'city' => 'Brussels',
            'photo' => UploadedFile::fake()->image('spirit.jpg'),
        ]);

        $horse = $owner->horses()->first();
        expect($horse->photo_path)->toStartWith('horses/');
        Storage::disk('public')->assertExists($horse->photo_path);
    });

    it('replaces the old photo file when uploading a new one', function () {
        $oldPath = UploadedFile::fake()->image('old.jpg')->store('horses', 'public');
        $horse = Horse::factory()->create(['photo_path' => $oldPath]);

        $this->actingAs($horse->owner)->put(route('my.horses.update', $horse), [
            'name' => $horse->name,
            'breed_id' => $horse->breed_id,
            'gender' => $horse->gender,
            'birth_date' => '2015-03-10',
            'discipline' => $horse->discipline,
            'city' => $horse->city,
            'photo' => UploadedFile::fake()->image('new.jpg'),
        ]);

        $newPath = $horse->fresh()->photo_path;
        expect($newPath)->not->toBe($oldPath);
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($newPath);
    });

    it('deletes the photo file together with the horse', function () {
        $path = UploadedFile::fake()->image('spirit.jpg')->store('horses', 'public');
        $horse = Horse::factory()->create(['photo_path' => $path]);

        $this->actingAs($horse->owner)->delete(route('my.horses.destroy', $horse));

        Storage::disk('public')->assertMissing($path);
    });

    it('rejects a file that is not an image', function () {
        $response = $this->actingAs(User::factory()->create())->post(route('my.horses.store'), [
            'photo' => UploadedFile::fake()->create('notes.pdf', 10, 'application/pdf'),
        ]);

        $response->assertSessionHasErrors(['photo' => 'The photo field must be an image.']);
        expect(Storage::disk('public')->allFiles())->toBeEmpty();
    });

    it('rejects a photo larger than 5 MB', function () {
        $response = $this->actingAs(User::factory()->create())->post(route('my.horses.store'), [
            'photo' => UploadedFile::fake()->image('big.jpg')->size(5121),
        ]);

        $response->assertSessionHasErrors(['photo' => 'The photo field must not be greater than 5120 kilobytes.']);
        expect(Storage::disk('public')->allFiles())->toBeEmpty();
    });
});
