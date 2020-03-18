<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Jogo;
class Lista extends Model
{
    protected $fillable = [
        'nome','user_id',    
    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function jogos(){
    	return $this->belongsToMany(Jogo::class)->withPivot(['notification_id'])->orderBy('start','asc');
    }

}
