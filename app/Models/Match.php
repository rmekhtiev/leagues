<?php

namespace App\Models;

use App\Enums\MatchResultEnum;
use App\Enums\MatchStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\QueryBuilder\AllowedFilter;

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
        'week',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public static function getAllowedFilters(): array
    {
        return [
            AllowedFilter::scope('finished'),
            AllowedFilter::scope('upcoming'),
            AllowedFilter::scope('live'),
            AllowedFilter::scope('by_week'),
            AllowedFilter::scope('by_league'),
            AllowedFilter::scope('by_team'),
            AllowedFilter::scope('by_result'),
            AllowedFilter::scope('wins'),
            AllowedFilter::scope('loses'),
            AllowedFilter::scope('draws'),
            AllowedFilter::scope('until_week'),
            AllowedFilter::scope('after_week'),
            AllowedFilter::exact('league_id'),
        ];
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

    /* Attributes */

    /* Scopes */
    public function scopeFinished(Builder $builder): Builder
    {
        return $builder->where('status', MatchStatusEnum::FINISHED);
    }

    public function scopeUpcoming(Builder $builder): Builder
    {
        return $builder->where('status', MatchStatusEnum::UPCOMING);
    }

    public function scopeLive(Builder $builder): Builder
    {
        return $builder->where('status', MatchStatusEnum::LIVE);
    }

    public function scopeByWeek(Builder $builder, int $week): Builder
    {
        return $builder->where('week', $week);
    }

    public function scopeByLeague(Builder $builder, int $leagueId): Builder
    {
        return $builder->where('league_id', $leagueId);
    }

    public function scopeByTeam(Builder $builder, int $teamId): Builder
    {
        return $builder->where('home_team_id', $teamId)->orWhere('away_team_id', $teamId);
    }

    public function scopeByResult(Builder $builder, int $teamId, string $result): Builder
    {
        $builder = $builder->byTeam($teamId);
        switch ($result) {
            case MatchResultEnum::WIN:
                $builderSign = '>';
                break;
            case MatchResultEnum::LOSE:
                $builderSign = '<';
                break;
            case MatchResultEnum::DRAW:
                $builderSign = '=';
                break;
            default:
                return $builder;
        }

        return $builder
            ->where(function (Builder $builder) use ($teamId, $builderSign) {
                $builder->where('home_team_id', $teamId)->whereRaw("home_team_score {$builderSign} away_team_score");
            })
            ->orWhere(function (Builder $builder) use ($teamId, $builderSign) {
                $builder->where('away_team_id', $teamId)->whereRaw("away_team_score {$builderSign} home_team_score");
            });
    }

    public function scopeWins(Builder $builder, int $teamId): Builder
    {
        return $builder->byResult($teamId, MatchResultEnum::WIN);
    }

    public function scopeLoses(Builder $builder, int $teamId): Builder
    {
        return $builder->byResult($teamId, MatchResultEnum::LOSE);
    }

    public function scopeDraws(Builder $builder, int $teamId): Builder
    {
        return $builder->byResult($teamId, MatchResultEnum::DRAW);
    }

    public function scopeUntilWeek(Builder $builder, ?int $week): Builder
    {
        if (!$week) {
            return $builder;
        }

        return $builder->where('week', '<=', $week);
    }

    public function scopeAfterWeek(Builder $builder, ?int $week): Builder
    {
        if (!$week) {
            return $builder;
        }

        return $builder->where('week', '>=', $week);
    }

    /* Functions */
    public function getTeamPosition(Team $team): ?string
    {
        if ($team->getKey() !== $this->home_team_id && $team->getKey() !== $this->away_team_id) {
            return null;
        }

        return $team->getKey() === $this->home_team_id ? 'home' : 'away';
    }

    public function getOpponentTeam(Team $team): Team
    {
        return $team->getKey() === $this->home_team_id ? $this->awayTeam : $this->homeTeam;
    }
}
