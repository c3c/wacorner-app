<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jogos', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('start');
            $table->integer('ht35');
            $table->integer('ht10');
            $table->integer('ht1');
            $table->integer('ht2');
            $table->integer('ft');
            $table->integer('ft75');
            $table->integer('ft82');
            $table->integer('over7');
            $table->integer('over8');
            $table->integer('over9');
            $table->integer('over10');
            $table->integer('over11');
            $table->integer('over12');
            
            $table->integer('liga_id')->unsigned();            
            $table->foreign('liga_id')
                  ->references('id')->on('ligas')
                  ->onDelete('cascade');

            $table->integer('time_casa_id')->unsigned(); 
            $table->foreign('time_casa_id')
                  ->references('id')->on('times')
                  ->onDelete('cascade');

            $table->integer('time_fora_id')->unsigned(); 
            $table->foreign('time_fora_id')
                  ->references('id')->on('times')
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
        Schema::dropIfExists('jogos');
    }
}
