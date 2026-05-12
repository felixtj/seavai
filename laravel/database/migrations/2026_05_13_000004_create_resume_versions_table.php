<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resume_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->constrained()->cascadeOnDelete();
            $table->enum('version_type', ['original', 'ai-draft', 'human-reviewed', 'final']);
            $table->json('content_json')->nullable();
            $table->longText('generated_content')->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('docx_path')->nullable();
            $table->enum('created_by', ['candidate', 'ai', 'coach'])->default('ai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resume_versions');
    }
};
