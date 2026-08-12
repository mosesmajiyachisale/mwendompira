<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            [
                'team_name' => 'Big Bullets',
                'team_code' => 'BB',
                'nickname' => 'The People\'s Team',
                'est' => 1967,
                'is_active' => true,
            ],
            [
                'team_name' => 'Mighty Wanderers',
                'team_code' => 'MW',
                'nickname' => 'Nomads',
                'est' => 1965,
                'is_active' => true,
            ],
            [
                'team_name' => 'Silver Strikers',
                'team_code' => 'SS',
                'nickname' => 'Bankers',
                'est' => 1987,
                'is_active' => true,
            ],
            [
                'team_name' => 'Blue Eagles',
                'team_code' => 'BE',
                'nickname' => 'Cops',
                'est' => 1973,
                'is_active' => true,
            ],
            [
                'team_name' => 'Kamuzu Barracks',
                'team_code' => 'KB',
                'nickname' => 'Soldiers',
                'est' => 2010,
                'is_active' => true,
            ],
            [
                'team_name' => 'Mighty Tigers',
                'team_code' => 'MT',
                'nickname' => 'Tigers',
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Civil Service United',
                'team_code' => 'CSU',
                'nickname' => 'CIVO',
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Moyale Barracks',
                'team_code' => 'MB',
                'nickname' => 'Lions',
                'est' => 1997,
                'is_active' => true,
            ],
            [
                'team_name' => 'Karonga United',
                'team_code' => 'KU',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'MAFCO FC',
                'team_code' => 'MAF',
                'nickname' => 'Mighty Salima',
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Red Lions',
                'team_code' => 'RL',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Chitipa United',
                'team_code' => 'CU',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Dedza Dynamos',
                'team_code' => 'DD',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Ekwendeni Hammers',
                'team_code' => 'EH',
                'nickname' => 'Hammers',
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Ekhaya FC',
                'team_code' => 'EFC',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Bangula United',
                'team_code' => 'BU',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Baka City',
                'team_code' => 'BC',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Rumphi United',
                'team_code' => 'RU',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Immigration FC',
                'team_code' => 'IFC',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Ntopwa FC',
                'team_code' => 'NTF',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Extreme FC',
                'team_code' => 'EXF',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Sable Farming FC',
                'team_code' => 'SFC',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Bangwe All Stars',
                'team_code' => 'BAS',
                'nickname' => 'All Stars',
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'FOMO FC',
                'team_code' => 'FOMO',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Kasungu United',
                'team_code' => 'KSU',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Nkhotakota United',
                'team_code' => 'NKU',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Dwangwa United',
                'team_code' => 'DWU',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Mponela FC',
                'team_code' => 'MFC',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Zomba United',
                'team_code' => 'ZU',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Blantyre United',
                'team_code' => 'BUFC',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Mulanje Tigers',
                'team_code' => 'MUT',
                'nickname' => 'Tigers',
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Nkhata Bay United',
                'team_code' => 'NBU',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Chikwawa United',
                'team_code' => 'CWU',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Mangochi United',
                'team_code' => 'MGU',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Mzimba Young Bullets',
                'team_code' => 'MYB',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Likoma United',
                'team_code' => 'LU',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Karonga Young Soccer',
                'team_code' => 'KYS',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Salima Sugar FC',
                'team_code' => 'SSF',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Blue Bombers',
                'team_code' => 'BB',
                'nickname' => 'Bombers',
                'est' => null,
                'is_active' => true,
            ],
            [
                'team_name' => 'Chanco FC',
                'team_code' => 'CFC',
                'nickname' => null,
                'est' => null,
                'is_active' => true,
            ],
        ];

        $bar = $this->command->getOutput()->createProgressBar(count($teams));
        $bar->start();

        foreach ($teams as $team) {
            DB::table('teams')->updateOrInsert(
                [
                    'team_name' => $team['team_name'],
                ],
                $team
            );

            $bar->advance();
        }

        $bar->finish();

        $this->command->info('');
    }
}