<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobCircularsTable extends Migration
{
    public function up()
    {
        Schema::create('job_circulars', function (Blueprint $table) {
            $table->id();
            $table->string('title');          // Job title (Bangla)
            $table->string('slug')->unique(); // URL slug (English)
            $table->text('description')->nullable(); // Optional rich text
            $table->string('file')->nullable();      // PDF/Image path
            $table->string('file_type')->nullable(); // 'pdf' or 'image'
            $table->string('department')->nullable();
            $table->integer('vacancy_count')->nullable();
            $table->date('application_deadline');
            $table->date('published_date')->nullable();
            $table->boolean('status')->default(true); // Active / Inactive
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_circulars');
    }
}
