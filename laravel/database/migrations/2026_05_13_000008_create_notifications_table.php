<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Laravel's standard polymorphic notifications table
        // Supports in-app bell icon + email delivery
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');                     // e.g. App\Notifications\ResumeParsed
            $table->morphs('notifiable');               // notifiable_type + notifiable_id (User)
            $table->text('data');                       // JSON payload — title, message, action URL
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
