@extends('adminlte::page')



@section('content_header')
    <a href="{{route('admin.amanha')}}" class="btn btn-primary"><i class="fa fa-share" aria-hidden="true"></i> Jogos de amanhã</a>
    

@stop

@section('content')

<div class="box">
	<div class="box-header">
		<div class="row">
		<div class="col-md-3">
				<h3 class="box-title">Jogos de Hoje</h1>
			</div>
	   </div>
	</div>
	<div class="box-body">
    @if($dias_para_expirar > 0)
      <div class="alert alert-warning">
        <p><span class="fa fa-warning"></span> Renove seu plano, falta(m) <b>{{$dias_para_expirar}} DIA(s)</b> para acabar seu acesso ao sistema.</p>
      </div>
    @elseif($dias_para_expirar == 0)
      <div class="alert alert-warning">
        <p><span class="fa fa-warning"></span> Vixe😱, você só tem até HOJE para acessar nosso sitema, compre mais dias para continuar utilizando.</p>
      </div>
    @endif
		@include('admin.includes.alerts')	               	
       	<tabela-principal url_gestao="{{route('gestao.estrategias')}}" url_jogo="{{route('admin.jogo',['id' =>''])}}" url="{{route('admin.jogos.data',['data' => date('Y-m-d')])}}" url_lista="{{route('listas')}}" zona="{{auth()->user()->zona}}"></tabela-principal>
       	
       	<modal  nome="adicionar-lista" titulo="Adicionar na lista">
        	<form-lista id='form-add-lista' token="{{ csrf_token() }}" url_lista="{{route('listas')}}"></form-lista>
	        <span slot="botoes">
	            <button form="form-add-lista" class="btn btn-info">Adicionar</button>
	        </span>
    	</modal> 

    	<modal  nome="adicionar-gestao" titulo="⛳️ Adicionar a GESTÃO">
    		<form-add-gestao id='form-add-gestao' token="{{ csrf_token() }}" url_gestao="{{route('gestao')}}" entrada="{{auth()->user()->gestao->stake}}"></form-add-gestao>
    	    <span slot="botoes">
    	        <button form="form-add-gestao" class="btn btn-info">Adicionar</button>
    	    </span>
    	</modal>
  	</div>
</div>
    
@stop