<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gallery_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');          // ইভেন্ট নাম
            $table->string('slug')->unique(); // URL slug (English)
            $table->text('description')->nullable(); // Optional
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_events');
    }
};
