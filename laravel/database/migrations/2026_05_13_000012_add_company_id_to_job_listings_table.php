<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->string('canonical_url')->nullable()->after('source_url');
            $table->string('ats_job_id')->nullable()->after('canonical_url');
            $table->string('content_hash', 64)->nullable()->after('ats_job_id');
            $table->timestamp('source_publish_date')->nullable()->after('posted_at');
            $table->timestamp('last_seen_at')->nullable()->after('source_publish_date');
            $table->json('skills_extracted')->nullable()->after('description');
            $table->string('seniority_extracted')->nullable()->after('skills_extracted');
            $table->json('benefits_extracted')->nullable()->after('seniority_extracted');
        });
    }

    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn(['company_id', 'canonical_url', 'ats_job_id', 'content_hash', 'source_publish_date', 'last_seen_at', 'skills_extracted', 'seniority_extracted', 'benefits_extracted']);
        });
    }
};
