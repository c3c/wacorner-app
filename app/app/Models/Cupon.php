<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Cupon extends Model
{
    protected $table = 'cupons';

    protected $fillable = ['codigo','tipo','desconto','dias','fim','parceiro_id','remunerado','user_id','created_at'];

    public function users()
    {
    	return $this->belongsToMany(User::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
    
    public function user_parceiro()
    {

    	return User::where('id',$this->parceiro_id)->first();
    }

    public function verificaUsuario($user_id){
        $usuarios = $this->users;

        foreach ($usuarios as $key => $user) {
            if($user->id == $user_id)
                return true;
        }
        return false;
    }
}
