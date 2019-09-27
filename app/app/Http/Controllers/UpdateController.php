<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Update;
use App\Models\Jogo;
use App\Models\Liga;
use App\Models\Time;
use App\Models\Evento;
use DateTime;
use DateInterval;
use DB;
class UpdateController extends Controller
{
	public function all(){
		$update = new Update;
		$update->old();
	}

	public function listaJogosBot(){
		$update = new Update;
		$update->enviarJogosParaBot();
	}
}
