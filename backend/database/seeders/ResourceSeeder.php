<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tables = collect(DB::select('SHOW TABLES'))
            ->map(function ($table) {
                return array_values((array) $table)[0];
            })
            ->filter(function ($tableName) {
                return $tableName !== 'resources';
            })
            ->values()
            ->toArray();


        $default_tables = [
            'failed_jobs',
            'migrations',
            'password_resets',
            'personal_access_tokens',
            'password_reset_tokens',
            'cache',
            'cache_locks',
            'jobs',
            'job_batches',
            'sessions'
        ];


        $filtered_tables = array_diff($tables, $default_tables);


        $menus = [
            'security',
            'settings',
        ];


        $total = count($filtered_tables) + count($menus);

        $bar = $this->command
            ->getOutput()
            ->createProgressBar($total);

        $bar->start();


        $data = [];


        foreach ($filtered_tables as $resource) {

            $data[] = [
                'resource_name' => $resource,
                'is_menu'       => false,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];

            $bar->advance();
        }


        foreach ($menus as $resource) {

            $data[] = [
                'resource_name' => $resource,
                'is_menu'       => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ];

            $bar->advance();
        }


        if (!empty($data)) {
            DB::table('resources')->insertOrIgnore($data);
        }


        $bar->finish();

        $this->command->info('');
    }
}