<?php

namespace App\Services;

use App\Enums\MatchStatusEnum;
use App\Models\League;
use App\Models\Match;
use Illuminate\Support\Collection;

class LeagueService
{
    protected TeamService $teamService;
    protected MatchService $matchService;

    public function __construct()
    {
        $this->teamService = app(TeamService::class);
        $this->matchService = app(MatchService::class);
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
        return $collection->sortByDesc('goal_diff')->sortByDesc('points');
    }

    public function getPredictions(League $league, int $week): Collection
    {
        /* Collect teams stats*/
        $teams = $this
            ->getStats($league, $week)
            ->groupBy('team.id')
            ->map(
                function ($item) {
                    return [
                        'points' => $item[0]['points'],
                        'team' => $item[0]['team'],
                    ];
                }
            )
            ->toArray();

        /* Get max points from the list of teams */
        $maxPoints = max(array_map(fn($item) => $item['points'], $teams));
        /* Calculate probable points for each team */
        $matches = Match::select('home_team_id', 'away_team_id')
            ->byLeague($league->getKey())
            ->afterWeek($week)
            ->upcoming()
            ->with('homeTeam', 'awayTeam')
            ->get();
        foreach ($matches as $match) {
            $percents = $this->matchService->predictWinningPercents(
                $match['homeTeam'],
                $match['awayTeam'],
            );
            $teams[$match['home_team_id']]['points'] += $percents[$match['home_team_id']] / 100 * 3;
            $teams[$match['away_team_id']]['points'] += $percents[$match['away_team_id']] / 100 * 3;
        }

        /* Get pretenders and losers with zero-chance for the championship */
        $pretenders = [];
        $losers = [];
        foreach ($teams as $key => $team) {
            /* If team has a theoretical chance to win*/
            if ($team['points'] + ($league->weeks - $week) * 3 >= $maxPoints) {
                $pretenders[] = $team;
                continue;
            }
            /* If team doesn't have any chances */
            $losers[$key] = $team;
            $losers[$key]['percent'] = 0;
        }

        /* Calculate probability for the pretenders. 0.001 for a very small chance */
        $totalPoints = array_sum(array_map(fn($item) => $item['points'] ?: 0.001, $pretenders));
        foreach ($pretenders as $key => $team) {
            $pretenders[$key]['percent'] = round(($team['points'] ?: 0.001) / $totalPoints * 100, 3);
        }

        return collect(array_merge($pretenders, $losers))->sortByDesc('percent');
    }
}
