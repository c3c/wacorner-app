<?php

use Illuminate\Database\Seeder;
use App\Models\Liga;
use App\Models\Time;
class TimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     	$time1 = Time::create([
     		'nome'=>'Time A',
            'cantos' => 12,
     	]);

     	$time2 = Time::create([
     		'nome'=>'Time B',
            'cantos' => 11,
     	]);
     
     	$liga = Liga::find('1');

     	$liga->times()->attach([
     		$time1->id,
     		$time2->id,
     	]);  
    }
}
