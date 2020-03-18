<?php

use Illuminate\Database\Seeder;
use App\Models\Liga;
class LigasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Liga::create([
        	'l'=>'Liga de teste',
            'ativo' => '1',
            'l_id' => '1',
            'cantos' => 11,
        ]);
    }
}
