<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Jogo;
use App\Models\Liga;
class Time extends Model
{
	protected $fillable = [
        'nome', 'cantos'
    ];
    public function jogos_casa()
    {
    	return $this->hasMany(Jogo::class,'time_casa_id')->orderBy('start','desc');
    }
    public function jogos_fora()
    {
        return $this->hasMany(Jogo::class,'time_fora_id')->orderBy('start','desc');
    }

    public function ligas()
    {
    	return $this->belongsToMany(Liga::class)->withPivot(['posicao','jogos','vitorias','empates','derrotas','pontos'])->withTimestamps();
    }
    
}
