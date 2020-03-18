<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entradas', function (Blueprint $table) {
            $table->increments('id');
            $table->double('stake', 8, 2);
            $table->double('odd', 8, 2);
            $table->enum('resultado',['pendente','green','red','neutro'])->default('pendente');
            $table->integer('gestao_id')->unsigned();
            $table->foreign('gestao_id')
                  ->references('id')->on('gestoes')
                  ->onDelete('cascade');
            $table->integer('estrategia_id')->unsigned();
            $table->foreign('estrategia_id')
                  ->references('id')->on('estrategias')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('entradas');
    }
}
