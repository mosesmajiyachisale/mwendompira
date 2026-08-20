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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->unique()->constrained('persons')->onDelete('cascade');
            $table->foreignId('player_code')->nullable()->constrained('codes')->nullOnDelete();
            $table->string('preferred_name',20)->nullable();
            $table->enum('preferred_foot',['Both','Left','Right'])->default('Right');
            $table->unsignedSmallInteger('height_cm')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
