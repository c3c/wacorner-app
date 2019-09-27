@extends('adminlte::page')


@section('content')

<div class="box">
	<div class="box-header">
		<div class="row">
		<div class="col-md-5">
			<h3 class="box-title"><i class="fa fa-money"></i> Minha Gestão</h1>

			<modal-link tipo="button" nome="config-gestao" icone="fa fa-cog" css="btn btn-danger btn-xs" titulo="Configurar Gestão"></modal-link>
			<modal  nome="config-gestao" titulo="Configurar a gestão">
				<form-config-gestao id='form-config-gestao' token="{{ csrf_token() }}"></form-config-gestao>
			    <span slot="botoes">
			        <button form="form-config-gestao" id='botao-salvar-config-gestao' class="btn btn-info">Salvar</button>
			    </span>
			</modal>
			<a href="{{route('gestao.estrategias.show')}}" class="btn btn-danger btn-xs"><i class="fa fa-navicon"></i> Minhas Estrategias</a>
			<a href="{{route('gestao.entradas.index')}}" class="btn btn-primary btn-xs"><i class="fa fa-navicon"></i> Apostas Resolvidas</a>
	   </div>
	</div>
	<div class="box-body">
	<span class="badge bg-green">Greens: {{$greens}}</span>  <span class="badge bg-red">Reds: {{$reds}}</span>
		@include('admin.includes.alerts')	               	
    <gestao></gestao>
  </div>
</div>
    
@stop