<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('domain')->nullable()->unique();
            $table->string('logo_url')->nullable();
            $table->text('description')->nullable();
            $table->enum('ats_type', ['greenhouse', 'lever', 'ashby', 'workable', 'smartrecruiters', 'generic'])->default('generic');
            $table->string('career_page_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('scraping_allowed')->default(true);         // robots.txt / ToS check result
            $table->timestamp('opt_out_requested_at')->nullable();      // company asked to be removed
            $table->timestamp('last_crawled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
