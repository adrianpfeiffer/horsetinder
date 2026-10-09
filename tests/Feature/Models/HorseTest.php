<?php

use App\Models\Horse;
use App\Models\Like;

it('separates given likes from received likes', function () {
    $star = Horse::factory()->create();
    $luna = Horse::factory()->create();

    Like::factory()->for($star, 'horse')->for($luna, 'targetHorse')->create();

    expect($star->givenLikes->pluck('target_horse_id')->all())->toBe([$luna->id])
        ->and($star->receivedLikes)->toBeEmpty()
        ->and($luna->receivedLikes->pluck('horse_id')->all())->toBe([$star->id]);
});
