<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Robo;
use App\Repositories\RoboRepository;
use App\User;
use App\Models\JogoNotificado;

class RoboController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $robos = auth()->user()->robos;

        return view('admin.robo.index',compact('robos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($nome)
    {
        $robos = ['HT1020','HT35','HT38','FT75','FT82','FT88'];
        foreach( $robos as $robo ){
            auth()->user()->robos()->create([
                'nome'                              => $robo,
                'status'                            => $robo == $nome ? 1 : 0,
                'intervalo_inicio'                  => 0,
                'intervalo_fim'                     => 90,
                'situacao'                          => 'f-s-p',
                'diferenca_gols'                    => 0,
                'superioridade'                     => 0,
                'qtd_min_jogos_casa'                => 1,
                'qtd_min_jogos_fora'                => 1,
                'porcentagem_min_total'             => 0,
                'porcentagem_min_casa'              => 0,
                'porcentagem_min_fora'              => 0,
                'escanteios_min'                    => 0,
                'media_total_estrategia_favorito'   => 0,
                'media_favor_estrategia_favorito'   => 0,
                'media_contra_estrategia_favorito'  => 0,
                'media_total_estrategia_zebra'      => 0,
                'media_favor_estrategia_zebra'      => 0,
                'media_contra_estrategia_zebra'     => 0,
            ]);
        }

        return back()->with('success','Robô '.$nome.' foi ativado!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $robo = Robo::find($id);

        return view('admin.robo.edit',compact('robo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $robo = Robo::findOrFail($id);

        $robo->update($request->all());

        return back()->with('success','Robô configurado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function alterarStatus($id)
    {   if($id == -1){
            auth()->user()->robos()->create([
                'nome'                              => "Funil WAcorner",
                'status'                            => 1,
                'intervalo_inicio'                  => 1000,
                'intervalo_fim'                     => 1001,
                'situacao'                          => 'f-s-p',
                'diferenca_gols'                    => 0,
                'superioridade'                     => 0,
                'qtd_min_jogos_casa'                => 1000,
                'qtd_min_jogos_fora'                => 1000,
                'porcentagem_min_total'             => 0,
                'porcentagem_min_casa'              => 0,
                'porcentagem_min_fora'              => 0,
                'escanteios_min'                    => 0,
                'media_total_estrategia_favorito'   => 0,
                'media_favor_estrategia_favorito'   => 0,
                'media_contra_estrategia_favorito'  => 0,
                'media_total_estrategia_zebra'      => 0,
                'media_favor_estrategia_zebra'      => 0,
                'media_contra_estrategia_zebra'     => 0,
            ]);
        } else {
            $robo = Robo::find($id);
            $robo->status = $robo->status == 0 ? 1 : 0;
            $robo->save();
        }
        return back()->with('success','Status do robô foi alterado com sucesso!');
    }

    public function notificacoes()
    {
        $robos = auth()->user()->robos;

        $notificacoes = array();
        foreach ($robos as $key => $robo) {
            foreach ($robo->jogo_notificados()->where('status','nova')->orderBy('created_at', 'desc')->get() as $key => $jogo_notificado) {
                array_push($notificacoes,[
                    'robo' => $robo,
                    'notificacao_id' => $jogo_notificado->id,
                    'jogo_id' => $jogo_notificado->jogo->id,
                    'time_casa' => $jogo_notificado->jogo->time_casa->nome,
                    'time_fora' => $jogo_notificado->jogo->time_fora->nome,
                    'liga' => $jogo_notificado->jogo->liga->l,
                    'data' => $jogo_notificado->created_at
                ]);
            }
        }

        return view('admin.robo.notificacoes', compact('notificacoes'));
    }

    public function excluirTodasNotificacoes()
    {
        $robos = auth()->user()->robos;
        foreach ($robos as $key => $robo) {
            $notificacao = $robo->jogo_notificados()->where('status','nova')->update(['status' => 'antiga']);
            // $notificacao->status = "antiga";
            // $notificacao->save();
        }

        return back()->with('success', 'Todas as notificações fora excluidas!');
    }

    public function excluirNotificacao($id)
    {
        $notificacao = JogoNotificado::find($id);
        $notificacao->status = "antiga";
        $notificacao->save();

        return back()->with('success', 'Notificação excluida!');
    }

    public function desconectar($id){

		$user = User::findOrFail($id);
		$user->telegram_chat_id = null;
		$user->save();

		return back()->with('success', "Desconectado!");
    }

    public function sendListRobo($id,$data){
        $robo = Robo::findOrFail($id);
        $roboRepository = new RoboRepository();

        if($roboRepository->sendListPre($robo,$data)){
            return back()->with('success',"Lista enviada!!!");
        }else{
            return back()->with('error',"Nenhum jogo foi encontrado para esse robo!");
        }
    }
}
