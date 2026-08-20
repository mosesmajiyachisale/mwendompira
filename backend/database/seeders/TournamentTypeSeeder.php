<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TournamentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'tournament_type_name' => 'League',
                'tournament_type_desc' => 'All teams play against each other over a season, with the winner decided by total points earned.',
            ],
            [
                'id' => 2,
                'tournament_type_name' => 'Knockout Cup',
                'tournament_type_desc' => 'Teams are eliminated after losing one or two matches against an opponent.',
            ],
            [
                'id' => 3,
                'tournament_type_name' => 'Super Cup',
                'tournament_type_desc' => 'Single match between winners of major competitions.',
            ],
            [
                'id' => 4,
                'tournament_type_name' => 'Playoff',
                'tournament_type_desc' => 'Knockout matches used to decide promotion or qualification.',
            ],
            [
                'id' => 5,
                'tournament_type_name' => 'Friendly',
                'tournament_type_desc' => 'Non-competitive match played for preparation or exhibition.',
            ],
        ];

        $count = count($data);

        $bar = $this->command->getOutput()->createProgressBar($count);
        $bar->start();

        foreach ($data as $row) {
            DB::table('tournament_types')->updateOrInsert(
                ['id' => $row['id']],
                $row
            );

            $bar->advance();
        }

        $bar->finish();

        $this->command->info('');
    }
}