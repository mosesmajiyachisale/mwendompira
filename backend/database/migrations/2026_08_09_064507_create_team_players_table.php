<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('team_players', function (Blueprint $table) {

            $table->id();

            $table->foreignId('season_id')->constrained('seasons')->restrictOnDelete();
            $table->foreignId('team_id')->constrained('teams')->restrictOnDelete();
            $table->foreignId('player_id')->constrained('players')->restrictOnDelete();
            $table->foreignId('position_id')->constrained('positions')->restrictOnDelete();
            $table->unsignedSmallInteger('shirt_number')->nullable();
            $table->foreignId('transfer_status_id')->constrained('statuses')->restrictOnDelete();
            $table->foreignId('loan_status_id')->constrained('statuses')->restrictOnDelete();
            
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['season_id', 'team_id', 'player_id'],'uniqueteam_player');
            $table->unique(['season_id', 'team_id', 'shirt_number'],'unique_shirt_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_players');
    }
};