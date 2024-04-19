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
        Schema::create('preeclampsia_screenings', function (Blueprint $table) {
            $table->id();
            $table->string('screening_name');
            $table->integer('risk_category'); //1: Risiko Sedang, 2: Resiko Tinggi
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('preeclampsia_screenings');
    }
};
