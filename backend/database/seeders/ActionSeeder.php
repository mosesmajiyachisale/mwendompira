<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['id' => 1, 'action_name' => 'index'],
            ['id' => 2, 'action_name' => 'create'],
            ['id' => 3, 'action_name' => 'update'],
            ['id' => 4, 'action_name' => 'delete'],
            ['id' => 5, 'action_name' => 'show'],
            ['id' => 6, 'action_name' => 'edit'],
            ['id' => 7, 'action_name' => 'store'],
            ['id' => 8, 'action_name' => 'upload'],
            ['id' => 9, 'action_name' => 'download'],
        ];

        $count = count($data);

        $bar = $this->command->getOutput()->createProgressBar($count);
        $bar->start();

        foreach ($data as $row) {
            DB::table('actions')->updateOrInsert(
                ['id' => $row['id']],
                $row
            );

            $bar->advance();
        }

        $bar->finish();

        $this->command->info('');
    }
}