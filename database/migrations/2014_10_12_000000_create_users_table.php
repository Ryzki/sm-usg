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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('role_id');
            $table->boolean('verified')->default(false);
            $table->string('nik', 16)->unique()->nullable(); //Nomer Induk Kependudukan
            $table->string('phone_number', 15)->nullable(); //Nomer Handphone (Yang bisa dihubungi)
            $table->string('place_of_birth')->nullable(); //Tanggal Lahir
            $table->date('date_of_birth')->nullable(); //Tanggal Lahir
            $table->string('home_address')->nullable(); //Alamat
            $table->integer('NA')->nullable(); //Neighborhood Association / RT 
            $table->integer('RA')->nullable(); //Residential Association / RW
            $table->string('subdistrict')->nullable(); // Kelurahan / Desa
            $table->string('district')->default('Tembalang'); //Kecamatan
            $table->string('city')->default('Kota Semarang'); //Kota
            $table->integer('midwife_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
