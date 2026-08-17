<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Academic qualifications
            [
                'id' => null,
                'qualification_name' => 'Junior Certificate of Education',
                'qualification_code' => 'JCE',
                'qualification_type_id' => 1,
                'qualification_desc' => 'Junior secondary school qualification.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'Malawi School Certificate of Education',
                'qualification_code' => 'MSCE',
                'qualification_type_id' => 1,
                'qualification_desc' => 'Secondary school leaving qualification.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'Certificate',
                'qualification_code' => 'CERT',
                'qualification_type_id' => 1,
                'qualification_desc' => 'Post-secondary certificate qualification.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'Advanced Certificate',
                'qualification_code' => 'ADV-CERT',
                'qualification_type_id' => 1,
                'qualification_desc' => 'Advanced certificate qualification.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'Diploma',
                'qualification_code' => 'DIPLOMA',
                'qualification_type_id' => 1,
                'qualification_desc' => 'Post-secondary diploma qualification.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'Advanced Diploma',
                'qualification_code' => 'ADV-DIP',
                'qualification_type_id' => 1,
                'qualification_desc' => 'Advanced diploma qualification.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'Bachelor\'s Degree',
                'qualification_code' => 'BACHELOR',
                'qualification_type_id' => 1,
                'qualification_desc' => 'Undergraduate academic degree.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'Postgraduate Certificate',
                'qualification_code' => 'PGCERT',
                'qualification_type_id' => 1,
                'qualification_desc' => 'Postgraduate certificate qualification.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'Postgraduate Diploma',
                'qualification_code' => 'PGDIP',
                'qualification_type_id' => 1,
                'qualification_desc' => 'Postgraduate diploma qualification.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'Master\'s Degree',
                'qualification_code' => 'MASTER',
                'qualification_type_id' => 1,
                'qualification_desc' => 'Postgraduate academic degree.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'Doctoral Degree',
                'qualification_code' => 'DOCTORATE',
                'qualification_type_id' => 1,
                'qualification_desc' => 'Doctoral-level academic qualification.',
                'is_active' => true,
            ],

            // Professional qualifications
            [
                'id' => null,
                'qualification_name' => 'FIFA D Licence',
                'qualification_code' => 'FIFA-D',
                'qualification_type_id' => 2,
                'qualification_desc' => 'Entry-level football coaching qualification.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'FIFA C Licence',
                'qualification_code' => 'FIFA-C',
                'qualification_type_id' => 2,
                'qualification_desc' => 'Intermediate football coaching qualification.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'FIFA B Licence',
                'qualification_code' => 'FIFA-B',
                'qualification_type_id' => 2,
                'qualification_desc' => 'Advanced football coaching qualification.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'FIFA A Licence',
                'qualification_code' => 'FIFA-A',
                'qualification_type_id' => 2,
                'qualification_desc' => 'Advanced professional football coaching qualification.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'FIFA Pro Licence',
                'qualification_code' => 'FIFA-Pro',
                'qualification_type_id' => 2,
                'qualification_desc' => 'First aid qualification relevant to sports.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'CAF D Licence',
                'qualification_code' => 'CAF-D',
                'qualification_type_id' => 2,
                'qualification_desc' => 'Entry-level football coaching qualification.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'CAF C Licence',
                'qualification_code' => 'CAF-C',
                'qualification_type_id' => 2,
                'qualification_desc' => 'Intermediate football coaching qualification.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'CAF B Licence',
                'qualification_code' => 'CAF-B',
                'qualification_type_id' => 2,
                'qualification_desc' => 'Advanced football coaching qualification.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'CAF A Licence',
                'qualification_code' => 'CAF-A',
                'qualification_type_id' => 2,
                'qualification_desc' => 'Advanced professional football coaching qualification.',
                'is_active' => true,
            ],
            [
                'id' => null,
                'qualification_name' => 'CAF Pro Licence',
                'qualification_code' => 'CAF-Pro',
                'qualification_type_id' => 2,
                'qualification_desc' => 'First aid qualification relevant to sports.',
                'is_active' => true,
            ],
        ];

        $count = count($data);

        $bar = $this->command->getOutput()->createProgressBar($count);
        $bar->start();

        foreach ($data as $row) {
            DB::table('qualifications')->updateOrInsert(
                ['id' => $row['id']],
                $row
            );

            $bar->advance();
        }

        $bar->finish();

        $this->command->info('');
    }
}