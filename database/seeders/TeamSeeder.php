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
        $leagues = League::all();

        foreach ($leagues as $league) {
            Team::factory(4)->create(['league_id' => $league->getKey()]);
        }
    }
}
