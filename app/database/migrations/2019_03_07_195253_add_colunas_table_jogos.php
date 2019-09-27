<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColunasTableJogos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jogos', function (Blueprint $table) {
            $table->integer('ht1_casa')->nullable();
            $table->integer('ht1_fora')->nullable();
            $table->integer('ht10_casa')->nullable();
            $table->integer('ht10_fora')->nullable();
            $table->integer('ht35_casa')->nullable();
            $table->integer('ht35_fora')->nullable();
            $table->integer('ht38_casa')->nullable();
            $table->integer('ht38_fora')->nullable();
            $table->integer('ht2_casa')->nullable();
            $table->integer('ht2_fora')->nullable();
            $table->integer('ft_casa')->nullable();
            $table->integer('ft_fora')->nullable();
            $table->integer('ft75_casa')->nullable();
            $table->integer('ft75_fora')->nullable();
            $table->integer('ft82_casa')->nullable();
            $table->integer('ft82_fora')->nullable();
            $table->integer('ft88_casa')->nullable();
            $table->integer('ft88_fora')->nullable();
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
