<?php

use Illuminate\Database\Seeder;
use App\Update;
class UpdatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Update::create([
        	'pag' => '1',
        	'data' => '20180101',
        ]);
    }
}
