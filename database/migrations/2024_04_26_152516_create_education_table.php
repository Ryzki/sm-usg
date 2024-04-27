<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id');
            $table->foreignId('category_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('thumbnail');
            $table->string('content_img')->nullable();
            $table->longText('content_text')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('education');
    }
};
