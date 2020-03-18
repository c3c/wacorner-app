<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Time;
use App\Models\Jogo;
class Liga extends Model
{
	protected $fillable = [
        'l','l_id','ativo','cantos','pais', 'temporada'
    ];
    
    public function times()
    {
    	return $this->belongsToMany(Time::class)->withPivot(['posicao','jogos','vitorias','empates','derrotas','pontos'])->withTimestamps();
    }

    public function jogos()
    {
    	return $this->hasMany(Jogo::class);
    }

}
