<?php

namespace Database\Seeders;

use App\Models\League;
use App\Services\MatchScheduleService;
use App\Services\MatchService;
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
        foreach (League::all() as $league) {
            app(MatchScheduleService::class)->scheduleLeague($league);
            foreach ($league->matches as $match) {
                app(MatchService::class)->simulate($match);
            }
        }
    }
}
