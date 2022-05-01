<?php

namespace App\Services;

use Carbon\Carbon;

class MatchScheduleService
{
    public function scheduleLeague($league)
    {
        $teams = $league->teams;
        for ($round = 0; $round < count($teams) - 1; ++$round) {
            $this->createPairs($league, $teams, $round);
            $teams = $this->rotateTeams($teams);
        }
    }

    public function rotateTeams($teams)
    {
        $result = $teams;
        $tmp = $result[count($result) - 1];
        for ($i = count($result) - 1; $i > 1; --$i) {
            $result[$i] = $result[$i - 1];
        }
        $result[1] = $tmp;
        return $result;

    }

    public function createPairs($league, $teams, $round)
    {
        for ($i = 0; $i < count($teams) / 2; ++$i) {
            $opponent = count($teams) - 1 - $i;
//            $secondRound = $weeks / 2 + $round + 1;
            $secondRound = $teams->count() * 2 - 2 - $round;
            app(MatchService::class)
                ->createHomeAwayMatch(
                    $league,
                    $teams[$i],
                    $teams[$opponent],
                    Carbon::now()->addWeeks($round),
                    $round + 1,
                    $secondRound - $round - 1
                );
        }
    }
}
