<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();

            // Attachment (image or pdf)
            $table->string('attachment')->nullable();
            // e.g. notices/abc.jpg OR notices/xyz.pdf

            $table->enum('attachment_type', ['image', 'pdf'])->nullable();

            $table->boolean('is_active')->default(true);

            // Optional: useful for frontend sorting later
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
