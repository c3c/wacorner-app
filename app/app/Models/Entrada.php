<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    protected $fillable = ['stake','odd','estrategia_id','jogo_id','gestao_id','resultado'];

    public function estrategia()
    {
    	return $this->belongsTo(Estrategia::class);
    }

    public function gestao()
    {
    	return $this->belongsTo(Gestao::class);
    }

    public function jogo()
    {
    	return $this->belongsTo(Jogo::class);
    }
}
