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
        Schema::create('formation_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_id')->constrained('formations')->restrictOnDelete();
            $table->foreignId('slot_id')->constrained('slots')->restrictOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['formation_id','slot_id'],'unique_formation_slot');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formation_slots');
    }
};
