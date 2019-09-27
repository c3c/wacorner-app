<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Estrategia extends Model
{
    protected $fillable = ['nome','user_id','padrao'];

    public function user(){
    	$this->belongsTo(User::class);
    }

    public function entradas()
    {
    	$this->hasMany(Entrada::class);
    }
}
