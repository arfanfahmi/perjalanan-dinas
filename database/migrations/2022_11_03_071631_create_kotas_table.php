<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kotas', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('nama_kota',50);
            $table->unsignedSmallInteger('id_provinsi');
            $nama_pulau = ['Sumatera', 'Jawa', 'Kalimantan', 'Sulawesi','Papua','Bali','Lombok','Timor', 'Halmahera', 'Ambon'];
            $table->smallInteger("id_pulau")->unsigned()->nullable();
            $table->string('latitude',20)->nullable();
            $table->string('longitude', 20)->nullable();
            $table->enum('ln', ['Y','N']);
            $table->timestamps();

            $table->foreign('id_provinsi')->references('id')->on('provinsis')->onUpdate('cascade')->onDelete('cascade');;
            $table->foreign('id_pulau')->references('id')->on('pulaus')->onUpdate('cascade')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kotas');
    }
}
