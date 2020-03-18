<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\JogoNotificado;


class Robo extends Model
{
    protected $fillable = [
    	'nome',
    	'user_id',
    	'status',
    	'intervalo_inicio',
    	'intervalo_fim',
    	'situacao',
    	'diferenca_gols',
    	'superioridade',
    	'qtd_min_jogos_casa',
    	'qtd_min_jogos_fora',
    	'porcentagem_min_total',
        'porcentagem_min_casa',
    	'porcentagem_min_fora',
		'escanteios_min',
		'media_total_estrategia_favorito',        
		'media_favor_estrategia_favorito',        
		'media_contra_estrategia_favorito',
		'media_total_estrategia_zebra',        
		'media_favor_estrategia_zebra',        
		'media_contra_estrategia_zebra', 

    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function jogo_notificados()
    {
        return $this->hasMany(JogoNotificado::class);
    }

    
}
