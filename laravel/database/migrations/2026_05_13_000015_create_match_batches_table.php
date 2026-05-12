<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('match_batches', function (Blueprint $table) {
            $table->id();
            $table->timestamp('run_at');
            $table->unsignedInteger('candidate_count')->default(0);
            $table->unsignedInteger('job_count')->default(0);
            $table->enum('status', ['running', 'complete', 'failed'])->default('running');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_batches');
    }
};
