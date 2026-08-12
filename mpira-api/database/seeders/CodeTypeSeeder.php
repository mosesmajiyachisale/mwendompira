<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CodeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $data = [
                [
                    'id' => 1,
                    'code_type_name' => 'Player',
                ],
                
                [
                    'id' => 2,
                    'code_type_name' => 'Coach',
                ],

            ];
    
            $count = count($data);
    
            $bar = $this->command->getOutput()->createProgressBar($count);
            $bar->start();
    
            foreach ($data as $row) {
                DB::table('code_types')->updateOrInsert(
                    ['id' => $row['id']],
                    $row
                );
    
                $bar->advance();
            }
    
            $bar->finish();
            $this->command->info('');
        }
    }
}
