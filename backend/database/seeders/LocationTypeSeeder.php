<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'location_type_name' => 'Region',
                'is_active' => true,
            ],
            [
                'id' => 2,
                'location_type_name' => 'District',
                'is_active' => true,
            ],
            [
                'id' => 3,
                'location_type_name' => 'Township',
                'is_active' => true,
            ],
            [
                'id' => 4,
                'location_type_name' => 'Stadium',
                'is_active' => true,
            ],
        ];

        $count = count($data);

        $bar = $this->command->getOutput()->createProgressBar($count);
        $bar->start();

        foreach ($data as $row) {
            DB::table('location_types')->updateOrInsert(
                ['id' => $row['id']],
                $row
            );

            $bar->advance();
        }

        $bar->finish();

        $this->command->info('');
    }
}