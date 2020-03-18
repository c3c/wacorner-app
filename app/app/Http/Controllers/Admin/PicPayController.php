<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\VendaRepository;

class PicPayController extends Controller
{
    private $vendaRepository = null;
    public function __construct(){
        $this->vendaRepository = new VendaRepository;
    }

    public function purchasePicpay(Request $request)
    {
        $erros = $this->vendaRepository->validarVenda($request->all());

        if(count($erros) == 0){
            $venda = $this->vendaRepository->salvarVenda($request->all());
            if(!isset($venda['erros'])){
                $retorno = $this->vendaRepository->enviarVendaPicpay($venda);
                if(!isset($retorno['erros'])){
                    return redirect()
                        ->route('venda.obrigado',['tipo' => 'PicPay']);
                }
            }
            $erros = $retorno['erros'];
        }
        return redirect()
                ->route('venda.picpay')
                ->with('errors',$erros);
    }

    public function statusPicpay(Request $request) {
        $retorno = $this->vendaRepository->verificaStatusPicPay($request['referenceId']);
        if(!isset($retorno['erros'])){
            $this->liberar_plano($request['referenceId']);
            return response()->json("Status recebido!",200);
        }

        return response()->json("Erro", 400);
    }
}
