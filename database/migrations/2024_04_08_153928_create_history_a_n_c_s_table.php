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
            $table->float('height');
            $table->float('lila');
            $table->integer('sistolik'); //Tekanan Darah Pertama
            $table->integer('diastolik'); //Tekana Darah Kedua
            $table->float('hemoglobin_level');
            $table->boolean('tetanus_toxoid');
            $table->integer('fetal_position');
            $table->integer('fetal_heartbeat');
            $table->string('usg_img')->nullable();

            //Parameter LILA < 23.5 cm   //1: Resiko Kehamilan KEK (Kurang Energi Kronik), 0: Tidak
            $table->boolean('stat_risk_pregnancy_of_ced')->default(false);

            //Parameter Sistolik > 140 || Diastolik > 90 //1: Resiko Preklamsia, 0: Tidak
            $table->boolean('stat_risk_preeclamsia')->default(false);

            //Parameter HB < 11 //1: Resiko Anemia , 0: Tidak
            $table->boolean('stat_risk_anemia')->default(false);

            //1: Sehat (Tidak ada Skrining Preklamsia), 2: Resido Sedang (ada 1 History Skrining preklamsia dengan kategori Sedang), 3: Resiko Tinggi (min ada 2 Kategori Preklamsia dengan Resiko Sedang atau 1 Kategori dengan resiko Tinggi)
            $table->integer('stat_skrining_preklampsia')->default(1);

            //Nanti ini relasikan dengan kolom code_patient di table Patient_preeclamsia_screenings
            $table->string('history_skrining_preklampsia_code')->nullable();
            $table->text('note')->nullable();
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
