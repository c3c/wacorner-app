<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGestaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestoes', function (Blueprint $table) {
            $table->increments('id');
            $table->double('stake', 8, 2)->default(25.00);
            $table->double('lucro', 8, 2);
            $table->double('banca_inicial', 8, 2)->default(1000.00);
            $table->double('valor_investido', 8, 2)->default(0.00);
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                  ->references('id')->on('users')
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
        Schema::dropIfExists('gestaos');
    }
}
