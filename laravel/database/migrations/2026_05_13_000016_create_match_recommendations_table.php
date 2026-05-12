<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('match_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_batch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_listing_id')->constrained()->cascadeOnDelete();
            $table->decimal('score', 4, 3);                             // 0.000 – 1.000
            $table->json('score_breakdown');                            // {layer1, layer2, layer3, layer4}
            $table->json('score_label_breakdown')->nullable();          // human-readable "why this matched"
            $table->enum('status', ['pending', 'sent', 'seen', 'saved', 'applied', 'dismissed'])->default('pending');
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_recommendations');
    }
};
