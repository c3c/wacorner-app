<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Jogo;
use App\Models\Liga;
use App\Models\Time;
use DB;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\Cache;
class EstatisticasController extends Controller
{   
    public $totalPage = 10;
    public $minutes = 10;
    
    public function jogosEstatisticas($estatistica,$data){
        $jogos = Jogo::whereDate('start',$data)->select('id','start','time_casa_id','time_fora_id','ft','liga_id','n_jogos_casa','n_jogos_fora', $estatistica.' as probabilidade',$estatistica.'_casa as probabilidade_casa',$estatistica.'_fora as probabilidade_fora','over9')->orderBy($estatistica,'desc')->get()->load('time_casa','time_fora','liga');

        return $jogos;
    }

    public function index($estatistica,$data = null){
       
        $data = $data != 'hoje' ? $data : date('Y-m-d');
          
        
        return view('admin.estatisticas.index',compact('estatistica','data'));
    }

    public function lista_over_liga(Liga $liga){

        if(!Cache::has('jogos_ligas_over'))
          Cache::put('jogos_ligas_over',$liga->orderBy('cantos','desc')->where('ativo',1)->take(100)->get(),60);

        $ligas = Cache::get('jogos_ligas_over');
        $ligas_validas = [];

        foreach ($ligas as $key => $liga) {
            if($liga->jogos->count()>30 && sizeof($ligas_validas)<10){
                $ligas_validas[$key] = $liga;
            }

        }
        
        $ligas = $ligas_validas;

        return view('admin.over.ligas',compact('ligas'));
    }
    public function lista_over_time(Time $time){

        if(!Cache::has('jogos_times_over'))
          Cache::put('jogos_times_over',$time->orderBy('cantos','desc')->take(10)->get(),60);

        $times = Cache::get('jogos_times_over');
        
        return view('admin.over.times',compact('times'));
    }

}
