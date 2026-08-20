<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StageSeeder extends Seeder
{
    public function run()
    {
        $data = [

            /*
            |--------------------------------------------------------------------------
            | League has no stages
            |--------------------------------------------------------------------------
            */


            /*
            |--------------------------------------------------------------------------
            | Knockout Cup
            |--------------------------------------------------------------------------
            */

            [
                'id' => 201,
                'stage_name' => 'Group Stage',
                'stage_code' => 'GROUP',
                'stage_desc' => 'Teams compete in groups with the best-performing teams progressing to the knockout stage.',
                'tournament_type_id' => 2,
            ],

            [
                'id' => 202,
                'stage_name' => 'Round of 32',
                'stage_code' => 'R32',
                'stage_desc' => 'Knockout round involving 32 teams, with winners progressing to the Round of 16.',
                'tournament_type_id' => 2,
            ],

            [
                'id' => 203,
                'stage_name' => 'Round of 16',
                'stage_code' => 'R16',
                'stage_desc' => 'Knockout round involving 16 teams, with winners progressing to the quarter-finals.',
                'tournament_type_id' => 2,
            ],

            [
                'id' => 204,
                'stage_name' => 'Quarter-Finals',
                'stage_code' => 'QF',
                'stage_desc' => 'Knockout round involving eight teams, with winners progressing to the semi-finals.',
                'tournament_type_id' => 2,
            ],

            [
                'id' => 205,
                'stage_name' => 'Semi-Finals',
                'stage_code' => 'SF',
                'stage_desc' => 'Knockout round involving four teams, with winners progressing to the final.',
                'tournament_type_id' => 2,
            ],

            [
                'id' => 206,
                'stage_name' => 'Third Place',
                'stage_code' => '3P',
                'stage_desc' => 'Match between the losing teams from the semi-finals to determine third place.',
                'tournament_type_id' => 2,
            ],

            [
                'id' => 207,
                'stage_name' => 'Final',
                'stage_code' => 'F',
                'stage_desc' => 'Final match that determines the tournament winner.',
                'tournament_type_id' => 2,
            ],


            /*
            |--------------------------------------------------------------------------
            | Super Cup
            |--------------------------------------------------------------------------
            */
            
            [
                'id' => 301,
                'stage_name' => 'Quarter-Finals',
                'stage_code' => 'QF',
                'stage_desc' => 'Knockout round involving eight teams, with winners progressing to the semi-finals.',
                'tournament_type_id' => 3,
            ],

            [
                'id' => 302,
                'stage_name' => 'Semi-Finals',
                'stage_code' => 'SF',
                'stage_desc' => 'Knockout round involving four teams, with winners progressing to the final.',
                'tournament_type_id' => 3,
            ],

            [
                'id' => 303,
                'stage_name' => 'Third Place',
                'stage_code' => '3P',
                'stage_desc' => 'Match between the losing teams from the semi-finals to determine third place.',
                'tournament_type_id' => 3,
            ],

            [
                'id' => 304,
                'stage_name' => 'Final',
                'stage_code' => 'F',
                'stage_desc' => 'Single final match between the winners of major tournaments.',
                'tournament_type_id' => 3,
            ],


            /*
            |--------------------------------------------------------------------------
            | Playoff
            |--------------------------------------------------------------------------
            */
            
            [
                'id' => 401,
                'stage_name' => 'Preliminary Round',
                'stage_code' => 'PRELIM',
                'stage_desc' => 'Opening playoff round used to reduce the number of participating teams before the main playoff rounds.',
                'tournament_type_id' => 4,
            ],
            
            [
                'id' => 402,
                'stage_name' => 'Round 1',
                'stage_code' => 'R1',
                'stage_desc' => 'First main round of playoff matches used to determine which teams progress to the next stage.',
                'tournament_type_id' => 4,
            ],
            
            [
                'id' => 403,
                'stage_name' => 'Round 2',
                'stage_code' => 'R2',
                'stage_desc' => 'Second round of playoff matches used to determine the teams progressing to the final stages.',
                'tournament_type_id' => 4,
            ],
            
            [
                'id' => 404,
                'stage_name' => 'Semi-Finals',
                'stage_code' => 'SF',
                'stage_desc' => 'Semi-final playoff matches between the remaining teams, with winners progressing to the final.',
                'tournament_type_id' => 4,
            ],
            
            [
                'id' => 405,
                'stage_name' => 'Third Place',
                'stage_code' => '3P',
                'stage_desc' => 'Playoff match between the losing semi-finalists to determine third place.',
                'tournament_type_id' => 4,
            ],
            
            [
                'id' => 406,
                'stage_name' => 'Final',
                'stage_code' => 'F',
                'stage_desc' => 'Final playoff match used to determine the playoff winner or final qualification outcome.',
                'tournament_type_id' => 4,
            ],



        ];


        $count = count($data);

        $bar = $this->command
            ->getOutput()
            ->createProgressBar($count);

        $bar->start();


        foreach ($data as $row) {

            DB::table('stages')->updateOrInsert(
                ['id' => $row['id']],
                [
                    'stage_name' => $row['stage_name'],
                    'stage_code' => $row['stage_code'],
                    'stage_desc' => $row['stage_desc'],
                    'tournament_type_id' => $row['tournament_type_id'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            $bar->advance();
        }

        $bar->finish();
        $this->command->info("");
    }
}