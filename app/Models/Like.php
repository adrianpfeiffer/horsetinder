<?php

namespace App\Models;

use Database\Factories\LikeFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
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

    /**
     * Only keep likes that were liked back, so the two horses are a match.
     *
     * @param  Builder<Like>  $query
     */
    #[Scope]
    protected function matched(Builder $query): void
    {
        $query->whereExists(function ($likeBack) {
            $likeBack->from('likes as like_back')
                ->whereColumn('like_back.horse_id', 'likes.target_horse_id')
                ->whereColumn('like_back.target_horse_id', 'likes.horse_id');
        });
    }
}
