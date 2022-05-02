<?php

namespace Database\Seeders;

use App\Models\League;
use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $league = League::find(1);

        Team::create(['league_id' => $league->getKey(), 'title' => 'Manchester United', 'power' => 70]);
        Team::create(['league_id' => $league->getKey(), 'title' => 'Liverpool', 'power' => 80]);
        Team::create(['league_id' => $league->getKey(), 'title' => 'Real Madrid', 'power' => 75]);
        Team::create(['league_id' => $league->getKey(), 'title' => 'Bayern Munich', 'power' => 70]);
    }
}
