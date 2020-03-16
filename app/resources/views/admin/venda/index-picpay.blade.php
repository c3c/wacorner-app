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
                        <form action="{{route('venda.picpay.purchase')}}" method="POST">
                            <label>Valor Plano = R$ 29,99</lable>
                            <br>
                            <label>Cupom</label>
                            @csrf
                            <input class="form-control" type="text" name="cupom"/>
                            <br>
                            <input type="hidden" value="29.99" name="valor"/>
                            <input class="btn btn-success" type="submit" value="Comprar">
                        </form>
                    </div>
                </div>

    		</div>
    	</div>
    </div>





@stop

