<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\UpdateRepository as Update;
use Illuminate\Support\Facades\Cache;
class SearchAoVivo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:aovivo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Buscar jogos ao vivo';

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
        $update->buscarDadosDeJogosAoVivoAPI();
    }
}
