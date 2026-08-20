<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gameStatus = DB::table('status_types')
            ->where('status_type_name', 'Game Status')
            ->first();
        if (!$gameStatus) {
            $this->command->error('Game Status type not found.');
            return;
        }

        $playerStatus = DB::table('status_types')
            ->where('status_type_name', 'Player Status')
            ->first();
        if (!$playerStatus) {
            $this->command->error('Player Status type not found.');
            return;
        }
            
        $playerTransferOrLoanStatus = DB::table('status_types')
            ->where('status_type_name', 'Transfer/Loan Status')
            ->first();
        if (!$playerTransferOrLoanStatus) {
            $this->command->error('Transfer/Loan Status type not found.');
            return;
        }
      



        $data = [

            // =====================================================
            // GAME STATUSES
            // =====================================================

            [
                'status_name'    => 'Scheduled',
                'status_code'    => 'SCHEDULED',
                'status_desc'    => 'Game has been scheduled but has not started.',
                'status_type_id' => $gameStatus->id,
                'is_active'      => true,
            ],

            [
                'status_name'    => 'Live',
                'status_code'    => 'LIVE',
                'status_desc'    => 'Game is currently in progress.',
                'status_type_id' => $gameStatus->id,
                'is_active'      => true,
            ],

            [
                'status_name'    => 'Half Time',
                'status_code'    => 'HT',
                'status_desc'    => 'First half has ended and the game is at half time.',
                'status_type_id' => $gameStatus->id,
                'is_active'      => true,
            ],

            [
                'status_name'    => 'Full Time',
                'status_code'    => 'FT',
                'status_desc'    => 'Game has ended normally.',
                'status_type_id' => $gameStatus->id,
                'is_active'      => true,
            ],

            [
                'status_name'    => 'Postponed',
                'status_code'    => 'POSTPONED',
                'status_desc'    => 'Game has been postponed to a later date.',
                'status_type_id' => $gameStatus->id,
                'is_active'      => true,
            ],

            [
                'status_name'    => 'Cancelled',
                'status_code'    => 'CANCELLED',
                'status_desc'    => 'Game has been cancelled and will not be played as scheduled.',
                'status_type_id' => $gameStatus->id,
                'is_active'      => true,
            ],

            // =====================================================
            // PLAYER STATUSES
            // =====================================================

            [
                'status_name'    => 'Active',
                'status_code'    => 'ACTIVE',
                'status_desc'    => 'Player is active and available for selection.',
                'status_type_id' => $playerStatus->id,
                'is_active'      => true,
            ],

            [
                'status_name'    => 'Injured',
                'status_code'    => 'INJURED',
                'status_desc'    => 'Player is currently injured.',
                'status_type_id' => $playerStatus->id,
                'is_active'      => true,
            ],

            [
                'status_name'    => 'Suspended',
                'status_code'    => 'SUSPENDED',
                'status_desc'    => 'Player is suspended and unavailable for selection.',
                'status_type_id' => $playerStatus->id,
                'is_active'      => true,
            ],

            [
                'status_name'    => 'Unavailable',
                'status_code'    => 'UNAVAILABLE',
                'status_desc'    => 'Player is currently unavailable for selection.',
                'status_type_id' => $playerStatus->id,
                'is_active'      => true,
            ],

            [
                'status_name'    => 'Retired',
                'status_code'    => 'RETIRED',
                'status_desc'    => 'Player has retired from playing.',
                'status_type_id' => $playerStatus->id,
                'is_active'      => true,
            ],
            
            // =====================================================
            // PLAYER TRANSFER/LOAN STATUSES
            // =====================================================

            [
                'status_name'    => 'Never Moved',
                'status_code'    => 'NEVER_MOVED',
                'status_desc'    => 'Player was never transferred/loaned during the season',
                'status_type_id' => $playerTransferOrLoanStatus->id,
                'is_active'      => true,
            ],

            [
                'status_name'    => 'Moved In',
                'status_code'    => 'MOVED_IN',
                'status_desc'    => 'Player was transferred/loaned in during the season',
                'status_type_id' => $playerTransferOrLoanStatus->id,
                'is_active'      => true,
            ],

            [
                'status_name'    => 'Moved Out',
                'status_code'    => 'MOVED_OUT',
                'status_desc'    => 'Player was transferred/loaned out during the season',
                'status_type_id' => $playerTransferOrLoanStatus->id,
                'is_active'      => true,
            ],
        ];

        $bar = $this->command
            ->getOutput()
            ->createProgressBar(count($data));

        $bar->start();

        foreach ($data as $row) {

            DB::table('statuses')->updateOrInsert(
                [
                    'status_code' => $row['status_code'],
                ],
                $row
            );

            $bar->advance();
        }

        $bar->finish();

        $this->command->info('');
    }
}