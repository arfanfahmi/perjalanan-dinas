<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_perdin')->unsigned();
            $table->enum('status',['diajukan','disetujui','ditolak']);
            $table->date('tgl_approval')->nullable();
            $table->timestamps();

            $table->foreign('id_perdin')->references('id')->on('perdins')->onUpdate('cascade')->onDelete('cascade');
            //$table->foreign('approver')->references('username')->on('users')->onUpdate('cascade')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('approvals');
    }
}
