<?php

namespace App\Services;

use App\Enums\MatchStatusEnum;
use App\Models\League;
use Illuminate\Support\Collection;

class LeagueService
{
    protected TeamService $teamService;

    public function __construct()
    {
        $this->teamService = app(TeamService::class);
    }

    public function reset(League $league): int
    {
        return $league->matches()->update([
            'finished_at' => null,
            'status' => MatchStatusEnum::UPCOMING,
            'home_team_score' => null,
            'away_team_score' => null,
        ]);
    }

    public function getStats(League $league, ?int $untilWeek = null): Collection
    {
        $collection = collect([]);
        foreach ($league->teams as $team) {
            $matchesResults = $this->teamService->getTeamsMatchesResults($team, $league, $untilWeek);
            $goalStats = $this->teamService->getGoalsStats(
                $team,
                $matchesResults['wins']->merge($matchesResults['loses'])->merge($matchesResults['draws'])
            );
            $collection->push([
                'place' => '',
                'team' => $team,
                'points' => $this->teamService->getPointsByResults($matchesResults['wins']->count(), $matchesResults['draws']->count()),
                'wins' => $matchesResults['wins']->count(),
                'loses' => $matchesResults['loses']->count(),
                'draws' => $matchesResults['draws']->count(),
                'goal_diff' => $goalStats['diff'],
                'scored' => $goalStats['scored'],
                'missed' => $goalStats['missed'],
            ]);
        }
        return $collection->sortByDesc('points')->sortByDesc('goal_diff');
    }

    public function getPredictions(League $league, ?int $untilWeek = null): Collection
    {
        //todo
        $collection = collect([]);
        foreach ($league->teams as $team) {
            $collection->push([
                'team' => $team,
                'percent' => 1,
            ]);
        }
        return $collection->sortByDesc('points');
    }
}
