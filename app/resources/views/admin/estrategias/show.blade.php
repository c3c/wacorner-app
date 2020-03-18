@extends('adminlte::page')


@section('content')

<div class="box">
	<div class="box-header">
		<h1>Minhas estratégias</h1>
		<a href="{{route('gestao.estrategias.new')}}" class="btn btn-success"><i class="fa fa-plus"></i> Criar Nova</a>
	</div>
	<div class="box-body">
		@include('admin.includes.alerts')
		<table class="table">
			<thead>
				<tr>
					<th>Nome</th>
					<th>Padrão</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
				@foreach($estrategias as $estrategia)
				<tr>
					<td>{{$estrategia->nome}}</td>
					@if($estrategia->padrao == 1)
						<td>Sim</td>
					@else
						<td>Não</td>
					@endif

					@if($estrategia->padrao == 1 && auth()->user()->admin == 1)
						<td><a href="{{route('gestao.estrategias.edit',['id' => $estrategia->id])}}" class="btn btn-warning"><i class="fa fa-edit"></i> Editar</a> | <a href="{{route('gestao.estrategias.delete',['id' => $estrategia->id])}}" class="btn btn-danger"><i class="fa fa-remove"></i> Excluir</a></td>
					@elseif($estrategia->padrao == 0)
						<td><a href="{{route('gestao.estrategias.edit',['id' => $estrategia->id])}}" class="btn btn-warning"><i class="fa fa-edit"></i> Editar</a> | <a href="{{route('gestao.estrategias.delete',['id' => $estrategia->id])}}" class="btn btn-danger"><i class="fa fa-remove"></i> Excluir</a></td>
					@endif
					
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
    
@stop