<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'provider_type_name' => 'Coach',
            ],

            [
                'id' => 2,
                'provider_type_name' => 'Assistant Coach',
            ],
            
            [
                'id' => 3,
                'provider_type_name' => 'Trainer',
            ],
            
            [
                'id' => 4,
                'provider_type_name' => 'Team Manager',
            ],
            
            [
                'id' => 5,
                'provider_type_name' => 'Team Doctor',
            ],

            [
                'id' => 6,
                'provider_type_name' => 'Match Commentator',
            ],

            [
                'id' => 7,
                'provider_type_name' => 'Match Analyst',
            ],

        ];

        $count = count($data);

        $bar = $this->command->getOutput()->createProgressBar($count);
        $bar->start();

        foreach ($data as $row) {
            DB::table('provider_types')->updateOrInsert(
                ['id' => $row['id']],
                $row
            );

            $bar->advance();
        }

        $bar->finish();
        $this->command->info('');
    }
}
