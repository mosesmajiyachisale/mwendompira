<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {
        $data = [
            [
                'status_type_name' => 'Game Status',
                'is_active' => true,
            ],
            [
                'status_type_name' => 'Player Status',
                'is_active' => true,
            ],
        ];

        $count = count($data);

        $bar = $this->command->getOutput()->createProgressBar($count);
        $bar->start();

        foreach ($data as $row) {
            DB::table('status_types')->updateOrInsert(
                ['status_type_name' => $row['status_type_name']],
                $row
            );

            $bar->advance();
        }

        $bar->finish();

        $this->command->info('');
    }
}
