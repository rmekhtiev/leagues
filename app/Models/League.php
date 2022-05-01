<?php

namespace App\Models;

use App\Enums\MatchStatusEnum;
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
    public function getWeeksAttribute(): int
    {
        return $this->teams()->count() * 2 - 2;
    }

    public function getLatestPlayedWeekAttribute(): int
    {
        $lastMatch = $this
            ->matches()
            ->finished()
            ->orderByDesc('week')
            ->first();
        return $lastMatch ? $lastMatch->week : 1;
    }

    public function getLatestPlayingWeekAttribute(): int
    {
        $lastMatch = $this
            ->matches()
            ->whereIn('status', [MatchStatusEnum::FINISHED, MatchStatusEnum::LIVE])
            ->orderByDesc('week')
            ->first();
        return $lastMatch ? $lastMatch->week : 1;
    }

    /* Functions */
}
