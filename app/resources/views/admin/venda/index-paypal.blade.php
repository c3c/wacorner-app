@extends('adminlte::page')

@section('js_header')

  @if(auth()->check())
      @if(auth()->user()->user_id != null)  
        <script>
          fbq('track', 'InitiateCheckout');
        </script>
      @endif
  @endif  

  <script src="https://www.paypalobjects.com/api/checkout.js"></script>
@stop


@section('content')
<div id="loader"></div>

<div class="box">
	<div class="box-header">
			<h3 class="box-title">Adquira um plano  - PAGAMENTO PAYPAL</h3>
    </div>
	<div class="box-body">
		<div class="alert alert-info">@if(auth()->user()->ativo())
			Data de expiração: {{date('d/m/Y',strtotime(auth()->user()->data_expiracao))}} @else NENHUM PLANO ATIVO @endif </div>
		
		@include('admin.includes.alerts')
		<p><b>(*)</b>Campos obrigratórios caso esteja habilitado para preenchimento.</p>
        @if($basico != true || $profissional != true)
			<div class="col-md-6">
                <form-paypal profissional="{{$profissional}}" url_obrigado_basico="{{route('venda.paypal.new',['plano' => 'basico'])}}" url_obrigado_profissional="{{route('venda.paypal.new',['plano' => 'profissional'])}}" email="{{auth()->user()->email}}"></form-paypal>

		    </div>
        @else
            <h3>VOCÊ TEM DOIS PAGAMENTO PELO PAYPAL, PEDENTES. EXCLUA ALGUM OU ESPERE A CONFIRMAÇÃO DE PAGAMENTO, CASO TENHA REALIZADO O PAGAMENTO, QUALQUER DUVIDA ENTRE EM CONTA PELO EMAIL: WACORNERSTATS@GMAIL.COM</h3>
        @endif
		 	<hr>				
	</div>
</div>





@stop

