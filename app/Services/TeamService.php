<?php

namespace App\Services;

use App\Models\League;
use App\Models\Match;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class TeamService
{
    public function getTeamsMatchesResults(Team $team, League $league, ?int $untilWeek): array
    {
        return [
            'wins' => Match::byLeague($league->getKey())->untilWeek($untilWeek)->wins($team->getKey())->get(),
            'loses' => Match::byLeague($league->getKey())->untilWeek($untilWeek)->loses($team->getKey())->get(),
            'draws' => Match::byLeague($league->getKey())->untilWeek($untilWeek)->draws($team->getKey())->get()
        ];
    }

    public function getPointsByResults(int $wins, int $draws)
    {
        return $wins * 3 + $draws;
    }

    public function getGoalsStats(Team $team, Collection $matches): array
    {
        $scored = 0;
        $missed = 0;
        $matches->each(function ($match) use ($team, &$scored, &$missed) {
            $position = $match->getTeamPosition($team);
            $scored += $match->{$position . '_team_score'};
            $missed += $match->{($position === 'home' ? 'away' : 'home') . '_team_score'};
        });

        return [
            'scored' => $scored,
            'missed' => $missed,
            'diff' => $scored - $missed,
        ];
    }
}
