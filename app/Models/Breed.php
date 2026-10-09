<?php

namespace App\Models;

use Database\Factories\BreedFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Breed extends Model
{
    /** @use HasFactory<BreedFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'origin_country',
        'description',
    ];

    /**
     * The horses of this breed.
     *
     * @return HasMany<Horse, $this>
     */
    public function horses(): HasMany
    {
        return $this->hasMany(Horse::class);
    }
}
