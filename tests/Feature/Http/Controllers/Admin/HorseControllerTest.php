<?php

use App\Models\Horse;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
});

describe('index', function () {
    it('forbids users who are not admins', function () {
        $response = $this->actingAs(User::factory()->create())->get(route('admin.horses.index'));

        $response->assertForbidden();
    });

    it('lists all horses, also hidden ones', function () {
        Horse::factory()->create(['name' => 'Spirit']);
        Horse::factory()->create(['name' => 'Ghost', 'is_active' => false]);

        $response = $this->actingAs($this->admin)->get(route('admin.horses.index'));

        $response->assertOk()->assertSee('Spirit')->assertSee('Ghost');
    });
});

describe('destroy', function () {
    it('forbids users who are not admins', function () {
        $horse = Horse::factory()->create();

        $response = $this->actingAs(User::factory()->create())->delete(route('admin.horses.destroy', $horse));

        $response->assertForbidden();
        $this->assertModelExists($horse);
    });

    it('removes any horse with its photo and likes', function () {
        Storage::fake('public');
        $path = UploadedFile::fake()->image('spirit.jpg')->store('horses', 'public');
        $horse = Horse::factory()->create(['name' => 'Spirit', 'photo_path' => $path]);
        $like = Like::factory()->for($horse, 'targetHorse')->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.horses.destroy', $horse));

        $response->assertRedirect(route('admin.horses.index'))->assertSessionHas('status', 'Spirit was removed.');
        $this->assertModelMissing($horse);
        $this->assertModelMissing($like);
        Storage::disk('public')->assertMissing($path);
    });
});
