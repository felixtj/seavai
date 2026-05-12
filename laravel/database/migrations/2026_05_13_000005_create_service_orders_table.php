<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('resume_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('tier', ['basic', 'pro', 'premium']);
            $table->enum('status', ['pending', 'paid', 'in-progress', 'complete', 'refunded'])->default('pending');
            $table->string('stripe_payment_intent_id')->nullable();
            $table->string('stripe_session_id')->nullable();
            $table->unsignedInteger('amount_cents')->nullable();
            $table->string('currency', 3)->default('AUD');
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};
