<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //disable foreign key check
        $this->call(DatabaseWithoutFKChecksSeeder::class);

        $this->command->info("\n=== STARTED PRELOADING DATA ===");
        $this->call(StatusTypeSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(QualificationTypeSeeder::class);
        $this->call(QualificationSeeder::class);
        $this->call(FieldSeeder::class);
        $this->call(LocationTypeSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(PersonSeeder::class);
        $this->call(ActionSeeder::class);
        $this->call(ResourceSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        // $this->call(UserRoleSeeder::class);
        
        $this->call(SeasonSeeder::class);
        $this->call(TournamentTypeSeeder::class);
        $this->call(TournamentSeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(SponsorSeeder::class);
        $this->call(ParticipationSeeder::class);
        
        $this->call(CodeTypeSeeder::class);
        $this->call(CodeSeeder::class);
        
        $this->call(PhaseSeeder::class);
        $this->call(StageSeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(SlotSeeder::class);
        $this->call(FormationSeeder::class);
        $this->call(FormationSlotSeeder::class);

        
        $this->call(EventTypeSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(ProviderTypeSeeder::class);
        $this->call(ProviderSeeder::class);
    }
}
