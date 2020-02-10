<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use \KCE\OneSignal\Facades\OneSignalClient;
use App\User;
use App\Models\JogoNotificado;
use App\Models\Jogo;
use Telegram;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\Live;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Robo;

class RoboRepository 
{
    protected $client;
    protected $token_api = "e019efd7a4b24af8";

    public function __construct(){
    
        $this->client = new Client( [
            'headers' => [ 'content-type' => 'application/json', 'Accept' => 'application/json' ],
            'base_uri' => 'https://api.totalcorner.com/v1/'
    	] );
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

    public function rodarRobos()
    {

        try{

            $dadosDaApi = $this->client->request( 'GET', "match/today?token=".$this->token_api.
                                                "&type=inplay&columns=events,odds,attacks,dangerousAttacks,
                                                shotOn,shotOff,possession");

            $jogosDaApi = json_decode( $dadosDaApi->getBody()->getContents() );
                
            					
            if( !isset( $jogosDaApi->success ) || $jogosDaApi->success == 0 )
            {
                echo "\n ( ".$jogosDaApi->error->code." ) ".$jogosDaApi->error->message;
                sleep( 60 );
                $this->rodarRobos();
            
            } else {
                if ( !Cache::has( 'robos-ativos-wacorner' ) ) 
                {
                    $data_hj = new Carbon(date('Y-m-d')); 
                    $robos = Robo::where('status','=','1')->get();
                    $robos_ativos = array();
                    foreach($robos as $robo){
                        if($robo->user->ativo()){
                            array_push($robos_ativos,$robo->id);
                        }
                    }
                    Cache::put( 'robos-ativos-wacorner', $robos_ativos, 5 );
                }
               
                foreach($jogosDaApi->data as $jogoDaApi){
                    if ( !Cache::has( 'jogo_id_api'.$jogoDaApi->id ) ) 
                    {
                        Cache::put( 'jogo_id_api'.$jogoDaApi->id, Jogo::where( 'id_api', $jogoDaApi->id )->first(), 90 );
                    }

                    $jogo = Cache::get( 'jogo_id_api'.$jogoDaApi->id );

                    if ( $jogo!=null )
                    {	
                       
                        $jogoAoVivo                     = new Live();
                        $jogoAoVivo->jogo               = $jogo->load( 'liga', 'time_casa', 'time_fora' )
                                                                ->toArray();
                        if(isset($jogoDaApi->status)){
                            $jogoAoVivo->tempo = $jogoDaApi->status != 'half' ? $jogoDaApi->status : 45;
                        }else{
                            $jogoAoVivo->tempo = 0;
                        }
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

                        $diferenca_gols = $jogoAoVivo->r_casa > $jogoAoVivo->r_fora ? ($jogoAoVivo->r_casa - $jogoAoVivo->r_fora) : ($jogoAoVivo->r_fora - $jogoAoVivo->r_casa);
                        
                        
                        $robos_ativos = Cache::get( 'robos-ativos-wacorner' );
                        $robos = Robo::whereIn('id',$robos_ativos)
                            ->where('intervalo_inicio','<',intval($jogoAoVivo->tempo)+1)
                            ->where('intervalo_fim','>=',intval($jogoAoVivo->tempo))
                            ->where('escanteios_min','<',$jogoAoVivo->c_casa+$jogoAoVivo->c_fora+1)
                            ->where('diferenca_gols','>=',$diferenca_gols)
                            ->get();
                        
                        foreach ($robos as $key => $robo) {
                            if ( !Cache::has( 'jogo_id'.$jogo->id.'estrategia'.$robo->nome."_".$robo->user_id ) ) {                    
                                $this->analisar($jogoAoVivo,$robo,$diferenca_gols);
                                $this->roboColombiano($jogoAoVivo);
                            }
                        }
                    }
                }

                sleep( $dadosDaApi->getHeader( 'X-Rate-Limit-Reset' )[ 0 ] + 1 );

                return true;
            }
        }catch( RequestException $e ){
            return 'Erro';
        }
    }

    private function roboColombiano($jogoAoVivo) {
        $notificacao = JogoNotificado::where( 'estrategia', "colômbia - ".$jogoAoVivo->jogo['time_casa']['nome']." x ".$jogoAoVivo->jogo['time_fora']['nome'] )->first();
        if($notificacao == null){
            if(intval($jogoAoVivo->tempo)>= 82 && intval($jogoAoVivo->tempo)<=88){
                $primeiro_calculo_casa = $jogoAoVivo->chutes_no_gol[0] 
                    + $jogoAoVivo->chutes_para_fora[0]
                    + $jogoAoVivo->c_casa; 
                $primeiro_calculo_fora = $jogoAoVivo->chutes_no_gol[1] 
                    + $jogoAoVivo->chutes_para_fora[1]
                    + $jogoAoVivo->c_fora; 
                if($primeiro_calculo_casa >= 15 || $primeiro_calculo_fora>= 15) {
                    $atpm_casa = $jogoAoVivo->ataques_perigosos[0]/intval($jogoAoVivo->tempo); 
                    $atpm_fora = $jogoAoVivo->ataques_perigosos[1]/intval($jogoAoVivo->tempo); 
                    if($atpm_casa>= 1 || $atpm_fora >= 1) {
                        Telegram::sendMessage([
                            'chat_id' => '-1001231370685', 
                            'parse_mode' => 'Markdown',
                            'text' => "*⚽️Jogo:* ".$jogoAoVivo->jogo['time_casa']['nome']." x ".$jogoAoVivo->jogo['time_fora']['nome'].
                                    "*\n🏆Liga:* ".$jogoAoVivo->jogo['liga']['l'].
                                    "*\n⏰Tempo:* ".$jogoAoVivo->tempo.
                                    "*\n\n💙 Casa - 1º calculo:* ".$primeiro_calculo_casa.
                                    "*\n💛 Fora - 1º calculo:* ".$primeiro_calculo_fora.
                                    "*\n\n💙 Casa - ATPM:* ".$atpm_casa.
                                    "*\n💛 Fora - ATPM:* ".$atpm_fora
                                    ,	  
                        ]);
                        JogoNotificado::create([
                            'jogo_id' 		=> 1,
                            'estrategia'	=> "colômbia - ".$jogoAoVivo->jogo['time_casa']['nome']." x ".$jogoAoVivo->jogo['time_fora']['nome'],
                            'robo_id'       => 1,
                            'status'        => 'nova',
                        ]);
                    }

                }
            }
        }
    }

    private function tipoDeJogo($jogo){
        if($jogo['favorito'] != null || $jogo['super_favorito'] != null){
            return 'f-s';
        }else{
            return 'jogo-parelho';
        }
    }

    private function analise_pre($jogo,$robo){
        $estrategia = strtolower($robo->nome);
        if( strpos($robo->situacao,$this->tipoDeJogo($jogo)) !== false ){
            if($jogo['n_jogos_casa'] >= $robo->qtd_min_jogos_casa){
                if($jogo['n_jogos_casa'] >= $robo->qtd_min_jogos_casa){
                    if($jogo[$estrategia] >= $robo->porcentagem_min_total){
                        if($jogo[$estrategia.'_casa'] >= $robo->porcentagem_min_casa){
                            if($jogo[$estrategia.'_fora'] >= $robo->porcentagem_min_fora){
                                if($robo->situacao == 'jogo-parelho'){
                                    return true;
                                }else{
                                    $favorito = $jogo['favorito'] != null ? $jogo['favorito'] : $jogo['super_favorito'];
                                    $zebra = $favorito == 'casa' ? 'fora' : 'casa';
                                    if($jogo[$estrategia."_media_favor_".$favorito] >= $robo->media_favor_estrategia_favorito){
                                        if($jogo[$estrategia."_media_contra_".$favorito] >= $robo->media_contra_estrategia_favorito){
                                            if($jogo[$estrategia."_media_favor_".$zebra] >= $robo->media_favor_estrategia_zebra){
                                                if($jogo[$estrategia."_media_contra_".$zebra] >= $robo->media_contra_estrategia_zebra){
                                                    if(($jogo[$estrategia."_media_favor_".$zebra] +$jogo[$estrategia."_media_contra_".$zebra]) >= $robo->media_total_estrategia_zebra){
                                                        if(($jogo[$estrategia."_media_favor_".$favorito] +$jogo[$estrategia."_media_contra_".$favorito]) >= $robo->media_total_estrategia_favorito){
                                                            return true;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return false;
    }
    public function analisar($live,$robo,$diferenca_gols)
    {                       
        
        if($this->analise_pre($live->jogo,$robo) == true){

            $situacao_jogo = $this->situacao($live,$diferenca_gols);
            if(strpos($robo->situacao,$situacao_jogo) !== false){
                $menor_odd = $live->odds[0] <= $live->odds[2] ? 'casa' : 'fora';
                $difenca_odds = $live->odds[0] > $live->odds[2] ? ($live->odds[0] - $live->odds[2]) : ($live->odds[2] - $live->odds[0]);
                if($situacao_jogo == 'jogo-parelho'){
                    $jogo = Jogo::find($live->jogo['id']);
                    if($jogo != null){
                        if($robo->user->telegram_chat_id != null){
                            $this->enviarMensagemBot($robo,$menor_odd,strtolower($robo->nome),$live,$difenca_odds,$live->superioridade);
                            return true;
                        }
                    }
                }else{
                    if($situacao_jogo != 'g' && $situacao_jogo != 'jogo-parelho'){
                        if($menor_odd == $live->superioridade[1]){
                            if($live->superioridade[0] >= $robo->superioridade){
                                
                                    $jogo = Jogo::find($live->jogo['id']);
                                    if($jogo != null){
                                        if($robo->user->telegram_chat_id != null){
                                            $this->enviarMensagemBot($robo,$menor_odd,strtolower($robo->nome),$live,$difenca_odds,$live->superioridade); 
                                            return true;
                                        }
                                    }
                                }
                        }
                    }
                } 
            }  
        }
        return true;
    }

    public function tipo($odd){
        if($odd <= 1){
            return '';
        }else if($odd > 1 && $odd<=3){
            return 'F';
        }else{
            return 'S';
        }
    }

    public function situacao($live,$diferenca_gols){
        $difenca_odds = $live->odds[0] > $live->odds[2] ? ($live->odds[0] - $live->odds[2]) : ($live->odds[2] - $live->odds[0]);
        $tipo = $this->tipo($difenca_odds);
        if($tipo == ''){
            return 'jogo-parelho';
        }else{
            if($diferenca_gols == 0){
                return 'e';
            }else{
                if($live->r_casa > $live->r_fora){
                    $ganhando = 'casa';
                    $perdendo = 'fora';
                }else if($live->r_casa < $live->r_fora){
                    $ganhando = 'fora';
                    $perdendo = 'casa';
                }

                $favorito_superfavorito = $live->odds[0] < $live->odds[2] ? 'casa' : 'fora';

                if($perdendo == $favorito_superfavorito){
                    return 'p';
                }else{
                    return 'g';
                }
            }
        }
    }

    public function enviarMensagemBot($robo,$menor_odd,$estrategia,$live,$difenca_odds,$sup)
    {
        //USAR EMOJI -> https://emojipedia.org/warning-sign/
        $texto = "--------------------------------------";
        $texto .= "\n🚩 DICA DE ENTRADA 🚩";
        $texto .= "\n            *".strtoupper($estrategia)." (".$live->jogo[$estrategia]."%)*";
        $texto .= "\n--------------------------------------";
        $texto .= "\n\n*⏰Tempo:* ".$live->tempo;
        $texto .= "\n*⚽️Jogo:* ";
        if($this->tipo($difenca_odds) != ''){
            if($menor_odd == 'casa'){
                $texto .= "*(".$this->tipo($difenca_odds).")* ".$live->jogo['time_casa']['nome']." *".$live->r_casa."* x *".$live->r_fora." *".$live->jogo['time_fora']['nome'];
            }else{
                $texto .= $live->jogo['time_casa']['nome']." *".$live->r_casa."* x *".$live->r_fora." *".$live->jogo['time_fora']['nome']." *(".$this->tipo($difenca_odds).")*";
            }
        }else{
            $texto .= $live->jogo['time_casa']['nome']." *".$live->r_casa."* x *".$live->r_fora." *".$live->jogo['time_fora']['nome'];
        }
        $texto .= "\n*🏆Liga:* ".$live->jogo['liga']['l'];
        $texto .= "\n*⛳️Escanteios:* ".$live->c_casa." - ".$live->c_fora;
        
        if($sup[1] == 'casa'){
            $texto .= "\n*💚Superioridade:* ".$sup[0]."% (CASA)";
        }else{
            $texto .= "\n*💚Superioridade:* ".$sup[0]."% (FORA)";
        }
        $texto .= "\n\n*💙 CASA (".$live->jogo[$estrategia."_casa"]."%)*";
        $texto .= "\n--------------------------------------";
        $texto .= "\nMedia Favor: ".$live->jogo[$estrategia."_media_favor_casa"]." cantos";
        $texto .= "\nMedia Contra: ".$live->jogo[$estrategia."_media_contra_casa"]." cantos";
        $texto .= "\n\n*💛 FORA (".$live->jogo[$estrategia."_fora"]."%)*";
        $texto .= "\n--------------------------------------";
        $texto .= "\nMedia Favor: ".$live->jogo[$estrategia."_media_favor_fora"]." cantos";
        $texto .= "\nMedia Contra: ".$live->jogo[$estrategia."_media_contra_fora"]." cantos";
        $texto .= "\n\n⚠⚠⚠⚠⚠⚠⚠⚠⚠⚠⚠";

        

        //FT75 -> '-1001231370685'
        //FT82 -> '-1001175360624.0'
        $robo->user->sendMenssageTelegram(
            $robo->user->telegram_chat_id,
            $texto
        );

        Cache::add('jogo_id'.$live->jogo['id'].'estrategia'.$robo->nome."_".$robo->user_id,1,90);

        echo "\njogo ENVIDADO para->".$robo->user->email;
    }

    public function sendListPre($robo,$data){
        $jogos = Jogo::where( 'start', 'like', '%'.date( 'Y-m-d', strtotime($data) ).'%' )
                            ->orderBy('start','asc')
                            ->get();
        $texto_inicial = "\n*Lista de possiveis jogos do robo ".strtoupper($robo->nome)."* ";
        $texto_inicial .= "\n*Data: ".date( 'd/m/Y', strtotime($data) )."*\n";
        $texto_inicial .= "--------------------------------------\n\n";
        $n = 0;
        $total_jogos = 0;
        $texto = "";
        foreach($jogos as $jogo){
            
            $jogo = $jogo->load( 'liga', 'time_casa', 'time_fora' )->toArray();
            if($this->analise_pre($jogo,$robo)){
                
                $total_jogos += 1;
                $n += 1;
                if($jogo['favorito'] == null && $jogo['super_favorito'] == null){
                    $texto .= "⏰ ".date( 'H:i', strtotime($jogo['start']) )." - ".$jogo['time_casa']['nome']." x ".$jogo['time_fora']['nome'];
                }else{
                    $favorito = $jogo['favorito'] != null ? 'F' : 'S';
                    if($jogo['favorito'] == 'casa' || $jogo['super_favorito'] == 'casa'){
                        $texto .= "⏰ ".date( 'H:i', strtotime($jogo['start']) )." - ".$jogo['time_casa']['nome']." *(".$favorito.")* x ".$jogo['time_fora']['nome'];
                    }else{
                        $texto .= "⏰ ".date( 'H:i', strtotime($jogo['start']) )." - ".$jogo['time_casa']['nome']." x ".$jogo['time_fora']['nome']." *(".$favorito.")*";
                    }
                }
                $texto .= "\n--------------------------------------\n";
            }
            
            if($n >= 15){
                if($total_jogos>=30){
                    $robo->user->sendMenssageTelegram(
                        $robo->user->telegram_chat_id,
                        $texto
                    );
                }else{
                    $robo->user->sendMenssageTelegram(
                        $robo->user->telegram_chat_id,
                        $texto_inicial.$texto
                    );
                }
                sleep(1);
                $n = 0;
                $texto = "";
            }
        }
     
        if($n != 0){
            if($total_jogos >= 15){
                $robo->user->sendMenssageTelegram(
                    $robo->user->telegram_chat_id,
                    $texto
                );
            }else{
                $robo->user->sendMenssageTelegram(
                    $robo->user->telegram_chat_id,
                    $texto_inicial.$texto
                );
            }
            sleep(1);
        }
        //FT75 -> '-1001231370685'
        //FT82 -> '-1001175360624.0'
        if($total_jogos != 0){
            return true;
        }else{
            return false;
        }
    }
}