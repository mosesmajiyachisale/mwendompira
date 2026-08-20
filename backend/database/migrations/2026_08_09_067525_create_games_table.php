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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->constrained('seasons')->onDelete('cascade');
            $table->foreignId('tournament_id')->constrained('tournaments')->onDelete('cascade');
            $table->foreignId('stage_id')->nullable()->constrained('stages')->onDelete('cascade'); $table->unsignedSmallInteger('match_day');
            $table->foreignId('home_team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('away_team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('venue_id')->nullable()->constrained('locations')->onDelete('cascade');
            $table->date('kick_off_date')->nullable();
            $table->time('kick_off_time')->nullable();

            $table->foreignId('status_id') ->nullable()->constrained('statuses')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            
            $table->unique(
                ['season_id','tournament_id','home_team_id','away_team_id'],
                'unique_game'
            );
            
            $table->index(
                [ 'season_id', 'tournament_id', 'match_day'],
                'games_match_day_index'
            );

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
