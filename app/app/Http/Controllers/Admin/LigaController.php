<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Models\Liga;

class LigaController extends Controller
{
    public function index(){
    	$ligas = Liga::orderBy('ativo','desc')->paginate(30);

    	return view('admin.liga.index',compact('ligas'));
    }

    public function ativar($id){
    	
    	$liga = Liga::find($id);

    	if($liga->ativo == 1){
    		$liga->ativo = 0;
    	}else{
    		$liga->ativo = 1;
    	}
    	$liga->save();

    	return redirect()
    				->route('liga')
    				->with('success','Status da liga alterado!');
    }

    public function search(Request $r, Liga $liga){
    	$data = $r->except('_token');

    	$ligas = $liga->where('l','like','%'.$data['l'].'%')->orderBy('ativo','desc')->paginate(50);

    	return view('admin.liga.index',compact('ligas','data'));
    }
}
