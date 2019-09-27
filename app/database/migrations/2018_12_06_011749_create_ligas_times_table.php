<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLigasTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liga_time', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('liga_id')->unsigned();
            $table->integer('time_id')->unsigned();
            
            $table->foreign('liga_id')
                  ->references('id')->on('ligas')
                  ->onDelete('cascade');
            $table->foreign('time_id')
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
        Schema::dropIfExists('liga_time');
    }
}
