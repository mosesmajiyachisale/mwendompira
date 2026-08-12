<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormationSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => null,
                'formation_name' => '3-4-3',
                'formation_desc' => 'Three defenders, four midfielders, and three forwards.',
                'formation_rank' => 22,
            ],
            [
                'id' => null,
                'formation_name' => '3-4-2-1',
                'formation_desc' => 'Three defenders, four midfielders, two attacking midfielders, and one forward.',
                'formation_rank' => 22,
            ],
            [
                'id' => null,
                'formation_name' => '3-4-1-2',
                'formation_desc' => 'Three defenders, four midfielders, one attacking midfielder, and two forwards.',
                'formation_rank' => 22,
            ],
            [
                'id' => null,
                'formation_name' => '3-1-4-2',
                'formation_desc' => 'Three defenders, one defensive midfielder, four midfielders, and two forwards.',
                'formation_rank' => 22,
            ],
            [
                'id' => null,
                'formation_name' => '3-1-4-1-1',
                'formation_desc' => 'Three defenders, one defensive midfielder, four midfielders, one attacking midfielder, and one forward.',
                'formation_rank' => 22,
            ],
            [
                'id' => null,
                'formation_name' => '4-5-1',
                'formation_desc' => 'Four defenders, five midfielders, and one forward.',
                'formation_rank' => 22,
            ],
            [
                'id' => null,
                'formation_name' => '4-4-2',
                'formation_desc' => 'Four defenders, four midfielders, and two forwards.',
                'formation_rank' => 2,
            ],
            [
                'id' => null,
                'formation_name' => '4-4-1-1',
                'formation_desc' => 'Four defenders, four midfielders, one attacking midfielder, and one forward.',
                'formation_rank' => 3,
            ],
            [
                'id' => null,
                'formation_name' => '4-3-3',
                'formation_desc' => 'Four defenders, three midfielders, and three forwards.',
                'formation_rank' => 3,
            ],
            [
                'id' => null,
                'formation_name' => '4-3-1-2',
                'formation_desc' => 'Four defenders, three midfielders, one attacking midfielder, and two forwards.',
                'formation_rank' => 22,
            ],
            [
                'id' => null,
                'formation_name' => '4-3-2-1',
                'formation_desc' => 'Four defenders, three midfielders, two attacking midfielders, and one forward.',
                'formation_rank' => 22,
            ],
            [
                'id' => null,
                'formation_name' => '4-2-1-3',
                'formation_desc' => 'Four defenders, two defensive midfielders, one attacking midfielder, and three forwards.',
                'formation_rank' => 3,
            ],
            [
                'id' => null,
                'formation_name' => '4-2-3-1',
                'formation_desc' => 'Four defenders, two defensive midfielders, three attacking midfielders, and one forward.',
                'formation_rank' => 1,
            ],
            [
                'id' => null,
                'formation_name' => '4-1-4-1',
                'formation_desc' => 'Four defenders, one defensive midfielder, four midfielders, and one forward.',
                'formation_rank' => 22,
            ],
            [
                'id' => null,
                'formation_name' => '4-1-3-2',
                'formation_desc' => 'Four defenders, one defensive midfielder, three attacking midfielders, and two forwards.',
                'formation_rank' => 22,
            ],
            [
                'id' => null,
                'formation_name' => '4-1-2-3',
                'formation_desc' => 'Four defenders, one defensive midfielder, two midfielders, and three forwards.',
                'formation_rank' => 5,
            ],
            [
                'id' => null,
                'formation_name' => '4-1-2-1-2',
                'formation_desc' => 'Four defenders, one defensive midfielder, two midfielders, one attacking midfielder, and two forwards.',
                'formation_rank' => 4,
            ],
            [
                'id' => null,
                'formation_name' => '5-4-1',
                'formation_desc' => 'Five defenders, four midfielders, and one forward.',
                'formation_rank' => 22,
            ],
            [
                'id' => null,
                'formation_name' => '5-3-2',
                'formation_desc' => 'Five defenders, three midfielders, and two forwards.',
                'formation_rank' => 22,
            ],
            [
                'id' => null,
                'formation_name' => '5-2-3',
                'formation_desc' => 'Five defenders, two midfielders, and three forwards.',
                'formation_rank' => 22,
            ],
            [
                'id' => null,
                'formation_name' => '5-1-4',
                'formation_desc' => 'Five defenders, one defensive midfielder, and four forwards.',
                'formation_rank' => 22,
            ],
            [
                'id' => null,
                'formation_name' => '5-1-3-1',
                'formation_desc' => 'Five defenders, one defensive midfielder, three attacking midfielders, and one forward.',
                'formation_rank' => 22,
            ],
        ];

        $count = count($data);

        $bar = $this->command
            ->getOutput()
            ->createProgressBar($count);

        $bar->start();

        foreach ($data as $row) {

            DB::table('formations')->updateOrInsert(
                [
                    'formation_name' => $row['formation_name'],
                ],
                [
                    'formation_desc' => $row['formation_desc'],
                    'formation_rank' => $row['formation_rank'],
                    'updated_at' => now(),
                ]
            );

            $bar->advance();
        }

        $bar->finish();

        $this->command->info("");
    }
}