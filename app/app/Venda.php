<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\User;
use PagSeguro;
class Venda extends Model
{
    protected $fillable = [
        'referencia', 'plano', 'status','tipo_pagamento','user_id','valor'
    ];

    public $valor_plano_profissional = 30;

    public function user(){
    	return $this->belongsTo(User::class);
    }
    public function getValorPlanoProfissonal(){
      return $this->valor_plano_profissional;
    }
    public function calcularTotalPago($vendas){
        $total = 0;
        foreach ($vendas as $key => $venda) {
            if ($venda->plano == 'profissional')
              $total += $this->valor_plano_profissional;
            else 
              $total += 10;
        }

        return $total;
    }

    public function compra_boleto($valor, $hash){

   		$venda = $this;

    	try {
   		       
   			
   			
          	$pagseguro = PagSeguro::setReference(''.$venda->id)
        	->setSenderInfo([
        	  'senderName' => auth()->user()->nome." ".auth()->user()->sobrenome,
        	  'senderPhone' => '(99) 9999-9999',
        	  'senderEmail' => auth()->user()->email,
        	  'senderHash' => $hash,
        	  'senderCPF' => auth()->user()->cpf
        	])
        	->setItems([
        	  [
        	  	'itemId' => 2,
        	    'itemDescription' => 'Plano profissional',
        	    'itemAmount' => $valor, //Valor unitário
        	    'itemQuantity' => '1', // Quantidade de itens
        	  ]
        	])
        	->send(['paymentMethod' => 'boleto']);



        	return ['status' => 'success','retorno' => $pagseguro->paymentLink];
            
        }
        catch(\Artistas\PagSeguro\PagSeguroException $e) {
            if(auth()->user()->cpf == null || auth()->user()->cpf == '' || strlen(auth()->user()->cpf)<11){
              return ['status' => 'error', 'erro_cpf' =>'erro'];
            }else{
              return ['status' => 'error','retorno' => $e];
            }
        }
    }

    public function compra_cartao(Request $r){

        $venda = $this;

        try {
            
            $idItem = $r->plano == 'basico'? 1 : 2;
            $valorItem = $r->plano == 'basico'? 10 : $this->valor_plano_profissional;
            $pagseguro = PagSeguro::setReference(''.$venda->id)
            ->setSenderInfo([
              'senderName' => auth()->user()->nome." ".auth()->user()->sobrenome,
              'senderPhone' => '('.auth()->user()->codigo_area.') '.auth()->user()->telefone.'',
              'senderEmail' => auth()->user()->email,
              'senderHash' => $r->token,
              'senderCPF' => auth()->user()->cpf
            ])
            ->setCreditCardHolder([
              'creditCardHolderBirthDate' => date('d/m/Y',strtotime($r->data_aniversario)),
            ])
            ->setBillingAddress([
              'billingAddressStreet' => $r->rua,
              'billingAddressNumber' => $r->numero,
              'billingAddressDistrict' => $r->bairro,
              'billingAddressPostalCode' => $r->cep,
              'billingAddressCity' => $r->cidade,
              'billingAddressState' => $r->estado
            ])
            ->setItems([
              [
                'itemId' => $idItem,
                'itemDescription' => 'Plano '.$r->plano,
                'itemAmount' => $valorItem, //Valor unitário
                'itemQuantity' => '1', // Quantidade de itens
              ]
            ])
            ->send([
                'paymentMethod' => 'creditCard',
                'creditCardToken' => $r->card_token,
                'installmentQuantity' => '1',
                'installmentValue' => $valorItem,
            ]);
            auth()->user()->rua = $r->rua;
            auth()->user()->numero = $r->numero;
            auth()->user()->bairro = $r->bairro;
            auth()->user()->cep = $r->cep;
            auth()->user()->cidade = $r->cidade;
            auth()->user()->estado = $r->estado;
            auth()->user()->save();
            return ['status' => 'success','retorno' => 'Após a confirmação de pagamento pela empresa de cartão de crédito, você terá acesso ao nosso sitema!'];
            
        }
        catch(\Artistas\PagSeguro\PagSeguroException $e) {

            return ['status' => 'error','retorno' => $e];
        }
    }
}
