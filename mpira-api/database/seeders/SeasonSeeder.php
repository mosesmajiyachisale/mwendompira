<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeasonSeeder extends Seeder
{
    public function run()
    {
        $startYear= 2020;
        $number_of_seasons = 50;
        
        $bar = $this->command->getOutput()->createProgressBar($number_of_seasons);
        $bar->start();

        for($year=$startYear; $year < $startYear + $number_of_seasons; $year++){
            $endYear = $year + 1;

            $season_id = $year;
            $season_code = $year ."-".$endYear;
            $start_date = date("$year-04-d");

            DB::table('seasons')->updateOrInsert(
                [
                    'id' => $season_id,
                ],
                [
                    'season_code' => $season_code,
                    'start_date' => $start_date,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            );
            $bar->advance();
        }
        
        $bar->finish();
        $this->command->info("");
    }
}
