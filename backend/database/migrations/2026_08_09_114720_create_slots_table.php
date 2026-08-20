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
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->string('slot_code', 10)->unique();
            $table->string('slot_name', 50);
            $table->unsignedTinyInteger('grid_x')->nullable();
            $table->unsignedTinyInteger('grid_y')->nullable();
            $table->string('slot_desc', 100);
            $table->foreignId('position_id')->nullable()->constrained('positions')->restrictOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slots');
    }
};
