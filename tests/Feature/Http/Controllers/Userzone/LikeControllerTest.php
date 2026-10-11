<?php

use App\Models\Horse;
use App\Models\Like;
use App\Models\User;

describe('store', function () {
    it('redirects guests to the login page', function () {
        $target = Horse::factory()->create();

        $response = $this->post(route('likes.store', $target), ['horse_id' => Horse::factory()->create()->id]);

        $response->assertRedirect(route('login'));
        expect(Like::count())->toBe(0);
    });

    it('lets one of my horses like another owner\'s horse', function () {
        $myHorse = Horse::factory()->create();
        $target = Horse::factory()->create(['name' => 'Luna']);

        $response = $this->actingAs($myHorse->owner)->post(route('likes.store', $target), ['horse_id' => $myHorse->id]);

        $response->assertRedirect(route('horses.show', $target))->assertSessionHas('status', 'You liked Luna.');
        $this->assertDatabaseHas('likes', ['horse_id' => $myHorse->id, 'target_horse_id' => $target->id]);
    });

    it('announces a match when the other horse already likes mine', function () {
        $myHorse = Horse::factory()->create();
        $target = Horse::factory()->create(['name' => 'Luna']);
        Like::factory()->for($target, 'horse')->for($myHorse, 'targetHorse')->create();

        $response = $this->actingAs($myHorse->owner)->post(route('likes.store', $target), ['horse_id' => $myHorse->id]);

        $response->assertSessionHas('status', "It's a match with Luna! 🎉");
    });

    it('rejects liking with a horse of another owner', function () {
        $someoneElsesHorse = Horse::factory()->create();
        $target = Horse::factory()->create();

        $response = $this->actingAs(User::factory()->create())->post(route('likes.store', $target), ['horse_id' => $someoneElsesHorse->id]);

        $response->assertSessionHasErrors(['horse_id' => 'Choose one of your own horses.']);
        expect(Like::count())->toBe(0);
    });

    it('rejects liking the same horse twice', function () {
        $myHorse = Horse::factory()->create();
        $target = Horse::factory()->create(['name' => 'Luna']);
        Like::factory()->for($myHorse, 'horse')->for($target, 'targetHorse')->create();

        $response = $this->actingAs($myHorse->owner)->post(route('likes.store', $target), ['horse_id' => $myHorse->id]);

        $response->assertSessionHasErrors(['horse_id' => 'That horse already likes Luna.']);
        expect(Like::count())->toBe(1);
    });

    it('forbids liking one of my own horses', function () {
        $owner = User::factory()->create();
        $myHorse = Horse::factory()->for($owner, 'owner')->create();
        $myOtherHorse = Horse::factory()->for($owner, 'owner')->create();

        $response = $this->actingAs($owner)->post(route('likes.store', $myOtherHorse), ['horse_id' => $myHorse->id]);

        $response->assertForbidden();
        expect(Like::count())->toBe(0);
    });

    it('returns 404 when liking a hidden horse', function () {
        $myHorse = Horse::factory()->create();
        $target = Horse::factory()->create(['is_active' => false]);

        $response = $this->actingAs($myHorse->owner)->post(route('likes.store', $target), ['horse_id' => $myHorse->id]);

        $response->assertNotFound();
        expect(Like::count())->toBe(0);
    });
});
