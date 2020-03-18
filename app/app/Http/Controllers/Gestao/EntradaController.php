<?php

namespace App\Http\Controllers\Gestao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Entrada;

class EntradaController extends Controller
{

    public function index(){
        $entradas = Entrada::where('gestao_id',auth()->user()->gestao->id)->where('resultado','!=','pendente')->orderBy('id','desc')->paginate(10);
        return view('admin.gestao.entradas',compact('entradas'));
    }
    public function criar(Request $r){

    	$entrada = Entrada::create([
    		'gestao_id' => $r->user()->gestao->id,
    		'estrategia_id' =>$r->estrategia_id,
    		'odd' => $r->odd,
    		'jogo_id' => $r->jogo_id,
    		'stake' => $r->stake,
    		'resultado' => $r->resultado
    	]);

    	
    	if($entrada){
            if($entrada->resultado != 'pendente'){
        		$r->user()->gestao->resultado($r->stake,$r->odd,$r->resultado);
            }
        	
            return response()->json(['resultado' => 'Adicionado com sucesso!']);   

    	}

    	return response()->json(['resultado' => 'Ocorreu algum erro!']);
    }

    public function entradasPendentes(){
        return Entrada::where('resultado','pendente')->where('gestao_id',auth()->user()->gestao->id)->get()->load('jogo','jogo.liga','jogo.time_casa','jogo.time_fora','estrategia');
    }

    public function updateResultado(Request $r){
        $entrada = Entrada::find($r->id);
        $entrada->resultado = $r->resultado;
        $entrada->save();

        auth()->user()->gestao->resultado($entrada->stake,$entrada->odd,$entrada->resultado);

        return auth()->user()->gestao;
    }

    public function excluir($id){
        $entrada = Entrada::find($id);

        auth()->user()->gestao->excluirEntrada($entrada);

        return back()->with('success','Entrada Excluida!');
    } 
    public function excluirAll(){
        Entrada::where('gestao_id',auth()->user()->gestao->id)->delete();

        $gestao = auth()->user()->gestao;
        $gestao->valor_investido= 0;
        $gestao->lucro= 0;
        $gestao->save();

        return back()->with('success','Gestão zerada!');
    }
}
