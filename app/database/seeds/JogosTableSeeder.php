<?php

use Illuminate\Database\Seeder;
use App\Models\Jogo;
use App\Models\Time;
use App\Models\Liga;
class JogosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $liga = Liga::find(1);
        Jogo::create([
        	'start' => date('Ymd'),
        	'ht35' => 0,
        	'ht10' => 0,
        	'ht1' => 0,
        	'ht2' => 0,
        	'ft' => 0,
        	'ft75' => 0,
        	'ft82' => 0,
        	'over7' => 0,
        	'over8' => 0,
        	'over9' => 0,
        	'over10' => 0,
        	'over11' => 0,
        	'over12' => 0,
            'liga_id' => 1,
            'time_casa_id' => 1,
            'time_fora_id' => 2,
        ]);

    }
}
