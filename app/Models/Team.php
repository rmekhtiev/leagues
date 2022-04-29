<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    /* Settings */
    protected $fillable = [
        'title',
        'description',
        'league_id',
        'power',
    ];

    /* Relations */
    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function homeMatches(): HasMany
    {
        return $this->hasMany(Match::class, 'home_team_id');
    }

    public function awayMatches(): HasMany
    {
        return $this->hasMany(Match::class, 'away_team_id');
    }

    public function matches(): HasMany
    {
        return $this->homeMatches()->union($this->awayMatches()->toBase());
    }

    /* Attributes */

    /* Functions */
}
