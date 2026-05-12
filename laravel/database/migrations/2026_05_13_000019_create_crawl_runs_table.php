<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crawl_runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_source_id')->constrained()->cascadeOnDelete();
            $table->timestamp('started_at');
            $table->timestamp('finished_at')->nullable();
            $table->unsignedInteger('jobs_found')->default(0);
            $table->unsignedInteger('jobs_new')->default(0);
            $table->unsignedInteger('jobs_updated')->default(0);
            $table->unsignedInteger('jobs_closed')->default(0);
            $table->unsignedInteger('freshness_latency_minutes')->nullable(); // median minutes from source_publish_date to crawl
            $table->enum('status', ['running', 'success', 'failed'])->default('running');
            $table->text('error_log')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crawl_runs');
    }
};
