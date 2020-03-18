<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Jogo;
class Evento extends Model
{
    protected $fillable = [
        't','casa'
    ]; 

    public function jogo(){
    	return $this->belongsTo(Jogo::class);
    }
}
