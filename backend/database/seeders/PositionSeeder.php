<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'position_name' => 'Goalkeeper',
                'position_code' => 'GK',
                'position_desc' => 'The player responsible for protecting the goal and preventing the opposition from scoring.',
            ],
            [
                'id' => 2,
                'position_name' => 'Defender',
                'position_code' => 'DEF',
                'position_desc' => 'Players primarily responsible for preventing the opposition from creating and scoring goals.',
            ],
            [
                'id' => 3,
                'position_name' => 'Midfielder',
                'position_code' => 'MID',
                'position_desc' => 'Players who operate between defence and attack and contribute to both defensive and attacking play.',
            ],
            [
                'id' => 4,
                'position_name' => 'Forward',
                'position_code' => 'FWD',
                'position_desc' => 'Players primarily responsible for attacking, creating scoring opportunities and scoring goals.',
            ],
        ];

        $count = count($data);

        $bar = $this->command
            ->getOutput()
            ->createProgressBar($count);

        $bar->start();

        foreach ($data as $row) {

            DB::table('positions')->updateOrInsert(
                [
                    'id' => $row['id'],
                ],
                [
                    'position_code' => $row['position_code'],
                    'position_name' => $row['position_name'],
                    'position_desc' => $row['position_desc'],
                    'updated_at' => now(),
                ]
            );

            $bar->advance();
        }

        $bar->finish();

        $this->command->info("");
    }
}