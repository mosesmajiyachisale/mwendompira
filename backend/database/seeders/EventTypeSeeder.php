<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventTypeSeeder extends Seeder
{
    public function run()
    {
        $data = [

            [
                'id' => 1,
                'event_type_name' => 'Possession',
                'event_type_desc' => 'Events involving ball control, passing, recovery and retention.',
            ],

            [
                'id' => 2,
                'event_type_name' => 'Attack',
                'event_type_desc' => 'Events involving attempts to score, create chances and advance attacks.',
            ],

            [
                'id' => 3,
                'event_type_name' => 'Defense',
                'event_type_desc' => 'Events involving actions used to stop or disrupt opposition attacks.',
            ],

            [
                'id' => 4,
                'event_type_name' => 'Goalkeeping',
                'event_type_desc' => 'Events involving goalkeeper actions and interventions.',
            ],

            [
                'id' => 5,
                'event_type_name' => 'Set Piece',
                'event_type_desc' => 'Events originating from structured restarts or stationary-ball situations.',
            ],

            [
                'id' => 6,
                'event_type_name' => 'Disciplinary',
                'event_type_desc' => 'Events involving fouls, cards, injuries and disciplinary actions.',
            ],

            [
                'id' => 7,
                'event_type_name' => 'Administration',
                'event_type_desc' => 'Events concerning match administration, periods, substitutions and VAR.',
            ],

        ];

        $count = count($data);

        $bar = $this->command
            ->getOutput()
            ->createProgressBar($count);

        $bar->start();

        foreach ($data as $row) {

            DB::table('event_types')->updateOrInsert(
                [
                    'id' => $row['id'],
                ],
                [
                    'event_type_name' => $row['event_type_name'],
                    'event_type_desc' => $row['event_type_desc'],
                    'updated_at' => now(),
                ]
            );

            $bar->advance();
        }

        $bar->finish();

        $this->command->info("");
    }
}