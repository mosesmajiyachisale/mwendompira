<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseWithoutFKChecksSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            DB::table('participations')->truncate();
            DB::table('locations')->truncate();
            DB::table('teams')->truncate();
        });
    }
}
