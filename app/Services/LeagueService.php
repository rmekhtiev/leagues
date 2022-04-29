<?php

namespace App\Services;

use App\Enums\MatchStatusEnum;
use App\Models\League;

class LeagueService
{
    public function reset(League $league): int
    {
        return $league->matches()->update([
            'finished_at' => null,
            'status' => MatchStatusEnum::UPCOMING,
            'home_team_score' => null,
            'away_team_score' => null,
        ]);
    }
}
