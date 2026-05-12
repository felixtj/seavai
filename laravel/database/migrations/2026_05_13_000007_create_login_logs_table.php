<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('email')->nullable();                         // capture even failed attempts
            $table->enum('event', ['login_success', 'login_failed', 'logout', 'google_login', 'password_reset']);
            $table->string('ip_address', 45)->nullable();
            $table->string('country', 2)->nullable();                   // geo lookup later if needed
            $table->text('user_agent')->nullable();
            $table->string('device_type', 20)->nullable();              // desktop / mobile / tablet
            $table->timestamp('created_at');                            // no updated_at — logs are immutable
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_logs');
    }
};
