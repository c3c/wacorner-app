<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;

class IndicadoController extends Controller
{
    public function index()
    {
    	
        $afiliados = User::where('saldo','>',0)->paginate(30);
        $usuarios = User::where('saldo','>',0)->get();
        $total = 0;
        foreach ($usuarios as $key => $usuario) {
            $total += $usuario->saldo;
        }


    	return view('admin.indicados.index',compact('afiliados','total'));
    }

    public function show($id){
        $afiliado = User::find($id);
    	$usuarios = User::where('user_id',$id)->orderBy('id','desc')->paginate(30);
    	$total = User::where('user_id',$id)->get()->count();
    	return view('admin.indicados.show', compact('usuarios','total','afiliado'));
    }

    public function converterDias($id){
        $afiliado = User::find($id);
        if($afiliado->saldo != null && $afiliado->saldo > 0){
            $n_dias = round($afiliado->saldo);
            $afiliado->renovacao(null, $n_dias);
            $afiliado->saldo = 0;
            $afiliado->save();
            return back()->with("success","Você recebeu ".$n_dias." dias para utilizar o WAcorner");
        }

        return back()->with("error","Você não tem saldo!");

    }
}
