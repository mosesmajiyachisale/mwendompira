<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionTypeSeeder extends Seeder
{
    public function run()
    {
        $data = [

            [
                'id' => 1,
                'position_type_name' => 'Goalkeeper',
            ],

            [
                'id' => 2,
                'position_type_name' => 'Defender',
            ],

            [
                'id' => 3,
                'position_type_name' => 'Midfielder',
            ],

            [
                'id' => 4,
                'position_type_name' => 'Forward',
            ],

        ];


        $count = count($data);

        $bar = $this->command
            ->getOutput()
            ->createProgressBar($count);

        $bar->start();


        foreach ($data as $row) {

            DB::table('position_types')->updateOrInsert(
                [
                    'id' => $row['id'],
                ],
                [
                    'position_type_name' => $row['position_type_name'],
                    'updated_at' => now(),
                ]
            );

            $bar->advance();
        }


        $bar->finish();

        $this->command->info("");
    }
}