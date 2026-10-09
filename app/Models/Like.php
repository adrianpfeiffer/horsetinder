<?php

namespace App\Models;

use Database\Factories\LikeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    /** @use HasFactory<LikeFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'horse_id',
        'target_horse_id',
    ];

    /**
     * The horse that gave the like.
     *
     * @return BelongsTo<Horse, $this>
     */
    public function horse(): BelongsTo
    {
        return $this->belongsTo(Horse::class);
    }

    /**
     * The horse that received the like.
     *
     * @return BelongsTo<Horse, $this>
     */
    public function targetHorse(): BelongsTo
    {
        return $this->belongsTo(Horse::class, 'target_horse_id');
    }
}
