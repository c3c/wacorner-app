@extends('adminlte::page')


@section('content')

<div class="box">
	<div class="box-header">
		<h1>Nova Venda</h1>
		<a href="{{route('gestao.estrategias.show')}}" class="btn btn-warning btn-xs"><i class="fa fa-reply"></i> Voltar</a>
	</div>
	<div class="box-body">
		@include('admin.includes.alerts')
		<div class="col-md-5">
			<form id="form-estrategia-new" action="{{route('gestao.estrategias.create')}}" method="POST">
				@csrf
				<div class="form-group">
					<label for="title"> Nome</label>
					<input type="text" name="nome" class="form-control">
				</div>
				@if(auth()->user()->admin == 1)
				<div class="form-group">
					<label for="title"> Padrão</label>
					<select name="padrao" class="form-control">
						<option value="1">Sim</option>
						<option value="0">Não</option>
					</select>
				</div>
				@else
					<input type="hidden" name="padrao" value="0">
				@endif

				<div class="form-group">
					<button form="form-estrategia-new" type="submit" class="btn btn-success"> Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>
    
@stop