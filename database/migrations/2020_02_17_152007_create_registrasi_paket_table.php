<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrasiPaketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrasi_paket', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('id')->on('users');
            $table->integer('paket_id')->unsigned();
            $table->foreign('paket_id')
            ->references('id')->on('jenis_paket');
            $table->string('name');
            $table->string('email', 50)->unique();
            $table->integer('jumlah_responden');
            $table->string('judul');
            $table->string('deskripsi');
            $table->decimal('amount', 20, 2)->default(0);
            $table->string('status')->default('pending');
            $table->string('snap_token')->nullable();
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
        Schema::dropIfExists('registrasi_paket');
    }
}
