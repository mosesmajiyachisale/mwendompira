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
        Schema::create('participations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->constrained('seasons')->onDelete('cascade');
            $table->foreignId('tournament_id')->constrained('tournaments')->onDelete('cascade');
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('sponsor_id')->nullable()->constrained('sponsors');
            $table->foreignId('stadium_id')->nullable()->constrained('locations')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->unique(
                ['season_id','tournament_id','team_id'],'unique_participation'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participations');
    }
};
