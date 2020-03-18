<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLigasTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('liga_time', function (Blueprint $table) {
            
            $table->integer('posicao')->nullable();
            $table->integer('jogos')->nullable();
            $table->integer('vitorias')->nullable();
            $table->integer('empates')->nullable();
            $table->integer('derrotas')->nullable();
            $table->integer('pontos')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
