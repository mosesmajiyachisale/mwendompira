<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Person;

class PersonSeeder extends Seeder
{
    public function run(): void
    {
        $persons = [
            [
                'first_name'  => 'Superadmin',
                'middle_name' => '',
                'last_name'   => '',
                'dob'         => null,
            ],
            [
                'first_name'  => 'Admin',
                'middle_name' => '',
                'last_name'   => '',
                'dob'         => null,
            ],
            [
                'first_name'  => 'Joseph',
                'middle_name' => 'Moses',
                'last_name'   => 'Majiya',
                'gender'         => 'Male',
                'dob'         => null,
            ],

            [
                'first_name'  => 'Getrude',
                'middle_name' => 'Majiya',
                'last_name'   => 'Uladi',
                'gender'         => 'Female',
                'dob'         => null,
            ],
            [
                'first_name'  => 'Julius',
                'middle_name' => 'Msamila',
                'last_name'   => 'Mphonde',
                'gender'         => 'Male',
                'dob'         => null,
            ],
        ];

        // Create a progress bar
        $extra_persons = 10;
        $bar = $this->command->getOutput()->createProgressBar(count($persons) + $extra_persons );
        $bar->start();

        foreach ($persons as $person) {
            // Person::create($p);
            DB::table('persons')->updateOrInsert(
                [
                    'first_name' => $person['first_name'],
                    'middle_name' => $person['middle_name'],
                    'last_name' => $person['last_name'],
                ],
                [
                    'dob' => $person['dob'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            // Advance progress bar
            $bar->advance();
        }

        for($i=0; $i < $extra_persons; $i++){
            Person::factory()->count(1)->create();
            $bar->advance();
        }


        // Finish and display new line
        $bar->finish();
        $this->command->info("");
    }
}
