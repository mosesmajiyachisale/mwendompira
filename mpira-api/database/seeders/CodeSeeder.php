<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Season;
use App\Models\CodeType;

class CodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seasons=Season::orderBy('id','asc')->get();

        $NUMBER_OF_COACH_CODES = 1;
        $NUMBER_OF_PLAYER_CODES = 2;


        $TOTAL_NUMBER_OF_CODES = $NUMBER_OF_COACH_CODES + $NUMBER_OF_PLAYER_CODES;
        
        $coachCodeTypeId = CodeType::where('code_type_name','Coach')->value('id');
        $playerCodeTypeId = CodeType::where('code_type_name','Player')->value('id');
        
        $total=$TOTAL_NUMBER_OF_CODES*count($seasons);

        $bar = $this->command->getOutput()->createProgressBar($total);
        $bar->start();

        foreach($seasons as $season){
            $seasonId=$season->id;
            for( $index=1; $index<=$TOTAL_NUMBER_OF_CODES; $index++)
            {

                if($index<=$NUMBER_OF_COACH_CODES){
                    $codeTypeId=$coachCodeTypeId;
                }
                else{
                    $codeTypeId=$playerCodeTypeId;
                }

                $prefix="{$seasonId}";
                $postFix=$this->formatPostFix($index,$TOTAL_NUMBER_OF_CODES);
                $code="{$prefix}{$postFix}";

                DB::table('codes')->updateOrInsert(
                    [
                        'id' => $code,
                        'season_id'=>$seasonId,
                        'code_name'=>$code,
                        'code_type_id'=>$codeTypeId
                    ],
                    [
                        'is_used'=>false,
                        'is_active'=>true,
                        'updated_at'=>now(),
                        'created_at'=>now()
                    ]
                );

                $bar->advance();
            }
        }
        
            $bar->finish();
            $this->command->info('');
    }

    public function formatPostFix(
        int $postFix,
        int $max
    ): string {

        $digits=strlen((string)$max);

        return str_pad(
            (string)$postFix,
            $digits,
            '0',
            STR_PAD_LEFT
        );
    }
}