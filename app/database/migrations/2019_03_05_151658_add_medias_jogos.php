<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMediasJogos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jogos', function (Blueprint $table) {        
            $table->double('ht35_media_favor_casa',8,2)->nullable();
            $table->double('ht35_media_favor_fora',8,2)->nullable();
            $table->double('ht35_media_contra_casa',8,2)->nullable();
            $table->double('ht35_media_contra_fora',8,2)->nullable();
            $table->integer('ht38')->nullable();
            $table->double('ht38_media_favor_casa',8,2)->nullable();
            $table->double('ht38_media_favor_fora',8,2)->nullable();
            $table->double('ht38_media_contra_casa',8,2)->nullable();
            $table->double('ht38_media_contra_fora',8,2)->nullable();
            $table->double('ht10_media_favor_casa',8,2)->nullable();
            $table->double('ht10_media_favor_fora',8,2)->nullable();
            $table->double('ht10_media_contra_casa',8,2)->nullable();
            $table->double('ht10_media_contra_fora',8,2)->nullable();
            $table->double('ht1_media_favor_casa',8,2)->nullable();
            $table->double('ht1_media_favor_fora',8,2)->nullable();
            $table->double('ht1_media_contra_casa',8,2)->nullable();
            $table->double('ht1_media_contra_fora',8,2)->nullable();
            $table->double('ht2_media_favor_casa',8,2)->nullable();
            $table->double('ht2_media_favor_fora',8,2)->nullable();
            $table->double('ht2_media_contra_casa',8,2)->nullable();
            $table->double('ht2_media_contra_fora',8,2)->nullable();
            $table->double('ft_media_favor_casa',8,2)->nullable();
            $table->double('ft_media_favor_fora',8,2)->nullable();
            $table->double('ft_media_contra_casa',8,2)->nullable();
            $table->double('ft_media_contra_fora',8,2)->nullable();
            $table->double('ft75_media_favor_casa',8,2)->nullable();
            $table->double('ft75_media_favor_fora',8,2)->nullable();
            $table->double('ft75_media_contra_casa',8,2)->nullable();
            $table->double('ft75_media_contra_fora',8,2)->nullable();
            $table->double('ft82_media_favor_casa',8,2)->nullable();
            $table->double('ft82_media_favor_fora',8,2)->nullable();
            $table->double('ft82_media_contra_casa',8,2)->nullable();
            $table->double('ft82_media_contra_fora',8,2)->nullable();
            $table->integer('ft88')->nullable();
            $table->double('ft88_media_favor_casa',8,2)->nullable();
            $table->double('ft88_media_favor_fora',8,2)->nullable();
            $table->double('ft88_media_contra_casa',8,2)->nullable();
            $table->double('ft88_media_contra_fora',8,2)->nullable();        
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
