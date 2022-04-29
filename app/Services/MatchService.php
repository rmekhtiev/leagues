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
        $winnerPosition = $match->getTeamPosition($winner);
        $loserPosition = $match->getTeamPosition($loser);
        $loserScore = rand(0, 2);
        $match->{$loserPosition . '_team_score'} = $loserScore;
        $match->{$winnerPosition . '_team_score'} = $loserScore + rand(1, 3);
        $match->finished_at = $match->started_at->addMinute();
        $match->status = MatchStatusEnum::FINISHED;
        $match->save();
    }

    public function predictWinner(Team $team, Team $opponentTeam): Team
    {
        // todo draw probability
        $totalPower = $team->power + $opponentTeam->power;
        $teamKey = $this->randomizeService->getRandomWeightedElement([
            $team->getKey() => $this->randomizeService->calculatePercentage($team->power, $totalPower),
            $opponentTeam->getKey() => $this->randomizeService->calculatePercentage($opponentTeam->power, $totalPower),
        ]);
        return $team->getKey() === $teamKey ? $team : $opponentTeam;
    }

    public function createHomeAwayMatch(League $league, Team $team, Team $opponentTeam, Carbon $startedAt, int $weeksOffset)
    {
        Match::create([
            'home_team_id' => $team->getKey(),
            'away_team_id' => $opponentTeam->getKey(),
            'league_id' => $league->getKey(),
            'started_at' => $startedAt
        ]);

        Match::create([
            'home_team_id' => $opponentTeam->getKey(),
            'away_team_id' => $team->getKey(),
            'league_id' => $league->getKey(),
            'started_at' => $startedAt->addWeeks($weeksOffset)
        ]);
    }
}
