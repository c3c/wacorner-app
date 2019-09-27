<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHt1020Jogos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jogos', function (Blueprint $table) {
            $table->integer('ht1020')->nullable();
            $table->double('ht1020_media_favor_casa',8,2)->nullable();
            $table->double('ht1020_media_favor_fora',8,2)->nullable();
            $table->double('ht1020_media_contra_casa',8,2)->nullable();
            $table->double('ht1020_media_contra_fora',8,2)->nullable();
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
