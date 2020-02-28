<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailPertanyaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pertanyaan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pertanyaan_id')->unsigned();
            $table->foreign('pertanyaan_id')
                ->references('id')->on('registrasi_paket');
            $table->string('pertanyaan');
            $table->string('j1')-> nullable();
            $table->string('j2')-> nullable();
            $table->string('j3')-> nullable();
            $table->string('j4')-> nullable();
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
        Schema::dropIfExists('detail_pertanyaan');
    }
}
