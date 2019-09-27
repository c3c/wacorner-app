<?php

namespace App\Http\Controllers\Gestao;

use Illuminate\Http\Request;
use App\Models\Estrategia;
use App\Http\Controllers\Controller;

class EstrategiaController extends Controller
{
    public function estrategias()
    {
    	return Estrategia::where('user_id',auth()->user()->id)->orWhere('padrao',1)->orderBy('padrao','desc')->get();
    }

    public function show()
    {
        $estrategias = Estrategia::where('user_id',auth()->user()->id)->orWhere('padrao',1)->orderBy('padrao','desc')->get();
        return view('admin.estrategias.show', compact('estrategias'));
    }

    public function new(){
        return view('admin.estrategias.new');
    }

    public function edit($id){
        $estrategia = Estrategia::find($id);
        return view('admin.estrategias.edit',compact('estrategia'));
    }

    public function create(Request $r)
    {
    	Estrategia::create([
            'nome' => $r->nome,
            'user_id' => $r->user()->id,
            'padrao' =>	$r->padrao	
    	]);

        return back()
                    ->with('success','Estratégia criada com sucesso!');
    }


    public function update(Request $r)
    {
        $estrategia = Estrategia::find($r->estrategia_id);
        
        $estrategia->nome = $r->nome;
        $estrategia->user_id = $r->user()->id;
        $estrategia->padrao = $r->padrao;
        $estrategia->save();

        return back()
                    ->with('success','Estratégia atualizada!');
    }

    public function delete($id){
        Estrategia::find($id)->delete();

         return back()
                    ->with('error','Estratégia excluida!');
    }
}
