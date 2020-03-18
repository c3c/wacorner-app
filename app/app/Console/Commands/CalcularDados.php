<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\UpdateRepository as Update;

class CalcularDados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analises:calcular';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calcular dados dos jogos de amanhã.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $update = new Update;
        $update->calcularDados();   
    }
}
