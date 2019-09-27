<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Jogo;
use App\Models\Liga;
use App\Models\Time;
use App\Models\Evento;
use App\Models\Live;
use DateTime;
use DateInterval;
use DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\Gestao;

class AdminController extends Controller
{
    public $minutes = 5;
    public $jogo;

    public function __construct(){
        $this->jogo = new Jogo();
    }

    public function estrategias(){
        return view('admin.estrategias');
    }


    public function index()
    {
      $usuario = auth()->user();
      //CRIA A GESTÃO CASO NÃO TENHA UMA AINDA
      if($usuario->gestao == null){
        Gestao::create([
        'banca_inicial' => 1000.00,
        'stake' => 10.00,
        'user_id' => auth()->user()->id,
        'valor_investido' => 0.00,
        'lucro' => 0.0
        ]);

        return redirect()->route('admin.home');
      }

      if($usuario->aviso_expiracao()){
        $data_expiracao = new Carbon($usuario->data_expiracao);
        $data_hj = new Carbon(date('Y-m-d')); 

        $dias_para_expirar = $data_hj->diffInDays($data_expiracao);

      }else{
        $dias_para_expirar = -1;
      }
      
      return view('admin.home.index',compact('dias_para_expirar'));      
    }

    public function index_amanha(Jogo $jogo){

      return view('admin.home.amanha');
    }

    public function jogos($data)
    {

      if (!(Cache::has('jogos_'.$data))) {
        $jogos_aux = Jogo::where('start','like','%'.$data.'%')->orderBy('start','asc')->get()->load('time_casa','time_fora','liga');
        Cache::forget('jogos_'.$data);
        Cache::put('jogos_'.$data,$jogos_aux,$this->minutes);
      }

          
        return Cache::get('jogos_'.$data);
    }

    public function indexEstrategia($estrategia,$data = null)
    {   
        $estrategia = $estrategia;
        $data = $data != 'hoje' ? $data : date('Y-m-d');
          
        return view('admin.estrategias.index', compact('estrategia','data'));
    }

    public function jogosEstrategia($estrategia,$data)
    {   
        
        $jogos = Jogo::whereDate('start',$data)->select('id','start','time_casa_id','time_fora_id','ft','liga_id','n_jogos_casa','n_jogos_fora', $estrategia.' as probabilidade',$estrategia.'_casa as probabilidade_casa',$estrategia.'_fora as probabilidade_fora')->orderBy($estrategia,'desc')->get()->load('time_casa','time_fora','liga');

        return $jogos;
    }

    public function jogosEstrategiaFiltro($estrategia,$data,$min_jogos,$porcentagem){
        $jogos = Jogo::whereDate('start',$data)->where($estrategia,'>=',$porcentagem)->select('id','start','time_casa_id','time_fora_id','ft','liga_id', $estrategia.' as probabilidade')->orderBy($estrategia,'desc')->get();
        $jogos = $this->jogo->jogos_validos($jogos,$min_jogos);

        return $jogos;
    }

    public function live()
    {

      return view('admin.live.index');
    }

    public function jogosAoVivo(Request $r){
      if (Cache::has('lives')) {
        return Cache::get('lives');
      }else{
        return [];
      }
    }

    public function liveSearch(Request $r,Jogo $j){

      if ($r->ajax())
      {
        $saida = '';
        $ok = false;
        $estrategia = $r->get('estrategia');
        $porcentagem = $r->get('porcentagem');
        $n_jogos = $r->get('n_jogos') == ''? 0:$r->get('n_jogos');
        $jogos_live = Cache::get('lives');
          foreach ($jogos_live as $key => $live) {
            if($j->verificaNJogos($live->jogo,$n_jogos)){
              if ($estrategia == 'ht10' )
                if ($live->jogo->ht10 > $porcentagem && intval($live->tempo) <=10 && $live->tempo != 'half')
                  $ok = true;

              if ($estrategia == 'ht35' )
                if ($live->jogo->ht35 > $porcentagem && intval($live->tempo) <=45 && $live->tempo != 'half')
                  $ok = true;

              if ($estrategia == 'ht38' )
                if ($live->jogo->ht38 > $porcentagem && intval($live->tempo) <=45 && $live->tempo != 'half')
                  $ok = true;
              
              if ($estrategia == 'ft75' )
                if ($live->jogo->ft75 > $porcentagem && intval($live->tempo) <=80)
                  $ok = true;
              
              if ($estrategia == 'ft82' )
                if ($live->jogo->ft82 > $porcentagem && intval($live->tempo) <=90)
                  $ok = true;

              if ($estrategia == 'ft88' )
                if ($live->jogo->ft88 > $porcentagem && intval($live->tempo) <=90)
                  $ok = true;

              if ($estrategia == '')
                  $ok = true;
            }

            if ($ok)
            {
              $ok = false;
              $saida .='
                <tr style="height: 40px;">
                      <td c>'.$live->jogo->liga->l.'</td>
                      <td c>'.$live->c_casa.' - '.$live->c_fora.'</td>

                      <td c>
                        <button class="btn btn-xs btn-primary flash">
                          ';
                          if($live->tempo == 'half')
                            $saida .= 'HT';
                          else
                            $saida .= $live->tempo."'";
                        $saida.='
                        </button>
                      </td>
                        <td>
                          <strong>
                            <a style="color: #000;" href="'.route('admin.jogo',['id'=>$live->jogo->id]).'">
                              '.$live->jogo->time_casa->nome.' <button class="btn btn-xs btn-danger">'.$live->r_casa.'</button> x <button class="btn btn-xs btn-danger">'.$live->r_fora.'</button> '.$live->jogo->time_fora->nome.'
                            </a>
                          </strong>
                          <div class="progress" style=" position: relative;">
                            <div class="progress-bar progress-bar-success" role="progressbar" style="width:';
                            if($live->tempo == 'half') 
                              $saida .= '45%'; 
                            else 
                              $saida .= intval($live->tempo).'%'; 

                            $saida .='; position: absolute; height: 50%; margin-top: 10px;" aria-valuenow="';

                            if($live->tempo == 'half')
                              $saida.='45';
                            else
                              $saida.=intval($live->tempo).'';
                            
                            $saida.='" aria-valuemin="0" aria-valuemax="100">
                            </div>';
                            if(Cache::get('eventos_'.$live->jogo_id)!=null)
                            {
                            foreach(Cache::get('eventos_'.$live->jogo_id) as $evento)
                              if($evento->casa == 1)
                                $saida.='<img src="'.asset('assets/images/corner-home.png').'" title="'.$evento->t.' - '.$live->jogo->time_casa->nome.'" style="position: absolute; left: '.intval($evento->t).'%; width: 20px;">';
                              else
                                $saida.='<img src="'.asset('assets/images/corner-aways.png').'" title="'.$evento->t.' - '.$live->jogo->time_fora->nome.'" style="position: absolute; left: '.intval($evento->t).'%; width: 20px;">';
                            }
                            $saida.='

                          </div>
                          <div class="progress-bar progress-bar-warning" role="progressbar" style="width:45%; height:10%; border-right:1px solid #fff;">1º Tempo</div>
                          <div class="progress-bar progress-bar-warning" role="progressbar" style="width:45%; height:10%;">2º Tempo</div>
                        </td>
                        <td><span class="badge bg-green">'.$live->jogo->ht10.'%</span></td>
                        <td><span class="badge bg-green">'.$live->jogo->ht35.'%</span></td>
                        <td><span class="badge bg-green">'.$live->jogo->ht38.'%</span></td>
                        <td><span class="badge bg-green">'.$live->jogo->ft75.'%</span></td>
                        <td><span class="badge bg-green">'.$live->jogo->ft82.'%</span></td>
                        <td><span class="badge bg-green">'.$live->jogo->ft88.'%</span></td>
                        <td ><span class="badge bg-green">'.$live->jogo->ft.' cantos</span></td>
                    </tr>
              ';
            }
          }
          
        $data = array(
          'table_data' => $saida,
        );

        echo json_encode($data);
      }
    }    
}
