<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $sponsors = [
            [
                'sponsor_name'    => 'Telcom Networks Malawi',
                'sponsor_code'    => 'TNM',
                'sponsor_desc'    => null,
            ], 
            [
                'sponsor_name'    => 'First Capital Bank',
                'sponsor_code'    => 'FCB',
                'sponsor_desc'    => null,
            ], 
            
            [
                'sponsor_name'    => 'Be Forward Car Importers',
                'sponsor_code'    => 'BeForward',
                'sponsor_desc'    => null,
            ], 
            [
                'sponsor_name'    => 'Nyasa Manufacturing Limited',
                'sponsor_code'    => 'Nyasa',
                'sponsor_desc'    => null,
            ], 
            [
                'sponsor_name'    => 'Malawi Defence Force',
                'sponsor_code'    => 'MDF',
                'sponsor_desc'    => null,
            ], 
            
            [
                'sponsor_name'    => 'Prophet Sheperd Bushiri Ministries',
                'sponsor_code'    => 'PSB',
                'sponsor_desc'    => null,
            ], 

            [
                'sponsor_name'    => 'Airtel Malawi',
                'sponsor_code'    => 'Airtel',
                'sponsor_desc'    => null,
            ], 
            [
                'sponsor_name'    => 'Thomson Mpinganjira',
                'sponsor_code'    => 'Thom Mpinga',
                'sponsor_desc'    => null,
            ], 
            
            [
                'sponsor_name'    => 'Malawi Government',
                'sponsor_code'    => 'MG',
                'sponsor_desc'    => null,
            ], 
        ];

        $bar = $this->command->getOutput()->createProgressBar(count($sponsors));
        $bar->start();

        foreach ($sponsors as $sponsor) {
            DB::table('sponsors')->updateOrInsert(
                ['sponsor_name' => $sponsor['sponsor_name']],
                ['sponsor_code' => $sponsor['sponsor_code']]
            );
            $bar->advance();
        }

        $bar->finish();
        $this->command->info("");
    }
}
