<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->string('tagline')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('email1')->nullable();
            $table->string('email2')->nullable();
            $table->text('address')->nullable();
            $table->string('footer_text')->nullable();
            $table->string('google_map_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('general_settings');
    }
};
