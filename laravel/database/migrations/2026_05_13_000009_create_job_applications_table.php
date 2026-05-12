<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tracks jobs candidates applied to — both seav.ai jobs and manually added external ones
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_listing_id')->nullable()->constrained()->nullOnDelete(); // null = external job
            // For manually tracked external jobs:
            $table->string('company_name')->nullable();
            $table->string('job_title')->nullable();
            $table->string('job_url')->nullable();
            $table->enum('status', ['saved', 'applied', 'phone-screen', 'interview', 'offer', 'rejected', 'withdrawn'])->default('applied');
            $table->date('applied_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
