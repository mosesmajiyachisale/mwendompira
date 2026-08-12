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
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',20);
            $table->string('middle_name', 20)->default('');
            $table->string('last_name',20);
            $table->enum('gender',['Male','Female'])->nullable();
            $table->date('dob')->nullable();            
            $table->foreignId('location_id')->nullable()->constrained('locations');
            $table->timestamps();
            $table->unique(['first_name','middle_name', 'last_name'], 'unq_person');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};
