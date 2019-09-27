<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\UpdateRepository as Update;

class SendListaBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:lista';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manda lista de jogos para o telegram do proximo dia';

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
        $update->enviarJogosParaBot();
    }
}
