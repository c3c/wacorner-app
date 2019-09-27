<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Evento;
use App\Models\Entrada;
use App\Models\Time;
use App\Models\Liga;
use App\Models\Live;
use App\Models\JogoNotificado;
use App\Lista;

class Jogo extends Model
{
	protected $fillable = [
        'id_api','start', 'n_jogos_casa', 'n_jogos_fora', 
        'ht35', 
        'ht35_casa',
        'ht35_fora',
        'ht35_media_favor_casa',
        'ht35_media_favor_fora',
        'ht35_media_contra_casa',
        'ht35_media_contra_fora',
        'ht38',
        'ht38_casa',
        'ht38_fora',
        'ht38_media_favor_casa',
        'ht38_media_favor_fora',
        'ht38_media_contra_casa',
        'ht38_media_contra_fora',
        'ht10',
        'ht10_casa',
        'ht10_fora',
        'ht10_media_favor_casa',
        'ht10_media_favor_fora',
        'ht10_media_contra_casa',
        'ht10_media_contra_fora',
        'ht1020',
        'ht1020_casa',
        'ht1020_fora',
        'ht1020_media_favor_casa',
        'ht1020_media_favor_fora',
        'ht1020_media_contra_casa',
        'ht1020_media_contra_fora',
        'ht1',
        'ht1_casa',
        'ht1_fora',
        'ht1_media_favor_casa',
        'ht1_media_favor_fora',
        'ht1_media_contra_casa',
        'ht1_media_contra_fora',
        'ht2',
        'ht2_casa',
        'ht2_fora',
        'ht2_media_favor_casa',
        'ht2_media_favor_fora',
        'ht2_media_contra_casa',
        'ht2_media_contra_fora',
        'ft',
        'ft_casa',
        'ft_fora',
        'ft_media_favor_casa',
        'ft_media_favor_fora',
        'ft_media_contra_casa',
        'ft_media_contra_fora',
        'ft75',
        'ft75_casa',
        'ft75_fora',
        'ft75_media_favor_casa',
        'ft75_media_favor_fora',
        'ft75_media_contra_casa',
        'ft75_media_contra_fora',
        'ft82',
        'ft82_casa',
        'ft82_fora',
        'ft82_media_favor_casa',
        'ft82_media_favor_fora',
        'ft82_media_contra_casa',
        'ft82_media_contra_fora',
        'ft88',
        'ft88_casa',
        'ft88_fora',
        'ft88_media_favor_casa',
        'ft88_media_favor_fora',
        'ft88_media_contra_casa',
        'ft88_media_contra_fora',
        'over7','over8','over9','over10','over11','over12','liga_id','time_casa_id','time_fora_id','p_casa','p_fora'
    ];

    public function jogo_notificados(){
        return $this->hasMany(JogoNotificado::class);
    }

    public function listas(){
        return $this->belongsToMany(Lista::class)->withPivot(['notification_id']);
    }

    public function time_casa()
    {
    	return $this->belongsTo(Time::class,'time_casa_id');
    }
    public function time_fora()
    {
        return $this->belongsTo(Time::class,'time_fora_id');
    }
    public function liga()
    {
        return $this->belongsTo(Liga::class);
    }

    public function live(){
        return $this->hasOne(Live::class);
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }

    public function entradas()
    {
        return $this->hasMany(Entrada::class);
    }

    public function divisao($x,$y){
        if($y==0)
            return 0;
        else
            return ($x/$y);
    }

    public function cacularPorcentagem($jogo,$tempo_inicial,$tempo_final,$n_cantos,$media){
        //CASA
        $jogos_casa = $jogo->time_casa->jogos_casa()->whereDate('start','<',date('Y-m-d'))->where('id','!=',$jogo->id)->take(10)->get();
        if($jogo->n_jogos_casa == null){
            $n_jogos_casa = $jogos_casa->count();
            $jogo->n_jogos_casa = $n_jogos_casa;
            $jogo->save();
        }else{
            $n_jogos_casa = $jogo->n_jogos_casa;
        }
        
        $n_vezes=0;
        $cantos_sofridos_casa = 0;
        $cantos_marcados_casa = 0;
        $cantos_sofridos_fora = 0;
        $cantos_marcados_fora = 0;
        $media_contra_casa = 0; 
        $media_contra_fora = 0; 
        $media_favor_casa = 0; 
        $media_favor_fora = 0; 
        foreach ($jogos_casa as $jogo_casa) {
            $n = 0;
            foreach ($jogo_casa->eventos as $evento) {
                if (intval($evento->t)>$tempo_inicial && intval($evento->t)<$tempo_final){
                    $n += 1;
                    if($evento->casa == 1)
                        $cantos_marcados_casa +=1;
                    else
                        $cantos_sofridos_casa +=1;
                }
            }
            if($media != 1){
                if ($n>$n_cantos){
                    $n_vezes+=1;
                }
            }else{
                $n_vezes += $n;
            }
        }

        if ($n_vezes!=0){
            if($media != 1){
                $casa = $this->divisao($n_vezes,$n_jogos_casa)*100;
            }else {
                $casa = $this->divisao($n_vezes,$n_jogos_casa);
            }
        } else {
            $casa = 0;
        }
        //FORA
        $jogos_fora = $jogo->time_fora->jogos_fora()->whereDate('start','<',date('Y-m-d'))->where('id','!=',$jogo->id)->take(10)->get();
        if($jogo->n_jogos_fora == null){
            $n_jogos_fora = $jogos_fora->count();
            $jogo->n_jogos_fora = $n_jogos_fora;
            $jogo->save();
        }else{
            $n_jogos_fora = $jogo->n_jogos_fora;
        }
        
        $n_vezes=0;
        foreach ($jogos_fora as $jogo_fora) {
            $n = 0;
            foreach ($jogo_fora->eventos as $evento) {
                if (intval($evento->t)>$tempo_inicial && intval($evento->t)<$tempo_final){
                    $n += 1;
                    if($evento->casa == 0)
                        $cantos_marcados_fora +=1;
                    else
                        $cantos_sofridos_fora +=1;
                }
            }
            if($media != 1){
                if ($n>$n_cantos){
                    $n_vezes+=1;
                }
            }else{
                $n_vezes += $n;
            }
        }
        if ($n_vezes!=0)
            if($media != 1){
                $fora = $this->divisao($n_vezes,$n_jogos_fora)*100;
            }else {
                $fora = $this->divisao($n_vezes,$n_jogos_fora);
            }
        else
            $fora = 0;
        $media_contra_fora = $this->divisao($cantos_sofridos_fora,$n_jogos_fora);
        $media_contra_casa = $this->divisao($cantos_sofridos_casa,$n_jogos_casa);
        $media_favor_fora = $this->divisao($cantos_marcados_fora,$n_jogos_fora);
        $media_favor_casa = $this->divisao($cantos_marcados_casa,$n_jogos_casa);


        return [$casa,$fora,$media_contra_fora,$media_contra_casa,$media_favor_fora,$media_favor_casa];
    }

    public function calcularEstrategia($jogos)
    {   
        // $jogo = $this->where('id',113197)->first();
        // $valores = $this->cacularPorcentagem($jogo,-1,10,0,0);
        // dd($valores);
        foreach ($jogos as $jogo) {

            if($jogo->ht10<1 || $jogo->ht10 == null || $jogo->ht10 == ''){
                $valores = $this->cacularPorcentagem($jogo,-1,10,0,0);
                $jogo->ht10 = ($valores[0]+$valores[1])/2;
                $jogo->ht10_casa = $valores[0];
                $jogo->ht10_fora = $valores[1];
                $jogo->ht10_media_contra_fora = $valores[2];
                $jogo->ht10_media_contra_casa = $valores[3];
                $jogo->ht10_media_favor_fora = $valores[4];
                $jogo->ht10_media_favor_casa = $valores[5];
            }

            if($jogo->ht1020<1 || $jogo->ht1020 == null || $jogo->ht1020 == ''){
                $valores = $this->cacularPorcentagem($jogo,9,20,0,0);
                $jogo->ht1020 = ($valores[0]+$valores[1])/2;
                $jogo->ht1020_casa = $valores[0];
                $jogo->ht1020_fora = $valores[1];
                $jogo->ht1020_media_contra_fora = $valores[2];
                $jogo->ht1020_media_contra_casa = $valores[3];
                $jogo->ht1020_media_favor_fora = $valores[4];
                $jogo->ht1020_media_favor_casa = $valores[5];
            }

            if($jogo->ht35<1 || $jogo->ht35 == null || $jogo->ht35 == ''){
                $valores = $this->cacularPorcentagem($jogo,34,46,0,0);
                $jogo->ht35 = ($valores[0]+$valores[1])/2;
                $jogo->ht35_casa = $valores[0];
                $jogo->ht35_fora = $valores[1];
                $jogo->ht35_media_contra_fora = $valores[2];
                $jogo->ht35_media_contra_casa = $valores[3];
                $jogo->ht35_media_favor_fora = $valores[4];
                $jogo->ht35_media_favor_casa = $valores[5];
            }

            if($jogo->ht38<1 || $jogo->ht38 == null || $jogo->ht38 == ''){
                $valores = $this->cacularPorcentagem($jogo,37,46,0,0);
                $jogo->ht38 = ($valores[0]+$valores[1])/2;
                $jogo->ht38_casa = $valores[0];
                $jogo->ht38_fora = $valores[1];
                $jogo->ht38_media_contra_fora = $valores[2];
                $jogo->ht38_media_contra_casa = $valores[3];
                $jogo->ht38_media_favor_fora = $valores[4];
                $jogo->ht38_media_favor_casa = $valores[5];
            }

            if($jogo->ft75<1 || $jogo->ft75 == null || $jogo->ft75 == ''){
                $valores = $this->cacularPorcentagem($jogo,74,91,1,0);
                $jogo->ft75 = ($valores[0]+$valores[1])/2;
                $jogo->ft75_casa = $valores[0];
                $jogo->ft75_fora = $valores[1];
                $jogo->ft75_media_contra_fora = $valores[2];
                $jogo->ft75_media_contra_casa = $valores[3];
                $jogo->ft75_media_favor_fora = $valores[4];
                $jogo->ft75_media_favor_casa = $valores[5];
            }

            if($jogo->ft82<1 || $jogo->ft82 == null || $jogo->ft82 == ''){
                $valores = $this->cacularPorcentagem($jogo,81,91,0,0);
                $jogo->ft82 = ($valores[0]+$valores[1])/2;
                $jogo->ft82_casa = $valores[0];
                $jogo->ft82_fora = $valores[1];
                $jogo->ft82_media_contra_fora = $valores[2];
                $jogo->ft82_media_contra_casa = $valores[3];
                $jogo->ft82_media_favor_fora = $valores[4];
                $jogo->ft82_media_favor_casa = $valores[5];
            }

            if($jogo->ft88<1 || $jogo->ft88 == null || $jogo->ft88 == ''){
                $valores = $this->cacularPorcentagem($jogo,87,91,0,0);
                $jogo->ft88 = ($valores[0]+$valores[1])/2;
                $jogo->ft88_casa = $valores[0];
                $jogo->ft88_fora = $valores[1];
                $jogo->ft88_media_contra_fora = $valores[2];
                $jogo->ft88_media_contra_casa = $valores[3];
                $jogo->ft88_media_favor_fora = $valores[4];
                $jogo->ft88_media_favor_casa = $valores[5];
            }

            if($jogo->ht1<1 || $jogo->ht1 == null || $jogo->ht1 == ''){
                $valores = $this->cacularPorcentagem($jogo,-1,46,0,1);
                $jogo->ht1 = ($valores[0]+$valores[1])/2;
                $jogo->ht1_casa = $valores[0];
                $jogo->ht1_fora = $valores[1];
                $jogo->ht1_media_contra_fora = $valores[2];
                $jogo->ht1_media_contra_casa = $valores[3];
                $jogo->ht1_media_favor_fora = $valores[4];
                $jogo->ht1_media_favor_casa = $valores[5];
            }

            if($jogo->ht2<1 || $jogo->ht2 == null || $jogo->ht2 == ''){
                $valores = $this->cacularPorcentagem($jogo,45,91,0,1);
                $jogo->ht2 = ($valores[0]+$valores[1])/2;
                $jogo->ht2_casa = $valores[0];
                $jogo->ht2_fora = $valores[1];
                $jogo->ht2_media_contra_fora = $valores[2];
                $jogo->ht2_media_contra_casa = $valores[3];
                $jogo->ht2_media_favor_fora = $valores[4];
                $jogo->ht2_media_favor_casa = $valores[5];
            }

            if($jogo->ft<1 || $jogo->ft == null || $jogo->ft == ''){
                $valores = $this->cacularPorcentagem($jogo,-1,91,0,1);
                $jogo->ft = ($valores[0]+$valores[1])/2;
                $jogo->ft_casa = $valores[0];
                $jogo->ft_fora = $valores[1];
                $jogo->ft_media_contra_fora = $valores[2];
                $jogo->ft_media_contra_casa = $valores[3];
                $jogo->ft_media_favor_fora = $valores[4];
                $jogo->ft_media_favor_casa = $valores[5];
            }

            $this->over([$jogo],7);
            $this->over([$jogo],8);
            $this->over([$jogo],9);
            $this->over([$jogo],10);
            $this->over([$jogo],11);
            $this->over([$jogo],12);

            $jogo->save();
        }
        
    }

    
    public function ht_ft($jogos)
    {
        $n_ht_casa = 0;
        $n_ft_casa = 0;
        $n_ht_fora = 0;
        $n_ft_fora = 0;
        foreach ($jogos as $jogo) {
           foreach($jogo->eventos as $evento){
                if(intval($evento->t) < 46){
                    if($evento->casa == 1){
                        $n_ht_casa +=1;
                        $n_ft_casa +=1;
                    }else{
                        $n_ht_fora +=1;
                        $n_ft_fora +=1;
                    }
                }else{
                    if($evento->casa == 1){
                        $n_ft_casa +=1;
                    }else{
                        $n_ft_fora +=1;
                    }
                }
            }
            $ht_ft[$jogo->id] = [
                'n_ht_casa'=>$n_ht_casa,
                'n_ht_fora' =>$n_ht_fora,
                'n_ft_casa'=>$n_ft_casa,
                'n_ft_fora' =>$n_ft_fora,
            ];
            $n_ht_casa = 0;
            $n_ft_casa = 0;
            $n_ht_fora = 0;
            $n_ft_fora = 0;
        }
        
        if(isset($ht_ft))
            return $ht_ft;
        else 
            return null;
    }

    public function over($jogos,$n)
    {
        foreach ($jogos as $jogo) {
            if($jogo->over7 <1 || $jogo->over8 <1 || $jogo->over9 <1|| $jogo->over10 <1|| $jogo->over11 <1|| $jogo->over12 <1){
                
                //CASA
                $jogos_casa = $jogo->time_casa->jogos_casa()->whereDate('start','<',date('Y-m-d'))->where('id','!=',$jogo->id)->take(10)->get();
                $n_jogos_casa = $jogos_casa->count();
                $n_ft=0;
                foreach ($jogos_casa as $jogo_casa) {
                    if($jogo_casa->eventos->count()>$n){
                        $n_ft +=1;
                    }
                }
                
                if($n_ft!=0)
                    $ft_casa = $n_ft/$n_jogos_casa*100;
                else 
                    $ft_casa = 0;
                //FORA
                $jogos_fora = $jogo->time_fora->jogos_fora()->whereDate('start','<',date('Y-m-d'))->where('id','!=',$jogo->id)->take(10)->get();
                $n_jogos_fora = $jogos_fora->count();
                $n_ft=0;
                foreach ($jogos_fora as $jogo_fora) {
                    if($jogo_fora->eventos->count()>$n){
                        $n_ft +=1;
                    }
                }
                if($n_ft!=0) 
                $ft_fora = $n_ft/$n_jogos_fora*100;
                else
                    $ft_fora = 0;
                //CALCULO FINAL
                if($ft_casa != 0 || $ft_fora != 0){
                    if($n==7)
                        $jogo->over7 = ($ft_casa+$ft_fora)/2;
                    else if($n==8)
                        $jogo->over8 = ($ft_casa+$ft_fora)/2;
                    else if($n==9)
                        $jogo->over9 = ($ft_casa+$ft_fora)/2;
                    else if($n==10)
                        $jogo->over10 = ($ft_casa+$ft_fora)/2;
                    else if($n==11)
                        $jogo->over11 = ($ft_casa+$ft_fora)/2;
                    else
                        $jogo->over12 = ($ft_casa+$ft_fora)/2;

                    $jogo->save();
                }else{
                   if($n==7)
                        $jogo->over7 = 0;
                    else if($n==8)
                        $jogo->over8 = 0;
                    else if($n==9)
                        $jogo->over9 = 0;
                    else if($n==10)
                        $jogo->over10 = 0;
                    else if($n==11)
                        $jogo->over11 = 0;
                    else
                        $jogo->over12 = 0;

                    $jogo->save(); 
                }
            }
        }
    }

    public function jogos_validos($jogos,$n_jogos=null)
    {
        
        if($jogos == null)
            return null;
        $jogos_validos = array();
        foreach ($jogos as $key => $jogo) {
            if ($this->verificaNJogos($jogo,$n_jogos) == true)
                array_push($jogos_validos, $jogo);
        }
        
        return $jogos_validos;
    }

    public function verificaNJogos($jogo,$n_jogos=null)
    {        

        $n_jogos = $n_jogos==null? 0 : $n_jogos; 
            
        if($jogo->liga->ativo == 1 
            && $jogo->ft > 0 
            && ($jogo->time_casa->jogos_casa->count()-1)>=$n_jogos 
            && ($jogo->time_fora->jogos_fora->count()-1)>=$n_jogos){
                return true;
        }
        
        return false;
    }


}
