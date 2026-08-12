<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            /*
            |--------------------------------------------------------------------------
            | Goalkeeper
            |--------------------------------------------------------------------------
            */

            [
                'id' => 101,
                'position_type_id' => 1,
                'position_code' => 'GK',
                'position_name' => 'Goalkeeper',
                'position_desc' => 'Player responsible for protecting the goal and using the hands within the penalty area.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Defenders
            |--------------------------------------------------------------------------
            */

            [
                'id' => 102,
                'position_type_id' => 2,
                'position_code' => 'FB',
                'position_name' => 'Full Back',
                'position_desc' => 'Wide defender operating primarily on either side of the defensive line.',
            ],

            [
                'id' => 103,
                'position_type_id' => 2,
                'position_code' => 'CB',
                'position_name' => 'Centre Back',
                'position_desc' => 'Central defender responsible for protecting the area in front of the goal.',
            ],

            [
                'id' => 104,
                'position_type_id' => 2,
                'position_code' => 'WB',
                'position_name' => 'Wing Back',
                'position_desc' => 'Wide defender combining defensive responsibilities with advanced attacking duties.',
            ],

            [
                'id' => 105,
                'position_type_id' => 2,
                'position_code' => 'SW',
                'position_name' => 'Sweeper',
                'position_desc' => 'Deep defender operating behind the main defensive line to cover space and defend against attacks.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Midfielders
            |--------------------------------------------------------------------------
            */

            [
                'id' => 106,
                'position_type_id' => 3,
                'position_code' => 'DM',
                'position_name' => 'Defensive Midfielder',
                'position_desc' => 'Midfielder positioned deeper to protect the defense, recover possession and support buildup.',
            ],

            [
                'id' => 107,
                'position_type_id' => 3,
                'position_code' => 'CM',
                'position_name' => 'Central Midfielder',
                'position_desc' => 'Midfielder operating centrally and contributing to possession, buildup, transition and attack.',
            ],

            [
                'id' => 108,
                'position_type_id' => 3,
                'position_code' => 'WM',
                'position_name' => 'Wide Midfielder',
                'position_desc' => 'Midfielder operating primarily in a wide area to provide width and support attack and defense.',
            ],

            [
                'id' => 109,
                'position_type_id' => 3,
                'position_code' => 'AM',
                'position_name' => 'Attacking Midfielder',
                'position_desc' => 'Advanced midfielder operating between midfield and the attacking line to create scoring opportunities.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Forwards
            |--------------------------------------------------------------------------
            */

            [
                'id' => 110,
                'position_type_id' => 4,
                'position_code' => 'WG',
                'position_name' => 'Winger',
                'position_desc' => 'Wide attacking player who provides width, creates chances and attacks from the flank.',
            ],

            [
                'id' => 111,
                'position_type_id' => 4,
                'position_code' => 'WF',
                'position_name' => 'Wide Forward',
                'position_desc' => 'Wide forward who combines wing play with direct attacking and goal-scoring responsibilities.',
            ],

            [
                'id' => 112,
                'position_type_id' => 4,
                'position_code' => 'CF',
                'position_name' => 'Centre Forward',
                'position_desc' => 'Central attacking player operating around the opposition penalty area.',
            ],

            [
                'id' => 113,
                'position_type_id' => 4,
                'position_code' => 'SS',
                'position_name' => 'Second Striker',
                'position_desc' => 'Attacking player operating behind or alongside the main striker.',
            ],

            [
                'id' => 114,
                'position_type_id' => 4,
                'position_code' => 'ST',
                'position_name' => 'Striker',
                'position_desc' => 'Primary central attacking player focused on scoring goals and leading the attack.',
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
                    'position_type_id' => $row['position_type_id'],
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