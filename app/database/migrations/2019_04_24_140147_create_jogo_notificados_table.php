<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJogoNotificadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jogo_notificados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('estrategia')->nullable();
            $table->integer('jogo_id')->unsigned();
            $table->foreign('jogo_id')
                  ->references('id')->on('jogos')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('jogo_notificados');
    }
}
