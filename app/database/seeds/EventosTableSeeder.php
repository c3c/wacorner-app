<?php

use Illuminate\Database\Seeder;
use App\Models\Evento;

class EventosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Evento::create(['t' => '2', 'casa' => 1, 'jogo_id' => 1]);
        Evento::create(['t' => '10', 'casa' => 0, 'jogo_id' => 1]);
        Evento::create(['t' => '13', 'casa' => 0, 'jogo_id' => 1]);
        Evento::create(['t' => '24', 'casa' => 1, 'jogo_id' => 1]);
        Evento::create(['t' => '45+2', 'casa' => 0, 'jogo_id' => 1]);
        Evento::create(['t' => '58', 'casa' => 1, 'jogo_id' => 1]);
        Evento::create(['t' => '76', 'casa' => 0, 'jogo_id' => 1]);
        Evento::create(['t' => '77', 'casa' => 0, 'jogo_id' => 1]);
        Evento::create(['t' => '81', 'casa' => 1, 'jogo_id' => 1]);
        Evento::create(['t' => '90+1', 'casa' => 0, 'jogo_id' => 1]);
        
    }
}
