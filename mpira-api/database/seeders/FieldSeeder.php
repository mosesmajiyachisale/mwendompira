<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'field_name' => 'Sports Science',
                'field_code' => 'SPORT',
                'field_desc' => 'sport, human performance and related sciences.',
                'is_active' => true,
            ],
            [
                'id' => 2,
                'field_name' => 'Sports Coaching',
                'field_code' => 'COACH',
                'field_desc' => 'coaching principles, methods and practice.',
                'is_active' => true,
            ],
            [
                'id' => 3,
                'field_name' => 'Sports Management',
                'field_code' => 'SPM',
                'field_desc' => 'Management and administration of sports organizations and activities.',
                'is_active' => true,
            ],
            [
                'id' => 4,
                'field_name' => 'Sports Administration',
                'field_code' => 'SPA',
                'field_desc' => 'Administration and governance of sports organizations.',
                'is_active' => true,
            ],
            [
                'id' => 5,
                'field_name' => 'Physical Education',
                'field_code' => 'PED',
                'field_desc' => 'physical education, physical activity and sport.',
                'is_active' => true,
            ],
            [
                'id' => 6,
                'field_name' => 'Exercise Science',
                'field_code' => 'EXSCI',
                'field_desc' => 'exercise, physical performance and human movement.',
                'is_active' => true,
            ],
            [
                'id' => 7,
                'field_name' => 'Exercise Physiology',
                'field_code' => 'EXPHYS',
                'field_desc' => 'physiological responses and adaptations to exercise.',
                'is_active' => true,
            ],
            [
                'id' => 8,
                'field_name' => 'Sport Psychology',
                'field_code' => 'SPORTPSY',
                'field_desc' => 'Application of psychology to sport and athletic performance.',
                'is_active' => true,
            ],
            [
                'id' => 9,
                'field_name' => 'Sports Nutrition',
                'field_code' => 'SPORTNUT',
                'field_desc' => 'Nutrition and dietary practices related to sports performance.',
                'is_active' => true,
            ],
            [
                'id' => 10,
                'field_name' => 'Sports Physiotherapy',
                'field_code' => 'SPTP',
                'field_desc' => 'Physiotherapy and rehabilitation related to sports and athletic performance.',
                'is_active' => true,
            ],
            [
                'id' => 11,
                'field_name' => 'Sports Medicine',
                'field_code' => 'SPMED',
                'field_desc' => 'Medical care, injury prevention and treatment related to sports.',
                'is_active' => true,
            ],
            [
                'id' => 12,
                'field_name' => 'Sports Analytics',
                'field_code' => 'SPANA',
                'field_desc' => 'Analysis of sports performance and sporting data.',
                'is_active' => true,
            ],
            [
                'id' => 13,
                'field_name' => 'Football Studies',
                'field_code' => 'FOOT',
                'field_desc' => 'Academic football and its technical, tactical and organizational aspects.',
                'is_active' => true,
            ],
            [
                'id' => 14,
                'field_name' => 'Business Administration',
                'field_code' => 'BUS',
                'field_desc' => 'business operations, administration and organizational management.',
                'is_active' => true,
            ],
            [
                'id' => 15,
                'field_name' => 'Business Management',
                'field_code' => 'BMAN',
                'field_desc' => 'business management and organizational leadership.',
                'is_active' => true,
            ],
            [
                'id' => 16,
                'field_name' => 'Project Management',
                'field_code' => 'PM',
                'field_desc' => 'planning, management and delivery of projects.',
                'is_active' => true,
            ],
            [
                'id' => 17,
                'field_name' => 'Human Resource Management',
                'field_code' => 'HRM',
                'field_desc' => 'Management of people and human resources within organizations.',
                'is_active' => true,
            ],
            [
                'id' => 18,
                'field_name' => 'Marketing',
                'field_code' => 'MKT',
                'field_desc' => 'marketing, promotion and customer engagement.',
                'is_active' => true,
            ],
            [
                'id' => 19,
                'field_name' => 'Public Relations',
                'field_code' => 'PR',
                'field_desc' => 'Communication and relationship management for organizations.',
                'is_active' => true,
            ],
            [
                'id' => 20,
                'field_name' => 'Finance',
                'field_code' => 'FIN',
                'field_desc' => 'financial management and financial administration.',
                'is_active' => true,
            ],
            [
                'id' => 21,
                'field_name' => 'Accounting',
                'field_code' => 'ACCT',
                'field_desc' => 'accounting and financial reporting.',
                'is_active' => true,
            ],
            [
                'id' => 22,
                'field_name' => 'Leadership',
                'field_code' => 'LEAD',
                'field_desc' => 'leadership, organizational development and management.',
                'is_active' => true,
            ],
            [
                'id' => 23,
                'field_name' => 'Education',
                'field_code' => 'EDU',
                'field_desc' => 'education, teaching and learning.',
                'is_active' => true,
            ],
            [
                'id' => 24,
                'field_name' => 'Information Technology',
                'field_code' => 'IT',
                'field_desc' => 'information technology and digital systems.',
                'is_active' => true,
            ],
            [
                'id' => 25,
                'field_name' => 'Statistics',
                'field_code' => 'STAT',
                'field_desc' => 'statistical methods and data analysis.',
                'is_active' => true,
            ],
            [
                'id' => 26,
                'field_name' => 'Other',
                'field_code' => 'OTHER',
                'field_desc' => 'Other relevant field not listed.',
                'is_active' => true,
            ],
        ];

        $count = count($data);

        $bar = $this->command->getOutput()->createProgressBar($count);
        $bar->start();

        foreach ($data as $row) {
            DB::table('fields')->updateOrInsert(
                ['id' => $row['id']],
                $row
            );

            $bar->advance();
        }

        $bar->finish();

        $this->command->info('');
    }
}