<?php

use App\Models\Horse;
use App\Models\Like;
use Illuminate\Database\UniqueConstraintViolationException;

it('rejects a second like for the same pair of horses', function () {
    [$star, $luna] = Horse::factory(2)->create();

    Like::create(['horse_id' => $star->id, 'target_horse_id' => $luna->id]);
    Like::create(['horse_id' => $star->id, 'target_horse_id' => $luna->id]);
})->throws(UniqueConstraintViolationException::class);

it('keeps only likes that were liked back when asking for matches', function () {
    [$star, $luna, $storm] = Horse::factory(3)->create();
    $starLikesLuna = Like::create(['horse_id' => $star->id, 'target_horse_id' => $luna->id]);
    $lunaLikesStar = Like::create(['horse_id' => $luna->id, 'target_horse_id' => $star->id]);
    Like::create(['horse_id' => $storm->id, 'target_horse_id' => $star->id]);

    $matched = Like::matched()->pluck('id')->sort()->values()->all();

    expect($matched)->toBe([$starLikesLuna->id, $lunaLikesStar->id]);
});
