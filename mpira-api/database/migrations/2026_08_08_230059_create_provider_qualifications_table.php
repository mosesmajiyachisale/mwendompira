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
        Schema::create('provider_qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained('providers')->onDelete('cascade');
            $table->foreignId('qualification_id')->constrained('qualifications')->onDelete('cascade');
            $table->foreignId('field_id')->nullable()->constrained('fields')->onDelete('cascade');
            $table->string('issuing_organization',100)->nullable();
            $table->string('certificate_number',50)->nullable();
            $table->date('date_obtained')->nullable();
            $table->date('expiry_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(
                ['provider_id','qualification_id'],
                'unique_provider_qualification'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_qualifications');
    }
};
