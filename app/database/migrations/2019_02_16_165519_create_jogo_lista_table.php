<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJogoListaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jogo_lista', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jogo_id')->unsigned();
            $table->integer('lista_id')->unsigned();
            $table->foreign('jogo_id')
                  ->references('id')->on('jogos')
                  ->onDelete('cascade');
            $table->foreign('lista_id')
                  ->references('id')->on('listas')
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
        Schema::dropIfExists('jogo_lista');
    }
}
