<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Manter Seeders em produção
        $this->call(UsersTableSeeder::class);
        $this->call(UpdatesTableSeeder::class);

        //Somente para teste - comentar quando for para produção
         // $this->call(LigasTableSeeder::class);
         // $this->call(TimesTableSeeder::class);
         // $this->call(JogosTableSeeder::class);
         // $this->call(EventosTableSeeder::class);
    }
}
