<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Saque extends Model
{
    protected $fillable = [
    	'user_id','valor','obs','status'
    ];

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function valorTotal($saques){
    	$total = 0;
    	foreach ($saques as $key => $saque) {
    		$total += $saque->valor;
    	}
    	return $total;
    }
}
