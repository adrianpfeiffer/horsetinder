<?php

namespace App\Models;

use Database\Factories\HorseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Horse extends Model
{
    /** @use HasFactory<HorseFactory> */
    use HasFactory;

    public const GENDERS = ['mare', 'stallion', 'gelding'];

    public const DISCIPLINES = ['dressage', 'jumping', 'leisure'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'breed_id',
        'name',
        'gender',
        'birth_date',
        'discipline',
        'city',
        'bio',
        'photo_path',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * The user who owns this horse.
     *
     * @return BelongsTo<User, $this>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The breed of this horse.
     *
     * @return BelongsTo<Breed, $this>
     */
    public function breed(): BelongsTo
    {
        return $this->belongsTo(Breed::class);
    }
}
