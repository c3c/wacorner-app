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
    			<h3 class="box-title">Adquira um plano  - PicPay</h1>
    		<div class="box-body">
    			<div class="alert alert-info">@if(auth()->user()->ativo())
    				Data de expiração: {{date('d/m/Y',strtotime(auth()->user()->data_expiracao))}} @else NENHUM PLANO ATIVO @endif </div>
    			
    			@include('admin.includes.alerts')
    			
                <div class="row">
                    <div class="col-md-4">
                        <p><b>Escanei o codigo ou utilize o link ao lado:</b></p><br>
                        <img class="figure-image img-fluid" width="400" height="500" src="{{ asset('assets/images/picpay.jpg')}}" alt="image" /> 
                    </div>
                    <div class="col-md-5">
                        <p>
                            <b>Faça uma tranferência para a conta a baixo e nos envie um email (wacornerstats@gmail.com) com o comprovante para podermos liberar seu sistema e com o email de cadastro:</b>
                        </p>
                        <p>
                            <br><b>CONTA - PICPAY</b><br>
                            <br><b>Usuario:</b> @wacorner
                            <br><a href="https://picpay.me/wacorner" target="_blank">Link para Pagar</a>
                            
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
    </div>





@stop

