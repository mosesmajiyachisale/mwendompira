<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TournamentSeeder extends Seeder
{
    public function run(): void
    {
        $tournaments = [
            [
                'tournament_name' => 'Super League',
                'tournament_type_id' => 1,
            ],
            [
                'tournament_name' => 'National Football League',
                'tournament_type_id' => 1,
            ],
            [
                'tournament_name' => 'Presidential Initiative Cup',
                'tournament_type_id' => 2,
            ],
            [
                'tournament_name' => 'Charity Shield',
                'tournament_type_id' => 3,
            ],
            [
                'tournament_name' => 'Charity Match',
                'tournament_type_id' => 5,
            ],
            
            [
                'tournament_name' => 'Bonanza',
                'tournament_type_id' => 3,
            ],
            [
                'tournament_name' => 'Friendly Game',
                'tournament_type_id' => 5,
            ],
            [
                'tournament_name' => 'Northern Region Football League',
                'tournament_type_id' => 1,
            ],
            [
                'tournament_name' => 'Central Region Football League',
                'tournament_type_id' => 1,
            ],
            [
                'tournament_name' => 'Southern Region Football League',
                'tournament_type_id' => 1,
            ],
        ];

        $bar = $this->command->getOutput()->createProgressBar(count($tournaments));
        $bar->start();

        foreach ($tournaments as $tournament) {
            DB::table('tournaments')->updateOrInsert(
                [
                    'tournament_name' => $tournament['tournament_name']
                ],
                $tournament
            );

            $bar->advance();
        }

        $bar->finish();
        $this->command->info('');
    }
}