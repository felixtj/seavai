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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('company');
            $table->string('location');
            $table->enum('remote_type', ['remote', 'hybrid', 'onsite'])->default('onsite');
            $table->enum('status', ['active', 'draft', 'closed'])->default('active');
            $table->enum('employment_type', ['full-time', 'part-time', 'contract'])->default('full-time');
            $table->unsignedInteger('salary_min')->nullable();
            $table->unsignedInteger('salary_max')->nullable();
            $table->string('category')->default('tech');
            $table->text('description')->nullable();
            $table->string('source_url')->nullable();
            $table->string('source_domain')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
