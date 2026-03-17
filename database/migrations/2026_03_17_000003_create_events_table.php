<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('template_id')->constrained()->cascadeOnDelete();
            $table->string('groom_name');
            $table->string('bride_name');
            $table->date('event_date');
            $table->time('event_time')->nullable();
            $table->string('venue_name');
            $table->string('venue_address')->nullable();
            $table->string('venue_map_link')->nullable();
            $table->string('subdomain')->unique()->nullable();
            $table->json('custom_data')->nullable();
            $table->string('password')->nullable();
            $table->string('password_hint')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
