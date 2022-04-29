<?php

namespace Database\Seeders;

use App\Models\League;
use App\Models\Match;
use Illuminate\Database\Seeder;

class MatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //todo weeks
        $leagues = League::all();

        foreach ($leagues as $league) {
           foreach ($league->teams as $team) {
               $otherTeams = $league->teams()->where('id', '!=', $team->id)->get();
               foreach ($otherTeams as $awayTeam) {
                   Match::create([
                      'home_team_id' => $team->getKey(),
                      'away_team_id' => $awayTeam->getKey(),
                      'league_id' => $league->getKey(),
                   ]);
               }
           }
        }
    }
}
