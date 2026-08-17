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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('persons')->onDelete('cascade');
            $table->foreignId('provider_code')->nullable()->constrained('codes')->onDelete('cascade');
            $table->string('preferred_name',50)->nullable();
            $table->foreignId('professional_qualification_id')->nullable()->constrained('qualifications')->nullOnDelete();
            $table->foreignId('provider_type_id')->constrained('provider_types')->onDelete('cascade');
            $table->foreignId('season_started')->nullable()->constrained('seasons')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(
                ['person_id','provider_type_id'],
                'unique_provider'
            );

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
