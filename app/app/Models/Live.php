<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Jogo;

class Live extends Model
{
    protected $fillable = [
        'jogo_id','tempo','r_casa','r_fora','c_casa','c_fora'
    ];

    public function jogo(){
    	return $this->belongsTo(Jogo::class); 
    }
}
