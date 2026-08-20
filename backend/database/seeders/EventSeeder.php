<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    public function run()
    {
        $data = [

            /*
            |--------------------------------------------------------------------------
            | Possession
            |--------------------------------------------------------------------------
            */

            [
                'id' => 1,
                'event_type_id' => 1,
                'event_name' => 'Pass',
                'event_code' => 'PASS',
                'event_desc' => 'A completed or attempted pass between players.',
            ],

            [
                'id' => 2,
                'event_type_id' => 1,
                'event_name' => 'Key Pass',
                'event_code' => 'KEY_PASS',
                'event_desc' => 'A pass that directly creates a significant scoring opportunity.',
            ],

            [
                'id' => 3,
                'event_type_id' => 1,
                'event_name' => 'Ball Recovery',
                'event_code' => 'BALL_RECOVERY',
                'event_desc' => 'A player regains possession of the ball for their team.',
            ],

            [
                'id' => 4,
                'event_type_id' => 1,
                'event_name' => 'Possession Lost',
                'event_code' => 'POSSESSION_LOST',
                'event_desc' => 'A player loses possession of the ball.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Attack
            |--------------------------------------------------------------------------
            */

            [
                'id' => 5,
                'event_type_id' => 2,
                'event_name' => 'Goal',
                'event_code' => 'GOAL',
                'event_desc' => 'A goal is scored.',
            ],

            [
                'id' => 6,
                'event_type_id' => 2,
                'event_name' => 'Own Goal',
                'event_code' => 'OWN_GOAL',
                'event_desc' => 'A player scores a goal into their own team\'s goal.',
            ],

            [
                'id' => 7,
                'event_type_id' => 2,
                'event_name' => 'Shot',
                'event_code' => 'SHOT',
                'event_desc' => 'A player attempts to score by shooting at goal.',
            ],

            [
                'id' => 8,
                'event_type_id' => 2,
                'event_name' => 'Shot on Target',
                'event_code' => 'SHOT_ON_TARGET',
                'event_desc' => 'A shot directed towards the goal that is on target.',
            ],

            [
                'id' => 9,
                'event_type_id' => 2,
                'event_name' => 'Shot Off Target',
                'event_code' => 'SHOT_OFF_TARGET',
                'event_desc' => 'A shot that misses the goal without being blocked.',
            ],

            [
                'id' => 10,
                'event_type_id' => 2,
                'event_name' => 'Blocked Shot',
                'event_code' => 'BLOCKED_SHOT',
                'event_desc' => 'A shot prevented from reaching the goal by an opposing player.',
            ],

            [
                'id' => 11,
                'event_type_id' => 2,
                'event_name' => 'Assist',
                'event_code' => 'ASSIST',
                'event_desc' => 'A pass or other attacking action directly contributing to a goal.',
            ],

            [
                'id' => 12,
                'event_type_id' => 2,
                'event_name' => 'Offside',
                'event_code' => 'OFFSIDE',
                'event_desc' => 'An attacking player is penalized for being in an offside position while involved in active play.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Defense
            |--------------------------------------------------------------------------
            */

            [
                'id' => 13,
                'event_type_id' => 3,
                'event_name' => 'Tackle',
                'event_code' => 'TACKLE',
                'event_desc' => 'A defensive challenge made to win or dispossess an opponent of the ball.',
            ],

            [
                'id' => 14,
                'event_type_id' => 3,
                'event_name' => 'Interception',
                'event_code' => 'INTERCEPTION',
                'event_desc' => 'A player intercepts an opposition pass or attacking play.',
            ],

            [
                'id' => 15,
                'event_type_id' => 3,
                'event_name' => 'Clearance',
                'event_code' => 'CLEARANCE',
                'event_desc' => 'A defensive action that removes the ball from a dangerous area.',
            ],

            [
                'id' => 16,
                'event_type_id' => 3,
                'event_name' => 'Block',
                'event_code' => 'BLOCK',
                'event_desc' => 'A defensive action that prevents a shot, pass or attacking attempt from reaching its intended target.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Goalkeeping
            |--------------------------------------------------------------------------
            */

            [
                'id' => 17,
                'event_type_id' => 4,
                'event_name' => 'Save',
                'event_code' => 'SAVE',
                'event_desc' => 'A goalkeeper prevents a shot from resulting in a goal.',
            ],

            [
                'id' => 18,
                'event_type_id' => 4,
                'event_name' => 'Penalty Save',
                'event_code' => 'PENALTY_SAVE',
                'event_desc' => 'A goalkeeper saves a penalty kick.',
            ],

            [
                'id' => 19,
                'event_type_id' => 4,
                'event_name' => 'Goalkeeper Distribution',
                'event_code' => 'GK_DISTRIBUTION',
                'event_desc' => 'A goalkeeper distributes the ball through a kick, throw or pass.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Set Piece
            |--------------------------------------------------------------------------
            */

            [
                'id' => 20,
                'event_type_id' => 5,
                'event_name' => 'Corner',
                'event_code' => 'CORNER',
                'event_desc' => 'A corner kick is awarded and taken.',
            ],

            [
                'id' => 21,
                'event_type_id' => 5,
                'event_name' => 'Free Kick',
                'event_code' => 'FREE_KICK',
                'event_desc' => 'A free kick is awarded and taken.',
            ],

            [
                'id' => 22,
                'event_type_id' => 5,
                'event_name' => 'Penalty',
                'event_code' => 'PENALTY',
                'event_desc' => 'A penalty kick is awarded or taken.',
            ],

            [
                'id' => 23,
                'event_type_id' => 5,
                'event_name' => 'Goal Kick',
                'event_code' => 'GOAL_KICK',
                'event_desc' => 'A goal kick is awarded and taken.',
            ],

            [
                'id' => 24,
                'event_type_id' => 5,
                'event_name' => 'Throw In',
                'event_code' => 'THROW_IN',
                'event_desc' => 'A throw-in is awarded and taken.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Disciplinary
            |--------------------------------------------------------------------------
            */

            [
                'id' => 25,
                'event_type_id' => 6,
                'event_name' => 'Yellow Card',
                'event_code' => 'YELLOW_CARD',
                'event_desc' => 'A player receives a yellow card.',
            ],

            [
                'id' => 26,
                'event_type_id' => 6,
                'event_name' => 'Second Yellow',
                'event_code' => 'SECOND_YELLOW',
                'event_desc' => 'A player receives a second yellow card and is sent off.',
            ],

            [
                'id' => 27,
                'event_type_id' => 6,
                'event_name' => 'Red Card',
                'event_code' => 'RED_CARD',
                'event_desc' => 'A player receives a direct red card and is sent off.',
            ],

            [
                'id' => 28,
                'event_type_id' => 6,
                'event_name' => 'Foul',
                'event_code' => 'FOUL',
                'event_desc' => 'A player commits a foul against an opponent.',
            ],

            [
                'id' => 29,
                'event_type_id' => 6,
                'event_name' => 'Injury',
                'event_code' => 'INJURY',
                'event_desc' => 'A player suffers an injury during the match.',
            ],


            /*
            |--------------------------------------------------------------------------
            | Administration
            |--------------------------------------------------------------------------
            */

            [
                'id' => 30,
                'event_type_id' => 7,
                'event_name' => 'Kick Off',
                'event_code' => 'KICK_OFF',
                'event_desc' => 'The match or a period of play begins.',
            ],

            [
                'id' => 31,
                'event_type_id' => 7,
                'event_name' => 'Half Time',
                'event_code' => 'HALF_TIME',
                'event_desc' => 'The first half ends and the match enters the half-time interval.',
            ],

            [
                'id' => 32,
                'event_type_id' => 7,
                'event_name' => 'Full Time',
                'event_code' => 'FULL_TIME',
                'event_desc' => 'Regulation match time ends.',
            ],

            [
                'id' => 33,
                'event_type_id' => 7,
                'event_name' => 'Extra Time Start',
                'event_code' => 'EXTRA_TIME_START',
                'event_desc' => 'Extra time begins.',
            ],

            [
                'id' => 34,
                'event_type_id' => 7,
                'event_name' => 'Extra Time End',
                'event_code' => 'EXTRA_TIME_END',
                'event_desc' => 'Extra time ends.',
            ],

            [
                'id' => 35,
                'event_type_id' => 7,
                'event_name' => 'Substitution',
                'event_code' => 'SUBSTITUTION',
                'event_desc' => 'A player is replaced by another player.',
            ],

            [
                'id' => 36,
                'event_type_id' => 7,
                'event_name' => 'VAR Review',
                'event_code' => 'VAR_REVIEW',
                'event_desc' => 'The Video Assistant Referee reviews a match incident.',
            ],

            [
                'id' => 37,
                'event_type_id' => 7,
                'event_name' => 'VAR Decision',
                'event_code' => 'VAR_DECISION',
                'event_desc' => 'A decision is made following a VAR review.',
            ],

        ];


        $count = count($data);

        $bar = $this->command
            ->getOutput()
            ->createProgressBar($count);

        $bar->start();


        foreach ($data as $row) {

            DB::table('events')->updateOrInsert(
                [
                    'id' => $row['id'],
                ],
                [
                    'event_type_id' => $row['event_type_id'],
                    'event_name' => $row['event_name'],
                    'event_code' => $row['event_code'],
                    'event_desc' => $row['event_desc'],
                    'updated_at' => now(),
                ]
            );

            $bar->advance();
        }


        $bar->finish();

        $this->command->info("");
    }
}