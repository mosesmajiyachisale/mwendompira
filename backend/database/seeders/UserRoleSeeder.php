<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_roles')->updateOrInsert(
            [
                'user_id' => 1,
                'role_id' => 1,
            ],
            [
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        
        DB::table('user_roles')->updateOrInsert(
            [
                'user_id' => 2,
                'role_id' => 2,
            ],
            [
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
