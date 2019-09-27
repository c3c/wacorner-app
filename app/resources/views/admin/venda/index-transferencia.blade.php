@extends('adminlte::page')

@section('js_header')

  @if(auth()->check())
      @if(auth()->user()->user_id != null)  
        <script>
          fbq('track', 'InitiateCheckout');
        </script>
      @endif
  @endif  

@stop

@section('content_header')



@stop

@section('content')

<div class="box">
    	<div class="box-header">
    			<h3 class="box-title">Adquira um plano  - Transferência</h1>
    		<div class="box-body">
    			<div class="alert alert-info">@if(auth()->user()->ativo())
    				Data de expiração: {{date('d/m/Y',strtotime(auth()->user()->data_expiracao))}} @else NENHUM PLANO ATIVO @endif </div>
    			
    			@include('admin.includes.alerts')
    			
                <div class="row">
                    <p>
                        <b>Faça uma tranferência para a conta a baixo e nos envie um email (wacornerstats@gmail.com) com o comprovante para podermos liberar seu sistema e com o email de cadastro:</b>
                    </p>
                    <p>
                        <br><b>CONTA - CAIXA</b><br>
                        <br><b>Nome:</b> ARMANDO DE MOURA FÉ
                        <br><b>Agência:</b> 1383
                        <br><b>Operação:</b> 013 
                        <br><b>Conta:</b> 49528-8
                    </p>

                    <p>
                        <h4>
                        <br><b>Plano Profissional:</b> R$29,99
                    </h4>
                    </p>
                </div>
                			
    		</div>
    	</div>
    </div>





@stop

