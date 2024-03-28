<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('midwife_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('midwife_id'); //Relasi ke UserTable dengan Role BIDAN
            $table->foreignId('area_id'); // Relasi ke AreaTable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('midwife_areas');
    }
};
