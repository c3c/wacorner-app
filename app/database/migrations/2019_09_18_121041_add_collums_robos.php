<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCollumsRobos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('robos', function (Blueprint $table) {
            $table->decimal('media_total_estrategia_favorito', 8, 2)->default(0);        
            $table->decimal('media_favor_estrategia_favorito', 8, 2)->default(0);        
            $table->decimal('media_contra_estrategia_favorito', 8, 2)->default(0);
            $table->decimal('media_total_estrategia_zebra', 8, 2)->default(0);        
            $table->decimal('media_favor_estrategia_zebra', 8, 2)->default(0);        
            $table->decimal('media_contra_estrategia_zebra', 8, 2)->default(0);        
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
