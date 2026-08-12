<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlotSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            /*
            |--------------------------------------------------------------------------
            | HOME SLOTS
            |--------------------------------------------------------------------------
            */

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'LWB',
                'slot_name' => 'Left Wing Back',
                'grid_x' => 8,
                'grid_y' => 2,
                'slot_desc' => 'Left-sided wing-back position.',
                'position_id' => 104,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'LW',
                'slot_name' => 'Left Wing',
                'grid_x' => 12,
                'grid_y' => 2,
                'slot_desc' => 'Left-sided wide attacking position.',
                'position_id' => 110,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'LB',
                'slot_name' => 'Left Back',
                'grid_x' => 6,
                'grid_y' => 2,
                'slot_desc' => 'Left-sided full-back position.',
                'position_id' => 102,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'LWF',
                'slot_name' => 'Left Wide Forward',
                'grid_x' => 16,
                'grid_y' => 3,
                'slot_desc' => 'Left-sided wide forward position.',
                'position_id' => 111,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'LF',
                'slot_name' => 'Left Forward',
                'grid_x' => 17,
                'grid_y' => 5,
                'slot_desc' => 'Left-sided forward position.',
                'position_id' => 112,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'LCB',
                'slot_name' => 'Left Centre Back',
                'grid_x' => 6,
                'grid_y' => 6,
                'slot_desc' => 'Left-sided central defensive position.',
                'position_id' => 103,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'LDM',
                'slot_name' => 'Left Defensive Midfield',
                'grid_x' => 9,
                'grid_y' => 7,
                'slot_desc' => 'Left-sided defensive midfield position.',
                'position_id' => 106,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'LCM',
                'slot_name' => 'Left Central Midfield',
                'grid_x' => 12,
                'grid_y' => 7,
                'slot_desc' => 'Left-sided central midfield position.',
                'position_id' => 107,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'LAM',
                'slot_name' => 'Left Attacking Midfield',
                'grid_x' => 14,
                'grid_y' => 7,
                'slot_desc' => 'Left-sided attacking midfield position.',
                'position_id' => 109,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'LCF',
                'slot_name' => 'Left Centre Forward',
                'grid_x' => 16,
                'grid_y' => 7,
                'slot_desc' => 'Left-sided central attacking position.',
                'position_id' => 112,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'LST',
                'slot_name' => 'Left Striker',
                'grid_x' => 18,
                'grid_y' => 7,
                'slot_desc' => 'Left-sided striker position.',
                'position_id' => 114,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'GK',
                'slot_name' => 'Goalkeeper',
                'grid_x' => 2,
                'grid_y' => 9,
                'slot_desc' => 'Central goalkeeping position.',
                'position_id' => 101,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'SW',
                'slot_name' => 'Sweeper',
                'grid_x' => 5,
                'grid_y' => 9,
                'slot_desc' => 'Deep central defensive position.',
                'position_id' => 105,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'CDM',
                'slot_name' => 'Central Defensive Midfield',
                'grid_x' => 9,
                'grid_y' => 9,
                'slot_desc' => 'Central defensive midfield position.',
                'position_id' => 106,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'CM',
                'slot_name' => 'Central Midfield',
                'grid_x' => 12,
                'grid_y' => 9,
                'slot_desc' => 'Central midfield position.',
                'position_id' => 107,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'CAM',
                'slot_name' => 'Central Attacking Midfield',
                'grid_x' => 14,
                'grid_y' => 9,
                'slot_desc' => 'Central attacking midfield position.',
                'position_id' => 109,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'CF',
                'slot_name' => 'Centre Forward',
                'grid_x' => 16,
                'grid_y' => 9,
                'slot_desc' => 'Central attacking position.',
                'position_id' => 112,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'ST',
                'slot_name' => 'Striker',
                'grid_x' => 18,
                'grid_y' => 9,
                'slot_desc' => 'Central striker position.',
                'position_id' => 114,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'RCF',
                'slot_name' => 'Right Centre Forward',
                'grid_x' => 16,
                'grid_y' => 11,
                'slot_desc' => 'Right-sided central attacking position.',
                'position_id' => 112,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'RST',
                'slot_name' => 'Right Striker',
                'grid_x' => 18,
                'grid_y' => 11,
                'slot_desc' => 'Right-sided striker position.',
                'position_id' => 114,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'RCB',
                'slot_name' => 'Right Centre Back',
                'grid_x' => 6,
                'grid_y' => 12,
                'slot_desc' => 'Right-sided central defensive position.',
                'position_id' => 103,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'RDM',
                'slot_name' => 'Right Defensive Midfield',
                'grid_x' => 9,
                'grid_y' => 11,
                'slot_desc' => 'Right-sided defensive midfield position.',
                'position_id' => 106,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'RCM',
                'slot_name' => 'Right Central Midfield',
                'grid_x' => 12,
                'grid_y' => 11,
                'slot_desc' => 'Right-sided central midfield position.',
                'position_id' => 107,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'RAM',
                'slot_name' => 'Right Attacking Midfield',
                'grid_x' => 14,
                'grid_y' => 11,
                'slot_desc' => 'Right-sided attacking midfield position.',
                'position_id' => 109,
            ],
            

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'RM',
                'slot_name' => 'Right Attacking Midfield',
                'grid_x' => 12,
                'grid_y' => 13,
                'slot_desc' => 'Right-sided attacking midfield position.',
                'position_id' => 109,
            ],

            

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'LM',
                'slot_name' => 'Right Attacking Midfield',
                'grid_x' => 12,
                'grid_y' => 5,
                'slot_desc' => 'Right-sided attacking midfield position.',
                'position_id' => 109,
            ],


            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'RF',
                'slot_name' => 'Right Forward',
                'grid_x' => 17,
                'grid_y' => 13,
                'slot_desc' => 'Right-sided forward position.',
                'position_id' => 112,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'RB',
                'slot_name' => 'Right Back',
                'grid_x' => 6,
                'grid_y' => 16,
                'slot_desc' => 'Right-sided full-back position.',
                'position_id' => 102,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'RWF',
                'slot_name' => 'Right Wide Forward',
                'grid_x' => 16,
                'grid_y' => 15,
                'slot_desc' => 'Right-sided wide forward position.',
                'position_id' => 111,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'RWB',
                'slot_name' => 'Right Wing Back',
                'grid_x' => 8,
                'grid_y' => 16,
                'slot_desc' => 'Right-sided wing-back position.',
                'position_id' => 104,
            ],

            [
                'id' => null,
                'slot_side' => 'home',
                'slot_code' => 'RW',
                'slot_name' => 'Right Wing',
                'grid_x' => 12,
                'grid_y' => 16,
                'slot_desc' => 'Right-sided wide attacking position.',
                'position_id' => 110,
            ],
        ];

        $count = count($data);

        $bar = $this->command
            ->getOutput()
            ->createProgressBar($count);

        $bar->start();

        foreach ($data as $row) {
            DB::table('slots')->updateOrInsert(
                [
                    'slot_code' => $row['slot_code'],
                ],
                [
                    'slot_name' => $row['slot_name'],
                    'grid_x' => $row['grid_x'],
                    'grid_y' => $row['grid_y'],
                    'slot_desc' => $row['slot_desc'],
                    'position_id' => $row['position_id'],
                    'updated_at' => now(),
                ]
            );

            $bar->advance();
        }

        $bar->finish();

        $this->command->info('');
    }
}

