<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Jogo;
use App\Models\Time;
use Illuminate\Support\Facades\Cache;

class JogoController extends Controller
{
    public $jogo;
    public $jogos_casa;
    public $jogos_fora;

    public function index(Jogo $jogo_aux,$id){

    	$jogo = Jogo::find($id);
        $this->jogo = $jogo;
                
        $minutes = 10;

        $jogos_casa = Cache::remember('jogos_casa'.$id,$minutes, function () {
            return $this->jogo->time_casa->jogos_casa()->whereDate('start','<',date('Y-m-d'))->where('id','!=',$this->jogo->id)->take(10)->get();
        });
        $this->jogos_casa = $jogos_casa;

        $ht_ft_casa = Cache::remember('ht_ft_casa'.$id,$minutes, function () {
            return $this->jogo->ht_ft($this->jogos_casa);
        });

        

        $jogos_fora = Cache::remember('jogos_fora'.$id,$minutes, function () {
            return $this->jogo->time_fora->jogos_fora()->whereDate('start','<',date('Y-m-d'))->where('id','!=',$this->jogo->id)->take(10)->get();
        });
        $this->jogos_fora = $jogos_fora;

        $ht_ft_fora = Cache::remember('ht_ft_fora'.$id,$minutes, function () {
            return $this->jogo->ht_ft($this->jogos_fora);
        });



    	return view('admin.jogo.index',compact('jogo','jogos_casa','jogos_fora','ht_ft_casa','ht_ft_fora'));
    }
}
