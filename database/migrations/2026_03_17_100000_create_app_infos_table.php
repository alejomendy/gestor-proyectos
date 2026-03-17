<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('app_infos', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // identifier used by Next.js (e.g. 'hero', 'about', 'services')
            $table->string('title');
            $table->string('img_head')->nullable();  // header image (S3 URL or path)
            $table->text('excerpt')->nullable();     // short teaser text
            $table->longText('body')->nullable();    // full rich content
            $table->boolean('active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_infos');
    }
};
