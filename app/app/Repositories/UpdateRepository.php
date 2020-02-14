<?php
namespace App\Repositories;

use App\Models\Jogo;
use App\Models\Liga;
use App\Models\Time;
use App\Models\Evento;
use App\Models\Live;
use App\Models\JogoNotificado;
use DateTime;
use DateInterval;
use DB;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Telegram;
use App\Update;

class UpdateRepository 
{
    protected $client;
    protected $token_api = "e019efd7a4b24af8";

    public function __construct(){
    
        $this->client = new Client( [
            'headers' => [ 'content-type' => 'application/json', 'Accept' => 'application/json' ],
            'base_uri' => 'https://api.totalcorner.com/v1/'
    	] );
    }

    private function ultimaPaginaBuscada(){

        return Update::all()->last()->pag;
    
    }
    
    private function ultimaDataBuscada(){

        return Update::all()->last()->data;
    
    }
   
    private function jogosComLigasAtivas( $jogos ){

        $jogosValidos = [];
        $jogos = $jogos != null ? $jogos : [];
        foreach ( $jogos as $key => $jogo ) {
            if( $jogo->liga->ativo == 1 ){
                $jogosValidos[$key] = $jogo;
            }
        }

        return $jogosValidos;

    }

    private function adicionarUmDiaData( $data, $formatoDeSaidaData ){

        $data = new DateTime( $data );
        $data->add( new DateInterval( 'P1D' ) );
        $data = $data->format( $formatoDeSaidaData );
            
        return $data;
    }

    private function adicionarDoisDiasData( $data, $formatoDeSaidaData ){
            
        $data = new DateTime( $data );
        $data->add( new DateInterval( 'P2D' ) );
        $data = $data->format( $formatoDeSaidaData );
            
        return $data;
    }

    private function verificarSeExisteDadoNulo( $jogo ){

        return $jogo->h == null || $jogo->h_id == null || $jogo->id == null 
            || $jogo->a == null|| $jogo->a_id == null || $jogo->l == null 
            || $jogo->l_id == null|| $jogo->start == null;
    
    }

    // private function roboOportunidade( $jogo, $dataAuxiliarDoJogo ){
    //     $notificacao = JogoNotificado::where( 'estrategia',$jogo->h." x ".$jogo->a )->first();
                                        
    //     if( $notificacao == null ){
    //         if( $jogo->p_corner[0] != "" ){
    //             if( intval( $jogo->p_corner[0] ) < 8 || $jogo->p_corner[0] == "8.0"){

    //                 Telegram::sendMessage([
    //                     'chat_id' => '-1001231370685', 
    //                     'parse_mode' => 'Markdown',
    //                     'text' => "Jogo: ".$jogo->h." x ".$jogo->a.
    //                             "\nLiga: ".$jogo->l.
    //                             "\nData: ".$dataAuxiliarDoJogo.
    //                             "\nLinha: ".$jogo->p_corner[0],	  
    //                 ]);
    //                 JogoNotificado::create([
    //                     'jogo_id' 		=> 1,
    //                     'estrategia'	=> $jogo->h." x ".$jogo->a,
    //                     'robo_id'       => 1,
    //                     'status'        => 'nova',
    //                 ]);

    //             }
    //         }
    //     }
    // }

   

    private function contarCantos($jogoDaApi){

        $numeroDeCantos = 0;
        $eventos = $jogoDaApi->events != null ? $jogoDaApi->events : [];
        foreach ( $eventos as $evento ) { 
            if( $evento->tp == 'c' ){
                $numeroDeCantos += 1;
            }
        }

        return $numeroDeCantos;
    }

    private function verificarCadastrarEventos($jogoDaApi,$jogoCadastrado,$numeroDeCantos){
        if( !isset( Jogo::find($jogoCadastrado->id)->eventos) || 
            Jogo::find($jogoCadastrado->id)->eventos->count() != $numeroDeCantos ){

            if( Jogo::find($jogoCadastrado->id)->eventos->count() != 0 ){
                foreach( Jogo::find($jogoCadastrado->id)->eventos as $evento ){
                    $evento->delete();
                }
            }
            $eventos = $jogoDaApi->events != null ? $jogoDaApi->events : [];
            foreach ( $eventos as $evento ) { 
                if( $evento->tp == 'c' ){
                    $canto = new Evento();
                    $canto->t = $evento->t;
                    $canto->casa = $evento->h == 'h' ? 1 : 0; 
                    $canto->jogo_id = $jogoCadastrado->id;
                    $canto->save();
                }
            }
        }
    }

    private function superioridade( $jogoAoVivo )
    {
  
        $pontuacaoTimeDaCasa = $jogoAoVivo->ataques[0]+$jogoAoVivo->ataques_perigosos[0]
            +$jogoAoVivo->chutes_no_gol[0]+$jogoAoVivo->chutes_para_fora[0]+$jogoAoVivo->posses[0];
        
        $pontuacaoTimeDeFora = $jogoAoVivo->ataques[1]+$jogoAoVivo->ataques_perigosos[1]
            +$jogoAoVivo->chutes_no_gol[1]+$jogoAoVivo->chutes_para_fora[1]+$jogoAoVivo->posses[1];
  
        if( $pontuacaoTimeDaCasa >= $pontuacaoTimeDeFora && $pontuacaoTimeDaCasa != 0 ){
            return [ round(100 - ( ( $pontuacaoTimeDeFora * 100 ) / $pontuacaoTimeDaCasa ), 1), 'casa' ];
        }else{
            if( $pontuacaoTimeDeFora != 0 )
                return [ round( 100 - ( ( $pontuacaoTimeDaCasa * 100 ) / $pontuacaoTimeDeFora ), 1 ), 'fora' ];
        }
  
        return [ 0, 'casa' ];	
        
    }

    public function calcularDados(){

        $dataHoje = date( 'Y-m-d' );
        $jogos = Jogo::where( 'start', '>=', $dataHoje.' 00:00' )->get();
        $jogos = $this->jogosComLigasAtivas( $jogos );
        if( $jogos != null ){
            $jogo = new Jogo;
            $jogo->calcularEstrategia( $jogos );
        }

    }

    private function tipo($odd){

        if($odd <= 1){
            return null;
        }else if($odd > 1 && $odd<=3){
            return 'F';
        }else{
            return 'S';
        }
    }

    public function buscarDadosAPI( $pagina = null, $numeroDeRequisicoes = 1 ){
        echo $numeroDeRequisicoes;
        $pagina = $pagina != null ? $pagina : $this->ultimaPaginaBuscada();
        $data = $this->ultimaDataBuscada();
        $dadosDaApi = $this->client->request( 'GET', "match/schedule?token=".$this->token_api.
                                                "&date=".$data.
                                                "&columns=events,odds,cornerLine&page=".$pagina );
        if( $numeroDeRequisicoes < 6 ){
            
            $numeroDeRequisicoes += 1 ;    
            
            $jogosDaApi = json_decode( $dadosDaApi->getBody()->getContents() );
            
            if( !isset( $jogosDaApi->success ) || $jogosDaApi->success == 0 ){
            
                echo 'erro';
                return false;
            
            }else{
                $jogosDaApiAuxiliar = $jogosDaApi->data != null ? $jogosDaApi->data : [];
                foreach( $jogosDaApiAuxiliar as $jogoDaApi ) { 
                    if( $this->verificarSeExisteDadoNulo( $jogoDaApi )==false ){
                        
                        $dataDoJogo = new Carbon( $jogoDaApi->start, 'America/Godthab' );
                        $dataDoJogo->setTimeZone( 'America/Fortaleza' );
                        $dataAuxiliarDoJogo = $dataDoJogo; 
                        $dataAuxiliarDoJogo = $dataAuxiliarDoJogo->format( 'd/m/Y H:m' );
                        // if(env('APP_DEBUG') == false){
                        //     $this->roboColombiano( $jogoDaApi, $dataAuxiliarDoJogo );
                        // }
                        $liga = Liga::updateOrCreate(
                            ['l' => $jogoDaApi->l],
                            ['l_id' => "".$jogoDaApi->l_id]
                        );
                                            
                        $timeDaCasa = Time::firstOrCreate([
                            'nome' => $jogoDaApi->h,
                        ]);					
                        
                        $timeDeFora = Time::firstOrCreate([	
                            'nome' => $jogoDaApi->a,
                        ]);						

                        $jogoCadastrado = Jogo::where( 'start', 'like', '%'.date( 'Y-m-d', strtotime($dataDoJogo) ).'%' )
                            ->where( 'liga_id',$liga->id )
                            ->where( 'time_casa_id',$timeDaCasa->id )
                            ->where( 'time_fora_id',$timeDeFora->id )
                            ->first();

                        if( $jogoCadastrado == null ){
                            $jogoCadastrado =Jogo::create([
                                'start' 		=> $dataDoJogo,
                                'ht35'  		=> -1,
                                'ht10'		    => -1,
                                'ht1'			=> -1,
                                'ht2'			=> -1,
                                'ft'			=> -1,
                                'ft75'		    => -1,
                                'ft82'		    => -1,
                                'over7'		    => -1,
                                'over8'		    => -1,
                                'over9'		    => -1,
                                'over10'		=> -1,
                                'over11'		=> -1,
                                'over12'		=> -1,
                                'liga_id'		=> $liga->id,
                                'time_casa_id'  => $timeDaCasa->id,
                                'time_fora_id'  => $timeDeFora->id,
                                'p_casa'		=> isset($jogoDaApi->hp)? $jogoDaApi->hp : null,
                                'p_fora'		=> isset($jogoDaApi->ap)? $jogoDaApi->ap : null,
                            ]);
                            
                        }
                        
                        $difenca_po_odds = $jogoDaApi->po_odds[0] > $jogoDaApi->po_odds[2] ? ($jogoDaApi->po_odds[0] - $jogoDaApi->po_odds[2]) : ($jogoDaApi->po_odds[2] - $jogoDaApi->po_odds[0]);
                        $tipo = $this->tipo($difenca_po_odds);
                        if( $tipo != null ) {
                            $menor_odd = $jogoDaApi->po_odds[0] <= $jogoDaApi->po_odds[2] ? 'casa' : 'fora';
                            if( $tipo == 'F' ) {
                                $jogoCadastrado->favorito = $menor_odd;
                            }else{
                                $jogoCadastrado->super_favorito = $menor_odd;
                            }
                        }

                        $jogoCadastrado->id_api = $jogoDaApi->id;
                        $jogoCadastrado->save(); 
                        $numeroDeCantos = $this->contarCantos($jogoDaApi);

                        $this->verificarCadastrarEventos($jogoDaApi,$jogoCadastrado,$numeroDeCantos);
                    }
                }
                
                if( $jogosDaApi->pagination->next == true && $pagina < $jogosDaApi->pagination->pages ){
                    $pagina +=1;
                    $teste = Update::all()->last();
                    $teste->pag = $pagina;
                    $teste->save();
                    sleep(5);
                    $this->buscarDadosAPI( $pagina, $numeroDeRequisicoes );
                }else{
                    if( $data != $this->adicionarDoisDiasData( date('Y-m-d'), 'Ymd' ) ){
                        $teste = new Update();
                        $teste->pag = 1;
                        $teste->data = $this->adicionarUmDiaData( $data, 'Ymd' );
                        $teste->save();
                        $this->buscarDadosAPI(1,$numeroDeRequisicoes);
                    }else{
                        Update::orderBy('id','desc')->take(4)->delete();
                    }
                }
                return true;
            }
        }else{
            return false;
        }
    }

    public function buscarDadosDeJogosAoVivoAPI( $pagina = 1, $jogosAoVivo = null ){
        
        $jogosAoVivo = $jogosAoVivo != null ? $jogosAoVivo : [];
        
        try{

            $dadosDaApi = $this->client->request( 'GET', "match/today?token=".$this->token_api.
                                                "&type=inplay&columns=events,odds,attacks,dangerousAttacks,
                                                shotOn,shotOff,possession&page=".$pagina);

            $jogosDaApi = json_decode( $dadosDaApi->getBody()->getContents() );
                
            					
            if( !isset( $jogosDaApi->success ) || $jogosDaApi->success == 0 )
            {
                echo "\n ( ".$jogosDaApi->error->code." ) ".$jogosDaApi->error->message;
                sleep( 60 );
                $this->buscarDadosDeJogosAoVivoAPI();
            
            } else {
                
                foreach( $jogosDaApi->data as $jogoDaApi ) { 
                    if ( !Cache::has( 'jogo_id_api'.$jogoDaApi->id ) ) 
                    {
                        Cache::put( 'jogo_id_api'.$jogoDaApi->id, Jogo::where( 'id_api', $jogoDaApi->id )->first(), 90 );
                    }

                    $jogo = Cache::get( 'jogo_id_api'.$jogoDaApi->id );

                    if ( $jogo!=null )
                    {	
                       // dd($jogoDaApi);
                        $jogoAoVivo                     = new Live();
                        $jogoAoVivo->jogo               = $jogo->load( 'liga', 'time_casa', 'time_fora' )
                                                                ->toArray();
                        $jogoAoVivo->tempo              = isset($jogoDaApi->status) ? $jogoDaApi->status : 0;
                        $jogoAoVivo->c_casa             = isset($jogoDaApi->hc) ? $jogoDaApi->hc : 0;
                        $jogoAoVivo->c_fora             = isset($jogoDaApi->ac) ? $jogoDaApi->ac : 0;
                        $jogoAoVivo->r_casa             = isset($jogoDaApi->hg) ? $jogoDaApi->hg : 0;
                        $jogoAoVivo->r_fora             = isset($jogoDaApi->ag) ? $jogoDaApi->ag : 0;
                        $jogoAoVivo->odds               = isset($jogoDaApi->p_odds) ? $jogoDaApi->p_odds : [0,0];
                        $jogoAoVivo->ataques            = isset($jogoDaApi->attacks) ? $jogoDaApi->attacks : [0,0];
                        $jogoAoVivo->ataques_perigosos  = isset($jogoDaApi->dang_attacks) ? $jogoDaApi->dang_attacks : [0,0];
                        $jogoAoVivo->chutes_no_gol      = isset($jogoDaApi->shot_on) ? $jogoDaApi->shot_on : [0,0]; 
                        $jogoAoVivo->chutes_para_fora   = isset($jogoDaApi->shot_off) ? $jogoDaApi->shot_off : [0,0];
                        $jogoAoVivo->posses             = isset($jogoDaApi->possess) ? $jogoDaApi->possess : [0,0];   
                        $jogoAoVivo->superioridade      = $this->superioridade( $jogoAoVivo );
                        
                        $numeroDeCantos = 0;
                        $eventos = array();
                        $n_gols = 0;
                        $eventos_gols = array();

                        if ( isset( $jogoDaApi->events ) && $jogoDaApi->events != null )
                        {
    
                            foreach ( $jogoDaApi->events as $evento ) 
                            { 
                                if ( $evento->tp == 'c' )
                                {
                                    $canto          = new Evento();
                                    $canto->t       = $evento->t;
                                    $canto->casa    = $evento->h=='h' ? 1 : 0; 
                                    $canto->jogo_id = $jogo->id;
                                    array_push($eventos, $canto);
                                    $numeroDeCantos += 1;
                                }

                                if ( $evento->tp == 'g' )
                                {
                                    $event          = new Evento();
                                    $event->t       = $evento->t;
                                    $event->casa    = $evento->h == 'h' ? 1 : 0; 
                                    $event->jogo_id = $jogo->id;
                                    array_push( $eventos_gols, $event );
                                    $n_gols += 1;
                                }
                            }
                        
                            $jogoAoVivo->eventos      = isset( $eventos ) && $eventos != null ? $eventos : null;
                            $jogoAoVivo->eventos_gols = isset( $eventos_gols ) && $eventos_gols != null ? $eventos_gols : null;

                        }					
                        array_push( $jogosAoVivo, $jogoAoVivo );
                    }
                    
                }
                if ( $jogosDaApi->pagination->next == true  && $pagina < $jogosDaApi->pagination->pages )
                {
                    $pagina += 1;
                    $this->buscarDadosDeJogosAoVivoAPI( $pagina, $jogosAoVivo );


                } else {
                    
                    //EXCLUI cache
                    Cache::forget( 'lives' );
                    //CRIA cache
                    Cache::put( 'lives', $jogosAoVivo, 10 );
                }
            }

            sleep( $dadosDaApi->getHeader( 'X-Rate-Limit-Reset' )[ 0 ] + 1 );
        
        }catch( RequestException $e ){
            return 'Erro';
        }
    }
}
