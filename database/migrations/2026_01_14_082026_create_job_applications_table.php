<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_circular_id')->constrained('job_circulars')->onDelete('cascade');
            $table->string('name');              // Candidate Name
            $table->string('email')->nullable(); // Candidate Email
            $table->string('phone')->nullable(); // Candidate Phone
            $table->string('resume')->nullable(); // Resume file
            $table->string('cover_letter')->nullable(); // Optional file
            $table->enum('status', ['applied','shortlisted','rejected','selected'])->default('applied');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_applications');
    }
}
