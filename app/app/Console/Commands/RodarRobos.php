<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\RoboRepository as Robo;

class RodarRobos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'robos:rodar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executar robôs wacorner ';

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
        $robo = new Robo();
        $robo->rodarRobos();
    }
}
