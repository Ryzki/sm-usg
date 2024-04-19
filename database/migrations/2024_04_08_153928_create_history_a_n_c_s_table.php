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
        Schema::create('history_ancs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('visit_id');
            $table->date('inspection_date');
            $table->integer('age');
            $table->integer('gestational_age');
            $table->float('weight');
            $table->integer('height');
            $table->integer('lila');
            $table->integer('sistolik'); //Tekanan Darah Pertama
            $table->integer('diastolik'); //Tekana Darah Kedua
            $table->float('hemoglobin_level');
            $table->string('usg_img');
            $table->integer('stat_skrining_preklampsia'); //1: Resiko Rendah (Tidak ada Skrining Preklamsia), 2: Resido Sedang (ada 1 History Skrining preklamsia dengan kategori Sedang), 3: Resiko Tinggi (min ada 2 Kategori Preklamsia dengan Resiko Sedang atau 1 Kategori dengan resiko Tinggi)
            $table->foreignId('history_skrining_preklampsia_code'); //Nanti ini relasikan dengan kolom code_patient di table Patient_preeclamsia_screenings
            $table->text('note');
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
        Schema::dropIfExists('history_ancs');
    }
};
