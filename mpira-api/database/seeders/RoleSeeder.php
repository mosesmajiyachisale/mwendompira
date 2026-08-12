<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $data = [
            ['id' => 1, 'role_name' => 'Superadmin'],
            ['id' => 2, 'role_name' => 'Admin'],
            ['id' => 3, 'role_name' => 'Coach'],
            ['id' => 4, 'role_name' => 'Guest'],
        ];
        
        $count = count($data);
        $bar = $this->command->getOutput()->createProgressBar($count);
        $bar->start();

        foreach ($data as $row) {
            DB::table('roles')->updateOrInsert($row);
            $bar->advance();
        }

        $this->command->info("");
        $bar->finish();
    }
}
