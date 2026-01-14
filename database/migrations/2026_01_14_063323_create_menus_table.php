<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('title');          // মেনু শিরোনাম
            $table->string('slug')->unique(); // URL slug (Bangla allowed)
            $table->foreignId('parent_id')->nullable()->constrained('menus')->nullOnDelete(); // সাবমেনু
            $table->text('content')->nullable(); // বিস্তারিত বর্ণনা (Summernote)
            $table->string('main_image')->nullable(); // Optional main image
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true); // সক্রিয় / নিষ্ক্রিয়
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
