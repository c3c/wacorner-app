<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Lista;
use App\Models\Jogo;
use App\Notifications\InicioJogo;
use Carbon\Carbon;
use DB;
use \KCE\OneSignal\Facades\OneSignalClient;

class ListaController extends Controller
{
    public function index(){
        
    	$listas = auth()->user()->listas;

    	return view('admin.listas.index',compact('listas'));
    }

    public function listas(){
        return auth()->user()->listas->load('jogos');
    }

    public function listaJogo( Request $r)
    {
        $exists = DB::table('jogo_lista')
                ->where('jogo_id',$r->jogo)
                ->where('lista_id',$r->lista)
                ->count() > 0;

        return response()->json(['existe' => $exists]);
    }

    public function new(Request $r){
    	$r->validate([
    		'nome' => 'required',
		]);

		
		$lista = auth()->user()->listas()->create($r->except('_token'));

       	return back()
            ->with('success','Lista criada!');
    }

    public function delete($id, Lista $l){
        $lista = Lista::where('id',$id)->delete();
        
        if($lista){
    	   return back()
                ->with('success','Lista EXCLUIDA!');
        }else{
            return back()
                ->with('error','Ocorreu algum erro ao excluir essa lista!');
        }
    }

    public function limpar($id, Lista $l){
        
        $lista = $l->find($id);
        

        $limpar = $l->find($id)->jogos()->detach();
        if ($limpar)
        {
            return back()
            ->with('success','Lista limpada!');
        }
        else
        {
            return back()
            ->with('error','Erro ao limpar');
        }
    }

    public function deleteJogo($id_lista,$id_jogo){

        $lista = Lista::find($id_lista);
        

        $lista->jogos()->detach($id_jogo);
        return redirect()
                    ->back()->with('success','Jogo excluido');
    }

    public function jogo_add(Request $r){
        
        $exists = DB::table('jogo_lista')
                ->where('jogo_id',$r->jogo_id)
                ->where('lista_id',$r->lista_id)
                ->count() > 0;
        if(!$exists)
        {
        	$lista = Lista::find($r->lista_id);
            $jogo = Jogo::find($r->jogo_id);

            $data_jogo = new Carbon($jogo->start);
            $data_jogo->subMinutes(10);
            $data_agora = Carbon::now();


            if($data_jogo->greaterThan($data_agora))
            {
                               

                $res = OneSignalClient::scheduleByUserTimezone($data_jogo)
                            ->setTitle($jogo->time_casa->nome. " x " . $jogo->time_fora->nome)
                            ->sendToTags('Lista: '.$lista->nome."\nJá vai começar!", ["user_id", "=", auth()->user()->id]);
                
                $notification_id = json_decode($res->getBody()->getContents());
                $lista->jogos()->attach($r->jogo_id, ['notification_id' => $notification_id->id]);
                
                return response()->json(['resultado' => 'Adicionado na lista, 10 min antes do inicio do jogo você será notificado!']);
            }else{
                $notification_id = null;
                $lista->jogos()->attach($r->jogo_id, ['notification_id' => $notification_id]);
                OneSignalClient::setTitle($jogo->time_casa->nome. " x " . $jogo->time_fora->nome)
                            ->sendToTags('Lista: '.$lista->nome."\nJá vai começar!", ["user_id", "=", auth()->user()->id]);
                return response()->json(['resultado' => 'Adicionado!']);
            }

            

            
        }

    	return response()->json(['resultado' => 'Já exite na sua lista!']);
    }
}
