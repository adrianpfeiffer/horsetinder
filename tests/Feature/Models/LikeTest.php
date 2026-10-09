<?php

use App\Models\Horse;
use App\Models\Like;
use Illuminate\Database\UniqueConstraintViolationException;

it('rejects a second like for the same pair of horses', function () {
    [$star, $luna] = Horse::factory(2)->create();

    Like::create(['horse_id' => $star->id, 'target_horse_id' => $luna->id]);
    Like::create(['horse_id' => $star->id, 'target_horse_id' => $luna->id]);
})->throws(UniqueConstraintViolationException::class);
