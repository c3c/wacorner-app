<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Gestao extends Model
{
    protected $table = 'gestoes';

    protected $fillable = ['stake','banca_inicial','valor_investido','lucro','user_id'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function estradas()
    {
    	return $this->hasMany(Entrada::class);
    }

    public function resultado($stake,$odd,$resultado){
        
        if($resultado == 'green')
        {
            $this->lucro += ($stake*$odd)-$stake;
        }else if($resultado == 'red'){
            $this->lucro -= $stake;
        }else{
        }

        $this->valor_investido +=$stake;
        if($this->save()){
            return true;
        }
        return false;
    }

    public function excluirEntrada($entrada){
        if($entrada->resultado == 'green'){
            $this->lucro -= (($entrada->stake * $entrada->odd) - $entrada->stake);
        }else if($entrada->resultado == 'red'){
            $this->lucro += $entrada->stake;
        }
        $this->valor_investido -= $entrada->stake;
        $this->save();
        $entrada->delete();
    }
}
