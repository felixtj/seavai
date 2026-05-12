<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidate_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('role_focus', ['digital-marketing', 'tech', 'ai-crypto'])->nullable();
            $table->string('location')->nullable();
            $table->enum('remote_preference', ['remote', 'hybrid', 'onsite', 'flexible'])->nullable();
            $table->enum('seniority', ['junior', 'mid', 'senior', 'lead', 'any'])->nullable();
            $table->unsignedInteger('salary_min')->nullable();
            $table->unsignedInteger('salary_max')->nullable();
            $table->string('currency', 3)->default('AUD');
            $table->string('linkedin_url')->nullable();
            $table->string('headline')->nullable();
            $table->text('bio')->nullable();
            $table->unsignedTinyInteger('onboarding_step')->default(0);
            $table->timestamp('onboarding_completed_at')->nullable();
            $table->unsignedTinyInteger('profile_completeness')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidate_profiles');
    }
};
