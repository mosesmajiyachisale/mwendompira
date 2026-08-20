<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1,'location_name' => 'Northern Region', 'parent_id' => NULL, 'location_type_id' => 1],
            ['id' => 2,'location_name' => 'Central Region', 'parent_id' => NULL, 'location_type_id' => 1],
            ['id' => 3,'location_name' => 'Southern Region', 'parent_id' => NULL, 'location_type_id' => 1],
            
            ['id' => 101,'location_name' => 'Chitipa', 'parent_id' => 1, 'location_type_id' => 2],
            ['id' => 102,'location_name' => 'Karonga', 'parent_id' => 1, 'location_type_id' => 2],
            ['id' => 103,'location_name' => 'Rumphi', 'parent_id' => 1, 'location_type_id' => 2],
            ['id' => 104,'location_name' => 'Mzimba North', 'parent_id' => 1, 'location_type_id' => 2],
            ['id' => 105,'location_name' => 'Mzimba South', 'parent_id' => 1, 'location_type_id' => 2],
            ['id' => 106,'location_name' => 'Nkhata Bay', 'parent_id' => 1, 'location_type_id' => 2],
            ['id' => 107,'location_name' => 'Likoma', 'parent_id' => 1, 'location_type_id' => 2],
            
            ['id' => 201,'location_name' => 'Kasungu', 'parent_id' => 2, 'location_type_id' => 2],
            ['id' => 202,'location_name' => 'Nkhotakota', 'parent_id' => 2, 'location_type_id' => 2],
            ['id' => 203,'location_name' => 'Ntchisi', 'parent_id' => 2, 'location_type_id' => 2],
            ['id' => 204,'location_name' => 'Dowa', 'parent_id' => 2, 'location_type_id' => 2],
            ['id' => 205,'location_name' => 'Salima', 'parent_id' => 2, 'location_type_id' => 2],
            ['id' => 206,'location_name' => 'Lilongwe', 'parent_id' => 2, 'location_type_id' => 2],
            ['id' => 207,'location_name' => 'Mchinji', 'parent_id' => 2, 'location_type_id' => 2],
            ['id' => 208,'location_name' => 'Dedza', 'parent_id' => 2, 'location_type_id' => 2],
            ['id' => 209,'location_name' => 'Ntcheu', 'parent_id' => 2, 'location_type_id' => 2],
            
            ['id' => 301,'location_name' => 'Mangochi', 'parent_id' => 3, 'location_type_id' => 2],
            ['id' => 302,'location_name' => 'Machinga', 'parent_id' => 3, 'location_type_id' => 2],
            ['id' => 303,'location_name' => 'Balaka', 'parent_id' => 3,'location_type_id' => 2],
            ['id' => 304,'location_name' => 'Zomba', 'parent_id' => 3, 'location_type_id' => 2],
            ['id' => 305,'location_name' => 'Phalombe', 'parent_id' => 3, 'location_type_id' => 2],
            ['id' => 306,'location_name' => 'Chiradzulu', 'parent_id' => 3, 'location_type_id' => 2],
            ['id' => 307,'location_name' => 'Mulanje', 'parent_id' => 3, 'location_type_id' => 2],
            ['id' => 308,'location_name' => 'Thyolo', 'parent_id' => 3, 'location_type_id' => 2],
            ['id' => 309,'location_name' => 'Blantyre', 'parent_id' => 3, 'location_type_id' => 2],
            ['id' => 310,'location_name' => 'Neno', 'parent_id' => 3, 'location_type_id' => 2],
            ['id' => 311,'location_name' => 'Mwanza', 'parent_id' => 3, 'location_type_id' => 2],
            ['id' => 312,'location_name' => 'Chikwawa', 'parent_id' => 3, 'location_type_id' => 2],
            ['id' => 313,'location_name' => 'Nsanje', 'parent_id' => 3, 'location_type_id' => 2],

            
            ['id' => 1000,'location_name' => 'Ndirande', 'parent_id' => 309, 'location_type_id' => 3],
            ['id' => 1001,'location_name' => 'Chlobwe', 'parent_id' => 309, 'location_type_id' => 3],
            ['id' => 1002,'location_name' => 'Bangwe', 'parent_id' => 309, 'location_type_id' => 3],
            ['id' => 1003,'location_name' => 'Zingwangwa', 'parent_id' => 309, 'location_type_id' => 3],
            ['id' => 1004,'location_name' => 'Chilomoni', 'parent_id' => 309, 'location_type_id' => 3],
            ['id' => 1005,'location_name' => 'Machinjiri', 'parent_id' => 309, 'location_type_id' => 3],
            ['id' => 1006,'location_name' => 'Soche', 'parent_id' => 309, 'location_type_id' => 3],
            ['id' => 1007,'location_name' => 'Area 22', 'parent_id' => 206, 'location_type_id' => 3],
            ['id' => 1008,'location_name' => 'Area 23', 'parent_id' => 206, 'location_type_id' => 3],
            ['id' => 1009,'location_name' => 'Area 24', 'parent_id' => 206, 'location_type_id' => 3],
            ['id' => 1010,'location_name' => 'Area 25', 'parent_id' => 206, 'location_type_id' => 3],
            ['id' => 1011,'location_name' => 'Biwi', 'parent_id' => 206, 'location_type_id' => 3],
            ['id' => 1012,'location_name' => 'Likuni', 'parent_id' => 206, 'location_type_id' => 3],
            ['id' => 1013,'location_name' => 'Chisapo', 'parent_id' => 206, 'location_type_id' => 3],
            ['id' => 1014,'location_name' => 'Area 49', 'parent_id' => 206, 'location_type_id' => 3],

            
            ['id' => 2000,'location_name' => 'Kamuzu Stadium', 'parent_id' => 309, 'location_type_id' => 4],
            ['id' => 2001,'location_name' => 'Mpira Stadium', 'parent_id' => 309, 'location_type_id' => 4],
            ['id' => 2002,'location_name' => 'Bingu National Stadium', 'parent_id' => 206, 'location_type_id' => 4],
            ['id' => 2003,'location_name' => 'Civo Stadium', 'parent_id' => 206, 'location_type_id' => 4],
            ['id' => 2004,'location_name' => 'Silver Stadium', 'parent_id' => 206, 'location_type_id' => 4],
            ['id' => 2005,'location_name' => 'Aubrey Dimba Stadium', 'parent_id' => 206, 'location_type_id' => 4],
            ['id' => 2006,'location_name' => 'Dedza Stadium', 'parent_id' => 206, 'location_type_id' => 4],
            ['id' => 2007,'location_name' => 'Mzuzu Stadium', 'parent_id' => 104, 'location_type_id' => 4],
            ['id' => 2008,'location_name' => 'Karonga Stadium', 'parent_id' => 102, 'location_type_id' => 4],

        ];
        
        $count = count($data);
        $bar = $this->command->getOutput()->createProgressBar($count);
        $bar->start();

        foreach ($data as $row) {
            DB::table('locations')->updateOrInsert($row);
            $bar->advance();
        }

        $this->command->info("");
        $bar->finish();
    }
}
