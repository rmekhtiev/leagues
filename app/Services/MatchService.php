<?php

namespace App\Services;

use App\Enums\MatchStatusEnum;
use App\Models\League;
use App\Models\Match;
use App\Models\Team;
use Carbon\Carbon;

class MatchService
{
    protected RandomizeService $randomizeService;

    public function __construct()
    {
        $this->randomizeService = app(RandomizeService::class);
    }

    public function simulate(Match $match)
    {
        $winner = $this->predictWinner($match->homeTeam, $match->awayTeam);
        $loser = $match->getOpponentTeam($winner);
        $loserScore = rand(0, 2);
        $match->update([
            $match->getTeamPosition($loser) . '_team_score' => $loserScore,
            $match->getTeamPosition($winner) . '_team_score' => $loserScore + rand(1, 3),
            'finished_at' => $match->started_at->addMinute(),
            'status' => MatchStatusEnum::FINISHED,
        ]);
    }

    public function predictWinningPercents(Team $team, Team $opponentTeam): array
    {
        $totalPower = $team->power + $opponentTeam->power;
        return [
            $team->getKey() =>  $this->randomizeService->calculatePercentage($team->power, $totalPower),
            $opponentTeam->getKey() => $this->randomizeService->calculatePercentage($opponentTeam->power, $totalPower),
        ];
    }

    public function predictWinner(Team $team, Team $opponentTeam): Team
    {
        $percents = $this->predictWinningPercents($team, $opponentTeam);

        $teamKey = $this->randomizeService->getRandomWeightedElement([
            $team->getKey() => $percents[$team->getKey()],
            $opponentTeam->getKey() => $percents[$opponentTeam->getKey()],
        ]);
        return $team->getKey() === $teamKey ? $team : $opponentTeam;
    }

    public function createHomeAwayMatch(League $league, Team $team, Team $opponentTeam, Carbon $startedAt, int $week, int $weeksOffset)
    {
        Match::create([
            'home_team_id' => $team->getKey(),
            'away_team_id' => $opponentTeam->getKey(),
            'league_id' => $league->getKey(),
            'started_at' => $startedAt,
            'week' => $week,
        ]);

        Match::create([
            'home_team_id' => $opponentTeam->getKey(),
            'away_team_id' => $team->getKey(),
            'league_id' => $league->getKey(),
            'started_at' => $startedAt->addWeeks($weeksOffset),
            'week' => $week + $weeksOffset,
        ]);
    }
}
