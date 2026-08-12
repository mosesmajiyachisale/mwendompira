<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $resources = DB::table('resources')->orderBy('id')->get();
        $actions = DB::table('actions')
                        // ->whereIn('action_name', ['index','create','update'])
                        ->orderBy('id')->get();

        $count = $resources->count() * $actions->count();
        $bar = $this->command->getOutput()->createProgressBar($count);
        $bar->start();

        foreach ($resources as $resource) {

            foreach ($actions as $action) {

                $isActive = ($action->id >= 11 && $action->id <= 17);
                if($resource->resource_name === "users"){
                    if(in_array($action->action_name, ['index','create','store','show','edit','update','delete','upload'])){
                        $isActive = true;
                    }
                }
                
                if(in_array($resource->resource_name, ['users','roles','permissions'])){
                    if(in_array($action->action_name, ['index','update'])){
                        $isActive = true;
                    }
                }
                
                if($action->action_name ==="index"){
                    $isActive = true;
                }

                DB::table('permissions')->updateOrInsert(
                    [
                        'action_id' => $action->id,
                        'resource_id' => $resource->id
                    ],
                    [
                        'is_active' => $isActive,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

                $bar->advance();
            }
        }

        $bar->finish();
        $this->command->info("");
    }
}

