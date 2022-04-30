<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Match extends Model
{
    use HasFactory;

    /* Settings */
    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'league_id',
        'home_team_score',
        'away_team_score',
        'status',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
      'started_at' => 'datetime',
      'finished_at' => 'datetime',
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
    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    //todo teams relation

    /* Attributes */

    /* Functions */

    public function getTeamPosition(Team $team): ?string
    {
        if ($team->getKey() !== $this->home_team_id && $team->getKey() !== $this->away_team_id)
        {
             return null;
        }

        return $team->getKey() === $this->home_team_id ? 'home' : 'away';
    }

    public function getOpponentTeam(Team $team): Team
    {
        return $team->getKey() === $this->home_team_id ? $this->awayTeam : $this->homeTeam;
    }
}
