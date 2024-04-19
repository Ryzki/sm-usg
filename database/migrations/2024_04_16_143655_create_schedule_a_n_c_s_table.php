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
        Schema::create('schedule_ancs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('visit_id');
            $table->date('schedule_date');
            $table->boolean('status'); //false: Belum melakukan Pertemuan, true: Sudah melakukan Pertemuan 
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
        Schema::dropIfExists('schedule_ancs');
    }
};
