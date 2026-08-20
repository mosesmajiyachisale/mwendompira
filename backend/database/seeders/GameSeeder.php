<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Participation;
use App\Models\Season;
use App\Models\Tournament;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | SEASON
        |--------------------------------------------------------------------------
        */

        $currentYear = date('Y');

        $season = Season::where('id', '<=', $currentYear)
            ->orderBy('id', 'desc')
            ->first();

        if (!$season) {

            $this->command->error(
                'No season found.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | TOURNAMENT
        |--------------------------------------------------------------------------
        */

        $tournament = Tournament::where(
            'tournament_name',
            'Super League'
        )->first();

        if (!$tournament) {

            $this->command->error(
                'Super League tournament not found.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | PARTICIPATING TEAMS
        |--------------------------------------------------------------------------
        |
        | Teams are extracted directly from participations.
        |
        | Only teams registered for this particular
        | season and tournament will receive fixtures.
        |
        */

        $teams = Participation::query()

            ->where(
                'season_id',
                $season->id
            )

            ->where(
                'tournament_id',
                $tournament->id
            )

            ->pluck('team_id')

            ->unique()

            ->values()

            ->all();


        /*
        |--------------------------------------------------------------------------
        | TEAM COUNT
        |--------------------------------------------------------------------------
        */

        $teamCount = count($teams);

        if ($teamCount < 2) {

            $this->command->error(
                'At least two participating teams are required.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | DISPLAY INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->command->newLine();

        $this->command->info(
            '=========================================='
        );

        $this->command->info(
            'GAME SEEDER'
        );

        $this->command->info(
            '=========================================='
        );

        $this->command->info(
            'Season: ' . $season->season_code
        );

        $this->command->info(
            'Tournament: ' . $tournament->tournament_name
        );

        $this->command->info(
            'Participating teams: ' . $teamCount
        );


        /*
        |--------------------------------------------------------------------------
        | SHUFFLE TEAMS
        |--------------------------------------------------------------------------
        |
        | Randomising the initial order prevents the same teams from
        | always receiving the same opening fixtures.
        |
        */

        shuffle($teams);


        /*
        |--------------------------------------------------------------------------
        | GENERATE FIRST HALF
        |--------------------------------------------------------------------------
        |
        | Every team plays every other team exactly once.
        |
        | If there are N teams:
        |
        | Match days = N - 1
        |
        */

        $firstHalf = $this->generateRoundRobinRounds(
            $teams
        );


        /*
        |--------------------------------------------------------------------------
        | GENERATE SECOND HALF
        |--------------------------------------------------------------------------
        |
        | The second half starts ONLY after every team has completed
        | the first half against every other team.
        |
        | Example:
        |
        | First half:
        |
        | A vs B
        |
        | Second half:
        |
        | B vs A
        |
        */

        $secondHalf = $this->generateReverseRounds(
            $firstHalf
        );


        /*
        |--------------------------------------------------------------------------
        | COMBINE BOTH HALVES
        |--------------------------------------------------------------------------
        |
        | First half:
        | Match Day 1 ... N-1
        |
        | Second half:
        | Match Day N ... 2(N-1)
        |
        */

        $allRounds = array_merge(
            $firstHalf,
            $secondHalf
        );


        /*
        |--------------------------------------------------------------------------
        | CREATE FIXTURES
        |--------------------------------------------------------------------------
        */

        $this->createFixtures(
            $allRounds,
            $season->id,
            $tournament->id
        );


        /*
        |--------------------------------------------------------------------------
        | EXPECTED GAME COUNT
        |--------------------------------------------------------------------------
        |
        | Double round robin:
        |
        | N × (N - 1)
        |
        */

        $expectedGames =
            $teamCount *
            ($teamCount - 1);


        /*
        |--------------------------------------------------------------------------
        | ACTUAL GAME COUNT
        |--------------------------------------------------------------------------
        */

        $gameCount = Game::query()

            ->where(
                'season_id',
                $season->id
            )

            ->where(
                'tournament_id',
                $tournament->id
            )

            ->count();


        /*
        |--------------------------------------------------------------------------
        | MATCH DAY COUNT
        |--------------------------------------------------------------------------
        */

        $matchDayCount =
            ($teamCount % 2 === 0)
                ? ($teamCount - 1) * 2
                : $teamCount * 2;


        /*
        |--------------------------------------------------------------------------
        | RESULT
        |--------------------------------------------------------------------------
        */

        $this->command->newLine();

        $this->command->info(
            '=========================================='
        );

        $this->command->info(
            'GAME SEEDING COMPLETED'
        );

        $this->command->info(
            '=========================================='
        );

        $this->command->info(
            "Expected games: {$expectedGames}"
        );

        $this->command->info(
            "Games in database: {$gameCount}"
        );

        $this->command->info(
            "Match days: {$matchDayCount}"
        );

        $this->command->info(
            '=========================================='
        );
    }


    /**
     * Generate the first half of the round robin.
     *
     * Every team plays every other team exactly once.
     *
     * Example with 4 teams:
     *
     * Match Day 1
     * A vs D
     * B vs C
     *
     * Match Day 2
     * D vs C
     * A vs B
     *
     * Match Day 3
     * B vs D
     * C vs A
     */
    private function generateRoundRobinRounds(
        array $teams
    ): array {

        /*
        |--------------------------------------------------------------------------
        | ODD NUMBER OF TEAMS
        |--------------------------------------------------------------------------
        |
        | Add a BYE slot.
        |
        | Example:
        |
        | A B C D E
        |
        | becomes:
        |
        | A B C D E BYE
        |
        */

        if (count($teams) % 2 !== 0) {

            $teams[] = null;
        }


        /*
        |--------------------------------------------------------------------------
        | VARIABLES
        |--------------------------------------------------------------------------
        */

        $teamCount = count($teams);

        $roundCount = $teamCount - 1;

        $rounds = [];


        /*
        |--------------------------------------------------------------------------
        | CIRCLE METHOD
        |--------------------------------------------------------------------------
        */

        for (
            $round = 0;
            $round < $roundCount;
            $round++
        ) {

            $fixtures = [];


            /*
            |--------------------------------------------------------------------------
            | CREATE FIXTURES FOR THIS MATCH DAY
            |--------------------------------------------------------------------------
            */

            for (
                $i = 0;
                $i < ($teamCount / 2);
                $i++
            ) {

                $home = $teams[$i];

                $away = $teams[
                    $teamCount - 1 - $i
                ];


                /*
                |--------------------------------------------------------------------------
                | BYE
                |--------------------------------------------------------------------------
                */

                if (
                    $home === null ||
                    $away === null
                ) {

                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | HOME / AWAY BALANCING
                |--------------------------------------------------------------------------
                |
                | Alternate the home team between rounds.
                |
                */

                if ($round % 2 === 0) {

                    $fixtures[] = [

                        'home_team_id' => $home,

                        'away_team_id' => $away,

                    ];

                } else {

                    $fixtures[] = [

                        'home_team_id' => $away,

                        'away_team_id' => $home,

                    ];
                }
            }


            /*
            |--------------------------------------------------------------------------
            | SAVE MATCH DAY
            |--------------------------------------------------------------------------
            */

            $rounds[] = $fixtures;


            /*
            |--------------------------------------------------------------------------
            | ROTATE TEAMS
            |--------------------------------------------------------------------------
            |
            | Keep the first team fixed.
            |
            | Rotate all remaining teams.
            |
            */

            $fixed = $teams[0];

            $rotating = array_slice(
                $teams,
                1
            );


            $last = array_pop(
                $rotating
            );


            array_unshift(
                $rotating,
                $last
            );


            $teams = array_merge(
                [
                    $fixed
                ],
                $rotating
            );
        }


        return $rounds;
    }


    /**
     * Generate reverse fixtures.
     *
     * Every home team becomes the away team
     * and every away team becomes the home team.
     *
     * The order of the match days remains the same.
     */
    private function generateReverseRounds(
        array $firstHalf
    ): array {

        $secondHalf = [];


        foreach (
            $firstHalf as $round
        ) {

            $reverseRound = [];


            foreach (
                $round as $fixture
            ) {

                $reverseRound[] = [

                    'home_team_id' =>
                        $fixture['away_team_id'],

                    'away_team_id' =>
                        $fixture['home_team_id'],

                ];
            }


            $secondHalf[] =
                $reverseRound;
        }


        return $secondHalf;
    }


    /**
     * Create or update games.
     *
     * Match day is determined by the round number.
     */
    private function createFixtures(
        array $rounds,
        int $seasonId,
        int $tournamentId
    ): void {

        /*
        |--------------------------------------------------------------------------
        | TOTAL MATCH DAYS
        |--------------------------------------------------------------------------
        */

        $totalMatchDays = count($rounds);


        /*
        |--------------------------------------------------------------------------
        | PROGRESS BAR
        |--------------------------------------------------------------------------
        */

        $bar = $this->command
            ->getOutput()
            ->createProgressBar(
                $totalMatchDays
            );

        $bar->start();


        /*
        |--------------------------------------------------------------------------
        | CREATE EACH MATCH DAY
        |--------------------------------------------------------------------------
        */

        foreach (
            $rounds as $roundIndex => $round
        ) {

            /*
            |--------------------------------------------------------------------------
            | MATCH DAY
            |--------------------------------------------------------------------------
            |
            | Array index starts at 0.
            |
            | Therefore:
            |
            | index 0 = Match Day 1
            | index 1 = Match Day 2
            | index 2 = Match Day 3
            |
            */

            $matchDay =
                $roundIndex + 1;


            /*
            |--------------------------------------------------------------------------
            | CREATE GAMES
            |--------------------------------------------------------------------------
            */

            foreach (
                $round as $fixture
            ) {

                /*
                |--------------------------------------------------------------------------
                | FIND EXISTING GAME OR CREATE NEW GAME
                |--------------------------------------------------------------------------
                |
                | Using firstOrNew instead of firstOrCreate allows us
                | to update match_day when the seeder is run again.
                |
                */

                $game = Game::firstOrNew([

                    'season_id' =>
                        $seasonId,

                    'tournament_id' =>
                        $tournamentId,

                    'home_team_id' =>
                        $fixture['home_team_id'],

                    'away_team_id' =>
                        $fixture['away_team_id'],

                ]);


                /*
                |--------------------------------------------------------------------------
                | ASSIGN MATCH DAY
                |--------------------------------------------------------------------------
                */

                $game->match_day =
                    $matchDay;


                /*
                |--------------------------------------------------------------------------
                | OTHER GAME INFORMATION
                |--------------------------------------------------------------------------
                |
                | These can be changed later by the Games UI.
                |
                */

                if (!$game->exists) {

                    $game->stage_id = null;

                    $game->venue_id = null;

                    $game->kick_off_date = null;

                    $game->kick_off_time = null;

                    $game->status_id = null;
                }


                /*
                |--------------------------------------------------------------------------
                | SAVE GAME
                |--------------------------------------------------------------------------
                */

                $game->save();
            }


            /*
            |--------------------------------------------------------------------------
            | PROGRESS
            |--------------------------------------------------------------------------
            */

            $bar->advance();


            /*
            |--------------------------------------------------------------------------
            | MATCH DAY MESSAGE
            |--------------------------------------------------------------------------
            */

            $this->command->line(
                " Match Day {$matchDay} created."
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FINISH PROGRESS
        |--------------------------------------------------------------------------
        */

        $bar->finish();

        $this->command->newLine();
    }
}