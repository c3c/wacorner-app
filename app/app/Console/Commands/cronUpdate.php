<?php

namespace App\Console\Commands;

use App\Repositories\UpdateRepository as Update;
use Illuminate\Console\Command;
class cronUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:tudo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualizar jogos';

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
        $update->buscarDadosAPI();     
    }
}
