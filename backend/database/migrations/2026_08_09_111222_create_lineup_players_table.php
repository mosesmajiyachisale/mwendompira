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
        Schema::create('lineup_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lineup_id')->constrained('lineups')->restrictOnDelete();
            $table->foreignId('player_id')->constrained('players')->restrictOnDelete();
            $table->foreignId('position_id')->nullable()->constrained('positions')->restrictOnDelete();
            $table->unsignedSmallInteger('shirt_number')->nullable();
            $table->boolean('first_eleven')->default(false);
            $table->boolean('substituted_on')->default(false);
            $table->boolean('substituted_off')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            
            $table->unique(['lineup_id','player_id'],'unique_lineup_player');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lineup_players');
    }
};
