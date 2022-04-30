<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class League extends Model
{
    use HasFactory;

    /* Settings */
    protected $fillable = [
        'title',
        'description',
        'poster_url',
    ];

    public static function getAllowedFilters(): array
    {
        return [];
    }

    public static function getAllowedSorts(): array
    {
        return [];
    }

    /* Relations */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function matches(): HasMany
    {
        return $this->hasMany(Match::class);
    }

    /* Attributes */

    /* Functions */
}
