<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('takedown_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('job_listing_id')->nullable()->constrained()->nullOnDelete();
            $table->string('requester_email');
            $table->text('reason')->nullable();
            $table->enum('status', ['pending', 'actioned', 'rejected'])->default('pending');
            $table->timestamp('actioned_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('takedown_requests');
    }
};
