<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerdinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perdins', function (Blueprint $table) {
            $table->id('id');
            $table->string('username',20);
            $table->unsignedSmallInteger('id_kota_asal');
            $table->unsignedSmallInteger('id_kota_tujuan');
            $table->date('tgl_berangkat');
            $table->date('tgl_kembali');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('username')->references('username')->on('users')->onUpdate('cascade')->onDelete('cascade');;
            $table->foreign('id_kota_asal')->references('id')->on('kotas')->onUpdate('cascade')->onDelete('cascade');;
            $table->foreign('id_kota_tujuan')->references('id')->on('kotas')->onUpdate('cascade')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perdins');
    }
}
