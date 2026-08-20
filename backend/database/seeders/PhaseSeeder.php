<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [

            [
                'id' => 1,
                'phase_name' => 'Pre-Match',
                'phase_code' => 'PRE',
                'min_minute' => 0,
                'max_minute' => 0,
            ],

            [
                'id' => 2,
                'phase_name' => 'First Half',
                'phase_code' => 'H1',
                'min_minute' => 0,
                'max_minute' => 45,
            ],

            [
                'id' => 3,
                'phase_name' => 'Half-Time',
                'phase_code' => 'HT',
                'min_minute' => 45,
                'max_minute' => 45,
            ],

            [
                'id' => 4,
                'phase_name' => 'Second Half',
                'phase_code' => 'H2',
                'min_minute' => 46,
                'max_minute' => 90,
            ],

            [
                'id' => 5,
                'phase_name' => 'Full Time',
                'phase_code' => 'FT',
                'min_minute' => 90,
                'max_minute' => 90,
            ],

            [
                'id' => 6,
                'phase_name' => 'Extra Time 1st Period',
                'phase_code' => 'ET1',
                'min_minute' => 91,
                'max_minute' => 105,
            ],

            [
                'id' => 7,
                'phase_name' => 'Extra Time Half-Time',
                'phase_code' => 'ETHT',
                'min_minute' => 105,
                'max_minute' => 105,
            ],

            [
                'id' => 8,
                'phase_name' => 'Extra Time 2nd Period',
                'phase_code' => 'ET2',
                'min_minute' => 106,
                'max_minute' => 120,
            ],

            [
                'id' => 9,
                'phase_name' => 'Penalty Shoot-Out',
                'phase_code' => 'PSO',
                'min_minute' => 121,
                'max_minute' => 121,
            ],

            [
                'id' => 10,
                'phase_name' => 'Post-Match',
                'phase_code' => 'POST',
                'min_minute' => 122,
                'max_minute' => 122,
            ],

        ];

        $count = count($data);

        $bar = $this->command
            ->getOutput()
            ->createProgressBar($count);

        $bar->start();

        foreach ($data as $row) {

            DB::table('phases')->updateOrInsert(
                ['id' => $row['id']],
                [
                    'phase_name' => $row['phase_name'],
                    'phase_code' => $row['phase_code'],
                    'min_minute' => $row['min_minute'],
                    'max_minute' => $row['max_minute'],
                    'updated_at' => now(),
                ]
            );

            $bar->advance();
        }

        $this->command->info("");

        $bar->finish();
    }
}