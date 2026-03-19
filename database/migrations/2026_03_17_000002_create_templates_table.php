<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['static', 'website']);
            $table->string('category')->default('wedding');
            $table->string('thumbnail')->nullable();
            $table->string('slug')->unique();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->json('config_schema')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
