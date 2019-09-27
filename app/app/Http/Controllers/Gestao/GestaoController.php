<?php

namespace App\Http\Controllers\Gestao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gestao;
use App\Models\Entrada;

class GestaoController extends Controller
{
    public function index()
    {
    	///COLOCAR EM UM LOCAL ONDE O USUARIO ENTRE NO SITE E JA SEJA CRIADO ESSA GESTÃO CASO NÃO TENHA AINDA
    	if(auth()->user()->gestao == null){
    		Gestao::create([
    		'banca_inicial' => 1000.00,
    		'stake' => 10.00,
    		'user_id' => auth()->user()->id,
    		'valor_investido' => 0.00,
    		'lucro' => 0.0
    		]);
		}
		 
		$greens = Entrada::where('resultado','green')->where('gestao_id',auth()->user()->gestao->id)->count();
		$reds = Entrada::where('resultado','red')->where('gestao_id',auth()->user()->gestao->id)->count();

    	return view('admin.gestao.index',compact('greens','reds'));
    }

    public function update(Request $r)
    {
        $gestao = auth()->user()->gestao;
		$gestao->banca_inicial = $r->banca_inicial;
		$gestao->stake = $r->stake;
		$gestao->valor_investido = $r->valor_investido;
		$gestao->lucro = $r->lucro;
        $gestao->save();
        sleep(3);
    	return response()->json(['resultado' => 'Operação realizada com sucesso!']);
    }

    public function show()
    {
    	return auth()->user()->gestao;
    }
}
