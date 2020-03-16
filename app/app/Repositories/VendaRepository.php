<?php
namespace App\Repositories;

use App\Venda;
use App\Models\Cupon;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use DB;

class VendaRepository{
    private $venda;


    public function __construct()
    {
        $this->venda = new Venda;
    }

    public function salvarVenda($dados)
    {
        $erros = [];
        DB::beginTransaction();
        $valor = $dados['valor'];
        if(isset($dados['cupom'])){
            $cupon = Cupon::where('codigo', $dados['cupom'])->first();
            if($cupon != null){
                $valor = $valor - $valor*$cupom->desconto/100;
            }
        }
        $venda = $this->venda->create([
            'tipo_pagamento' => 'PicPay',
            'user_id' => auth()->user()->id,
            'plano' => 'profissional',
            'status' => 'pendente',
            'valor' => $valor
        ]);


        if( $venda != null ){
            DB::commit();
            return $venda;
        }

        DB::rollBack();
        array_push($erros,'Erro ao salvar a venda');
        return ['erros' => $erros];
    }

    public function enviarVendaPicpay($venda)
    {
        $client = new Client([
            'base_uri' => config('picpay.url'),
            'headers'  => [
                'x-picpay-token' => config('picpay.x-picpay-token'),
                'Content-Type' => 'application/json',
                'Accept-Encoding'  =>  ' gzip '
            ],
        ]);

        try {

            $resposta =  $client->post('payments',
                [
                    'form_params' => [
                        'referenceId' => $venda->id,
                        'callbackUrl' => config('picpay.url_notification'),
                        'returnUrl' => config('picpay.url_redirect'),
                        'value' => $venda->valor,
                        'buyer' => [
                            'firstName'=> auth()->user()->nome,
                            'lastName'=> auth()->user()->sobrenome,
                            'document'=> $this->converterEmCPF(auth()->user()->cpf),
                            'email'=> auth()->user()->email,
                            'phone'=> '+55 '. strlen(auth()->user()->codigo_area) > 2 ? substr(auth()->user()->codigo_area,1) : auth()->user()->codigo_area .' '.$this->converterEmTelefone(auth()->user()->telefone).''
                        ]
                    ]
                ]
            );
            if($resposta->getStatusCode() == 200){
                $url = json_decode($resposta->getBody()->getContents())->paymentUrl;
                $this->salvarUrlVenda($venda,$url);
                return ["url_redirect" => $url];
            }else{
                return ['erros' => 'Erro ao enviar venda ao Pagseguro'];
            }
        } catch (GuzzleException $e) {
            return ['erros' => 'Erro ao enviar venda ao Pagseguro'];
        }
    }

    public function verificaStatusPicpay($id)
    {
        $client = new Client([
            'base_uri' => config('picpay.url'),
            'headers'  => [
                'x-picpay-token' => config('picpay.x-picpay-token'),
                'Content-Type' => 'application/json',
                'Accept-Encoding'  =>  ' gzip '
            ],
        ]);

        try {

            $resposta =  $client->get('payments/'.$id.'/status');
            $venda = Venda::find($id);
            if($resposta->getStatusCode() == 200){
                $retorno = json_decode($resposta->getBody()->getContents());
                if($retorno->status == "paid") {
                    $venda->status = "Paga";
                    $venda->save();
                    $venda->user->renovacao($venda->plano);
                    $venda->user->envioLiberacaoPlano($venda->user,$venda->plano);
                } else if($retorno->status == "expired"){
                    $venda->status = "Expirado";
                    $venda->save();
                } else if($retorno->status == "refunded"){
                    $venda->status = "Devolvido";
                    $venda->save();
                    $venda_aux = $venda;
                    $venda->user->cancelarRenovacao($venda_aux);
                } else if($retorno->status == "chargeback"){
                    $venda->status = "Pago e estornado";
                    $venda->save();
                    $venda_aux = $venda;
                    $venda->user->cancelarRenovacao($venda_aux);
                }

            }else{
                return ['erros' => 'Erro'];
            }
        } catch (GuzzleException $e) {
            return ['erros' => 'Erro'];
        }
    }

    public function validarVenda($dados)
    {
        $erros = [];
        if(isset($dados['cupom'])){
            $cupon = Cupon::where('codigo', $dados['cupom'])->first();
            if($cupon == null){
                array_push($erros,'Cupon não existe');
            }
        }

        if(auth()->user()->nome == ''){
            array_push($erros,'Nome do usuário inválido');
        }

        if(auth()->user()->sobrenome == ''){
            array_push($erros,'Sobrenome do usuário inválido');
        }

        if(strlen(auth()->user()->cpf) != 11){
            array_push($erros,'CPF do usuário deve ter 11 digitos');
        }

        if(strlen(auth()->user()->codigo_area) < 2){
            array_push($erros,'DDD do usuário deve ter 2 a 3 digitos');
        }

        if(strlen(auth()->user()->telefone) != 9){
            array_push($erros,'Telefone do usuário deve ter 9 digitos');
        }

        if(filter_var(auth()->user()->email, FILTER_VALIDATE_EMAIL) == false){
            array_push($erros,'E-mail inválido');
        }

        return $erros;
    }

    public function converterEmCPF($valor)
    {
        $cpf = preg_replace("/\D/", '', $valor);
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cpf);
    }

    public function converterEmTelefone($valor)
    {
        $telefone = preg_replace("/\D/", '', $valor);
        return preg_replace("/(\d{5})(\d{4})/", "\$1-\$2", $telefone);
    }

    public function salvarUrlVenda($venda,$url)
    {
        $venda->referencia = $url;
        $venda->save();
    }

}
