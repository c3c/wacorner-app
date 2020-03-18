<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRobosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('robos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('user_id')->unsigned();
            $table->integer('status');
            $table->integer('intervalo_inicio');
            $table->integer('intervalo_fim');
            $table->string('situacao');
            $table->integer('diferenca_gols');
            $table->integer('superioridade');
            $table->integer('qtd_min_jogos_casa');
            $table->integer('qtd_min_jogos_fora');
            $table->integer('porcentagem_min_casa');
            $table->integer('porcentagem_min_fora');
            $table->integer('escanteios_min');
            $table->timestamps();


            $table->foreign('user_id')
                  ->references('id')->on('users');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('robos');
    }
}
