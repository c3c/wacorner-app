@extends('adminlte::page')

@section('js_header')

  @if(auth()->check())
      @if(auth()->user()->user_id != null)  
        <script>
          fbq('track', 'Purchase', {
            value: 3,
          });
        </script>
      @endif
  @endif  

@stop

@section('content_header')



@stop

@section('content')

<div class="box">
    	<div class="box-header">
    			<h3 class="box-title"></h1>
    		<div class="box-body">
    			<div class="row">
                    <div class="col-md-12">
                        
                          <h1>Obrigado por adquirir um plano!</h1>
                          
                          @if ($tipo_pagamento == 'PayPal' || $tipo_pagamento == 'cartão')
                          <div class="alert alert-success" role="alert">
                            <p>No maximo em 30 minutos será liberado seu plano. Caso contrario entre em contato.</p>
                          </div>
                          @else
                          
                          <div class="alert alert-success" role="alert">
                            <a href="{{$link}}" target="_blank" class="btn btn-warning" style="text-decoration:none"> <i class="fa fa-money"></i> Clique aqui para acessar seu boleto</a>
                            <hr>
                          <p>A confirmação de pagamento pode levar até 3 dias úteis. Para agilizar esse processo entre em contato com nossa equipe, enviando o comprovante de pagamento do boleto.</p>
                          @endif
                          </div>
                         
                        
                    </div>
                </div>
                			
    		</div>
    	</div>
    </div>





@stop

