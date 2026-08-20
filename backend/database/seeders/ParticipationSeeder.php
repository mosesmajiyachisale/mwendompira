<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use App\Models\Participation;
use App\Models\Season;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Database\Seeder;

class ParticipationSeeder extends Seeder
{
    /**
     * Seed the database.
     */
    public function run(): void
    {
        $currentYear=date("Y");
        $season = Season::where('id', $currentYear)->firstOrFail();

        $tournament = Tournament::where('tournament_name','Super League')->firstOrFail();
        $teams = [
            'Big Bullets',
            'Mighty Wanderers',
            'Silver Strikers',
            'Blue Eagles',
            'Kamuzu Barracks',
            'Civil Service United',
            'Moyale Barracks',
            'Chitipa United',
            'Karonga United',
            'MAFCO FC',
            'Red Lions',
            'Chitipa United',
            'Dedza Dynamos',
            'Ekhaya FC',
            'LUANAR Mitundu',
            'Masters Security',
            'Creck Sporting'
        ];

        DB::table('participations')->truncate();

        $bar = $this->command->getOutput()->createProgressBar(count($teams));
        $bar->start();
        foreach ($teams as $teamName) {

            $team = Team::where('team_name', $teamName)->first();

            if (!$team) {
                $this->command->error("TEAM NOT FOUND: {$teamName}");
                continue;
            }

            Participation::updateOrCreate(
                [
                    'season_id'     => $season->id,
                    'tournament_id' => $tournament->id,
                    'team_id'       => $team->id,
                ],
                [
                    'is_active' => true,
                ]
            );
            $bar->advance();
        }
        $bar->finish();
        $this->command->info('');
    }
}