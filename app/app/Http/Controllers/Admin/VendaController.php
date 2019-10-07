<?php

namespace App\Http\Controllers\Admin;
header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Venda;
use App\User;
use App\Models\Cupon;
use Validator;
use PagSeguro;
use DB;
use App\Notifications\NovaCompra;

class VendaController extends Controller
{
    public $comissao = 0.20;

    public function index(){

        return view('admin.venda.index');
    }

    public function index_transferencia(){
        return view('admin.venda.index-transferencia');
    }

    public function index_picpay(){
        return view('admin.venda.index-picpay');
    }

    public function index_cupom()
    {
        return view('admin.venda.index-cupom');
    }

    public function plano_valor($plano,$desconto){
        $valor = 30 - 30*$desconto/100;
        if($plano == 'profissional')
            return $valor;

        return $valor;
    }

    public function planoAdd($email, $plano,User $user){
        $usuario = User::where('email',$email)->first();

        $venda = Venda::create([
            'plano' => $plano,
            'status'=> 'Paga',
            'user_id' => $usuario->id,
            'tipo_pagamento' => 'Transferência',
            'valor' => $this->plano_valor($plano,0),
        ]);        

        $this->liberar_plano($venda->id);

        return redirect()
                ->route('usuario')
                ->with('success','Atualizado com sucesso! Tipo de pagamento: Transferência.');

    }

    public function liberar_plano($id)
    {
        $venda = Venda::find($id);
        $venda->status = 'Paga';
        $venda->save();
        $venda->user->renovacao($venda->plano);
        $venda->user->envioLiberacaoPlano($venda->user,$venda->plano);

        //ADICIONAR - COMISSÃO DO AFILIADO
        if(isset($venda->user->user_id) && $venda->user->user_id != null){
            $afiliado = User::find($venda->user->user_id);
            if($afiliado != null){
                $afiliado->addSaldo($venda->valor,$this->comissao);
                $afiliado->notify(new NovaCompra($venda));
            } 
        }

        return back()
                    ->with('success','Plano ativado. E admins notificados!');

    }
    public function index_cupom_validar(Request $r)
    {
        $cupom = Cupon::where('codigo',$r->codigo)->first();

        if ($cupom!=null){            
            if(!$cupom->verificaUsuario(auth()->user()->id)){
            
            }else{
               return back()
                        ->with('error','Você já utilizou um cupom promocional!');
            }    
        }else{
            return back()
                    ->with('error','Cupom não existe!');
        }
    }
    public function cupom_desconto_validar(Request $r)
    {
        $cupom = Cupon::where('codigo',$r->cupom_desconto)->where('tipo','desconto')->where('fim','>=',date('Y-m-d'))->first();

        if ($cupom!=null){            
            if(!$cupom->verificaUsuario(auth()->user()->id)){
                return ['erro' => 0, 'resultado' => $cupom];
            }else{
               return ['erro' => 'Você já utilizou um cupom promocional!'];
            }    
        }else{
            return ['erro' => 'Cupom não existe!'];
        }
    }

    public function index_paypal($plano = null,$desconto = null){

        if ($plano != null) {
            $venda = auth()->user()->vendas()->firstOrCreate([
                'plano' => $plano,
                'referencia' => "cartão", 
                'status' => "pendente",
                'valor' => $this->plano_valor($plano,$desconto),
                'tipo_pagamento' => "PayPal",
            ]);

            $this->liberar_plano($venda->id);
        
            return redirect()
                    ->route('venda.obrigado',['tipo' => 'PayPal']);
        }

        $profissional = auth()->user()->vendas()
        ->where('tipo_pagamento','PayPal')
        ->where('plano','profissional')
        ->where('status','pendente')->first();
        if ($profissional != null) 
            $profissional = true;
        else
            $profissional = false;

        
        return view('admin.venda.index-paypal',compact('basico','profissional'));
        
    }

    public function show($id=null){
        if(auth()->user()->admin == 1){
            if($id!=null){
                $usuario = User::find($id); 
                $vendas = $usuario->vendas()->paginate(30); 
                if($vendas->count() < 1)
                    return redirect()
                            ->route('usuario')
                                ->with('error',$usuario->email.' não comprou nada, é um BAITOLA...kkkkkk');
            }else{
                $vendas = Venda::orderBy('id','desc')->paginate(30);
            }
        }else{
            $vendas = auth()->user()->vendas()->paginate(30);
        }

        $data = (Carbon::now())->subYear()->format('Y-m');
        
        $vendasAno = Venda::whereDate('created_at','>=',$data.'-01')->where('status','Paga')->get(); 
        $mesAno = array();
        $num_vendas_basico = array();
        $num_vendas_profissional = array();
        
        foreach ($vendasAno as $key => $venda) {
            $data_venda = new Carbon($venda->created_at);
            if (in_array($data_venda->format('m/Y'), $mesAno))
            {
                $i = array_search($data_venda->format('m/Y'),$mesAno);
                if ($venda->plano == 'basico')
                {
                    $num_vendas_basico[$i] = isset($num_vendas_basico[$i])? $num_vendas_basico[$i]+1:1;
                }

                if ($venda->plano == 'profissional')
                {
                    $num_vendas_profissional[$i] = isset($num_vendas_profissional[$i])? $num_vendas_profissional[$i]+1:1;
                }

            }else{
            
                array_push($mesAno,$data_venda->format('m/Y'));

                if ($venda->plano == 'basico')
                {
                    array_push($num_vendas_basico,1);
                }

                if ($venda->plano == 'profissional')
                {
                    array_push($num_vendas_profissional,1);
                }
                
            }
            
        }
        
        $total_basico = Venda::where('plano','basico')->where('status','Paga')->count();
        $total_profissional = Venda::where('plano','profissional')->where('status','Paga')->count();
        $total_pendente = Venda::where('status','pendente')->count();
        $total_usuarios = User::whereDate('data_expiracao','>=',date('Y-m-d'))->count();
        $info_grafico_por_plano = ['mesAno'=> $mesAno,'num_vendas_basico'=>$num_vendas_basico,'num_vendas_profissional'=>$num_vendas_profissional];
       
        return view('admin.venda.show',compact('vendas','total_usuarios','total_basico','total_profissional','total_pendente','info_grafico_por_plano'));
    
    }

    public function status(Request $r,Venda $v){
        $pagseguro = PagSeguro::notification($r->notificationCode, $r->notificationType);

        $venda = $v->find(intval($pagseguro->reference));
        
        if($venda == null){
            $user = User::where('email',$pagseguro->sender->email)->first();

            $venda = new Venda();
            $venda->id = $pagseguro->reference;
            $venda->user_id = $user->id;
            if(strtolower($pagseguro->items[0]->item->description) == 'plano profissional'){
                $venda->plano = 'profissional'; 
                $venda->valor = $pagseguro->items[0]->item->amount;
            }else{
                $venda->plano = 'basico';
                $venda->valor = $pagseguro->items[0]->item->amount;
            }
            
            $venda->referencia = null;
            $venda->status = 'pendente';
            $venda->tipo_pagamento = $pagseguro->paymentmethod->type == 2 ? 'boleto' : 'cartão'; 
            $venda->save();

            

        }

        if(intval($pagseguro->status) == 3){
           
            
            
                if($venda->status != 'Paga')
                {       
                    
                    $this->liberar_plano($venda->id);
                }
            

        }else if(intval($pagseguro->status) == 5 || intval($pagseguro->status) == 6 || intval($pagseguro->status) == 7){
            $venda_aux = $venda;
            $statusAnterior = $venda->status;
            if(intval($pagseguro->status) == 5)
                $venda->status = 'Em disputa';
            else if(intval($pagseguro->status) == 6)
                $venda->status = 'Devolvida';
            else
                $venda->status = 'Cancelada';

            $venda->user->cancelarRenovacao($venda_aux);

            //REMOVER - COMISSÃO DO AFILIADO
            if(isset($user->user_id) && $user->user_id != null){
                $afiliado = User::find($user->user_id);
                if($afiliado != null){
                    if( $statusAnterior == 'Paga' ){
                        $afiliado->removerSaldo($venda->valor*$this->comissao);
                    }
                }
            } 
        }
    }

    public function compra(Request $r){
        $data_expiracao = new Carbon(auth()->user()->data_expiracao);
        $data_hj = new Carbon(date('Y-m-d'));
        
        //verifica se ainda não utilizou o plano gratís
        if(auth()->user()->data_expiracao==null && $r->plano == 'gratis'){
            
            auth()->user()->renovacaoGratis();
            return redirect('admin')
                        ->with('success','Plano grátis ativado.');

        //verifica se utilizou o plano gratís
        }else if(auth()->user()->data_expiracao!=null && $r->plano == 'gratis'){
            
            return redirect()
                        ->route('venda')
                        ->with('error','Você não pode utilizar mais este plano.');

        //AQUI COMEÇA A PARTE DA COMPRA DE UM PLANO
        }else{
           
           if($r->tipo_pagamento == 'boleto'){
                $venda = auth()->user()->vendas()->firstOrCreate([
                    'plano' => $r->plano,
                    'status'=> 'pendente',
                    'tipo_pagamento' => 'boleto',
                    'valor' => $this->plano_valor($r->plano,$r->desconto),
                ]);
                //VERIFICA SE JA TEM BOLETO PENDENTE PRA O PLANO ESCOLHIDO
                if($venda->referencia == null)
                    $retorno = $venda->compra_boleto($this->plano_valor($r->plano,$r->desconto),$r->token);
                else
                    return redirect()
                        ->route('venda')
                        ->with('error',"Já existe uma compra para este plano ".$r->plano." e tipo de pagamento: '".$venda->tipo_pagamento."' com pagamento PENDENTE, vá no menu 'PLANO > Histórico' e pague seu boleto!");
           
           }else{

                 $v = Validator::make($r->all(), [
                    'data_aniversario' => 'required',
                    'cep' => 'required',
                    'cidade' => 'required',
                    'estado' => 'required',
                    'rua' => 'required',
                    'numero' => 'required',
                    'bairro' => 'required',
                    'cartao' => 'required',
                    'cvv' => 'required',
                    'validadeMes' => 'required',
                    'validadeAno' => 'required',
                ]);

                if ($v->fails())
                {
                    return redirect()->back()->withErrors($v->errors());
                }else{

                    $venda = auth()->user()->vendas()->firstOrCreate([
                        'plano' => $r->plano,
                        'status'=> 'pendente',
                        'tipo_pagamento' => 'cartão',
                        'valor' => $this->plano_valor($r->plano,$r->desconto),
                    ]);
                    if($venda->referencia == null)
                        $retorno = $venda->compra_cartao($r);
                    else
                        return redirect()
                            ->route('venda')
                            ->with('error',"Já existe uma compra para este plano ".$r->plano." e tipo de pagamento: '".$venda->tipo_pagamento."' com pagamento PENDENTE, esperando a empresa de cartão de crédito liberar o pagamento!");
                }
           } 

           if($retorno['status'] == 'error'){
                $venda->delete();

                if(isset($retorno['erro_cpf'])){
                    return redirect()
                    ->route('venda')
                    ->with('error','Seu CPF está incorreto, por favor vá em seu PERFIL e atualize o CPF para poder comprar no boleto.');    
                }
                return redirect()
                    ->route('venda')
                    ->with('error',"Erro do PAGSEGURO - Codigo: ".$retorno['retorno']->getCode()." - ".$retorno['retorno']->getMessage().". Alguns soluções: Atualizar a pagina ou verificar se os dados enviar estão corretos, caso não consiga resolver entre em contato conosco."); 
           }else{
                if($r->tipo_pagamento == 'boleto'){
                $venda->referencia = $retorno['retorno']."";
                $venda->save();

                return redirect()
                    ->route('venda.obrigado',['tipo' => 'boleto']);

                }else{
                    $venda->referencia = "cartão";
                    $venda->save();
                    return redirect()
                    ->route('venda')
                    ->with('success',$retorno['retorno']."");
                } 
           }
           
        }
    }

    public function delete($id){
        $venda = Venda::where('id',$id)->first();
        
        $venda->user->cancelarRenovacao($venda);

        //REMOVER - COMISSÃO DO AFILIADO
        if(isset($venda->user->user_id) && $venda->user->user_id != null){
            $afiliado = User::find($venda->user->user_id);
            if($afiliado != null){
                $afiliado->removerSaldo($venda->valor*$this->comissao);
            } 
        }

        $venda->delete();

        return redirect()->route('venda.show');
    }

    public function search(Request $r, Venda $v){
        $data = $r->all();

        $vendas = Venda::where('status','Paga')->where( function($query) use ($data){
            if (isset($data['data_inicio']))
                $query->whereDate('created_at','>=',$data['data_inicio']);

            if (isset($data['data_fim']))
                $query->whereDate('created_at','<=',$data['data_fim']);
            
            if (isset($data['tipo_pagamento']))
                $query->where('tipo_pagamento',$data['tipo_pagamento']);

        })->get();

        $total_pedidos = $vendas->count();
        $total_pago = $v->calcularTotalPago($vendas);

        return view('admin.venda.relatorio',compact('vendas','total_pedidos','total_pago'));
    }

    public function obrigado($tipo){
        $tipo_pagamento = $tipo;

        if($tipo == 'boleto')
            $link = auth()->user()->vendas->last()->referencia;

        return view('admin.venda.obrigado',compact('tipo_pagamento','link'));
    }

    public function expirado(){
        return view('admin.venda.plano-expirado');
    }
}
