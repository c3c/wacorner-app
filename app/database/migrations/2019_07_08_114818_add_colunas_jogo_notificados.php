<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColunasJogoNotificados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jogo_notificados', function (Blueprint $table) {
            
            $table->integer('robo_id')->unsigned();
            $table->string('status')->defaul('nova');
            $table->foreign('robo_id')
                  ->references('id')->on('robos')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
