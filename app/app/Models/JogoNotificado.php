<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Jogo;
use App\Models\Robo;

class JogoNotificado extends Model
{
	protected $fillable=['jogo_id','estrategia','robo_id','status'];

    public function jogo()
    {
    	return $this->belongsTo(Jogo::class);
    }

    public function robo()
    {
    	return $this->belongsTo(Robo::class);
    }
}
