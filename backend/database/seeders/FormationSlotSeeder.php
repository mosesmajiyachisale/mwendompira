<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Formation;
use App\Models\Slot;

class FormationSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('formation_slots')->truncate();
        $data = [
                    [
                        'formation_name' => '3-4-3',       
                        'slots' => ['GK','LCB', 'SW', 'RCB', 'LW', 'LCM', 'RCM', 'RW', 'LF', 'ST', 'RF']
                    ],
                    [
                        'formation_name' => '3-4-2-1',     
                        'slots' => ['GK','LCB', 'SW', 'RCB', 'LW', 'LCM', 'RCM', 'RW', 'LCF', 'RCF', 'ST']
                    ],
                    [
                        'formation_name' => '3-4-1-2',     
                        'slots' => ['GK','LCB', 'SW', 'RCB', 'LW', 'LCM', 'RCM', 'RW', 'CAM', 'LST', 'RST']
                    ],
                    [
                        'formation_name' => '3-1-4-2',     
                        'slots' => ['GK','LCB', 'SW', 'RCB', 'CDM', 'LW', 'LCM', 'RCM', 'RW', 'LCF', 'RCF']
                    ],
                    [
                        'formation_name' => '3-1-4-1-1',   
                        'slots' => ['GK','LCB', 'SW', 'RCB', 'CDM', 'LW', 'LCM', 'RCM', 'RW', 'CF', 'ST']
                    ],

                    [
                        'formation_name' => '4-5-1',       
                        'slots' => ['GK','LB', 'LCB', 'RCB', 'RB', 'LW', 'LM', 'CM', 'RM', 'RW', 'CF']
                    ],
                    [
                        'formation_name' => '4-4-2',       
                        'slots' => ['GK','LB', 'LCB', 'RCB', 'RB', 'LW', 'LCM', 'RCM', 'RW', 'LST', 'RST']
                    ],
                    [
                        'formation_name' => '4-4-1-1',     
                        'slots' => ['GK','LB', 'LCB', 'RCB', 'RB', 'LW', 'LCM', 'RCM', 'RW', 'CF', 'ST']
                    ],
                    [
                        'formation_name' => '4-3-3',       
                        'slots' => ['GK','LB', 'LCB', 'RCB', 'RB', 'LM', 'CM', 'RM', 'LF', 'ST', 'RF']
                    ],
                    [
                        'formation_name' => '4-3-1-2',     
                        'slots' => ['GK','LB', 'LCB', 'RCB', 'RB', 'LM', 'CM', 'RM', 'CAM', 'LST', 'RST']
                    ],
                    [
                        'formation_name' => '4-3-2-1',     
                        'slots' => ['GK','LB', 'LCB', 'RCB', 'RB', 'LM', 'CM', 'RM', 'LCF', 'RCF', 'ST']
                    ],
                    [
                        'formation_name' => '4-2-1-3',     
                        'slots' => ['GK','LB', 'LCB', 'RCB', 'RB', 'LDM', 'RDM', 'CAM', 'LF', 'ST', 'RF']
                    ],
                    [
                        'formation_name' => '4-2-3-1',     
                        'slots' => ['GK','LB', 'LCB', 'RCB', 'RB', 'LDM', 'RDM', 'LA', 'CAM', 'RA', 'ST']
                    ],
                    [
                        'formation_name' => '4-1-4-1',     
                        'slots' => ['GK','LB', 'LCB', 'RCB', 'RB', 'CDM', 'LW', 'LCM', 'RCM', 'RW', 'CF']
                    ],
                    [
                        'formation_name' => '4-1-3-2',     
                        'slots' => ['GK','LB', 'LCB', 'RCB', 'RB', 'CDM', 'LA', 'CAM', 'RA', 'LST', 'RST']
                    ],
                    [
                        'formation_name' => '4-1-2-3',     
                        'slots' => ['GK','LB', 'LCB', 'RCB', 'RB', 'CDM', 'LCM', 'RCM', 'LF', 'ST', 'RF']
                    ],
                    [
                        'formation_name' => '4-1-2-1-2',   
                        'slots' => ['GK','LB', 'LCB', 'RCB', 'RB', 'CDM', 'LM', 'RM', 'CAM', 'LST', 'RST']
                    ],

                    [
                        'formation_name' => '5-4-1',       
                        'slots' => ['GK','LWB', 'LCB', 'SW', 'RCB', 'RWB', 'LW', 'LCM', 'RCM', 'RW', 'CF']
                    ],
                    [
                        'formation_name' => '5-3-2',       
                        'slots' => ['GK','LWB', 'LCB', 'SW', 'RCB', 'RWB', 'LM', 'CM', 'RM', 'LCF', 'RCF']
                    ],
                    [
                        'formation_name' => '5-2-3',       
                        'slots' => ['GK','LWB', 'LCB', 'SW', 'RCB', 'RWB', 'LDM', 'RDM', 'LF', 'RF', 'ST']
                    ],
                    [
                        'formation_name' => '5-1-4',       
                        'slots' => ['GK','LWB', 'LCB', 'SW', 'RCB', 'RWB', 'CM', 'LWF', 'RWF', 'LCF', 'RCF']
                    ],
                    [
                        'formation_name' => '5-1-3-1',     
                        'slots' => ['GK','LWB', 'LCB', 'SW', 'RCB', 'RWB', 'CM', 'LWF', 'CAM', 'RWF', 'ST']
                    ],
                ];

        $count = count($data);

        $bar = $this->command
            ->getOutput()
            ->createProgressBar($count);

        $bar->start();

        foreach ($data as $formationData) {
            $formation = Formation::where(
                'formation_name',
                $formationData['formation_name']
            )->first();

            if (!$formation) {
                $this->command->warn(
                    "Formation not found: {$formationData['formation_name']}"
                );

                $bar->advance();

                continue;
            }

            foreach ($formationData['slots'] as $slotCode) {
                $slot = Slot::where('slot_code', $slotCode)->first();

                if (!$slot) {
                    $this->command->warn("Slot not found: {$slotCode}");

                    continue;
                }

                DB::table('formation_slots')->updateOrInsert(
                    [
                        'formation_id' => $formation->id,
                        'slot_id' => $slot->id,
                    ],
                    [
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }

            $bar->advance();
        }

        $bar->finish();

        $this->command->newLine();
    }
}