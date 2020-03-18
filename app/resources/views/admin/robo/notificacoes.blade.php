@extends('adminlte::page')


@section('content')

<div class="box">
	<div class="box-header">
		<h1>Jogos Encontrados pelos Robôs</h1>
		<a href="{{route('robos.notificacoes.delete.all')}}" class="btn btn-danger">Excluir Todas</a>
	</div>
	<div class="box-body">
		@include('admin.includes.alerts')
		<table class="table">
			<thead>
				<tr>
					<th>Data</th>
					<th>Jogo</th>
					<th>Liga</th>
					<th>Robo</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
				@foreach($notificacoes as $notificacao)
					<tr>
						<td>{{$notificacao['data'] }}</td>					
						<td>{{$notificacao['time_casa'] }} x {{$notificacao['time_fora'] }}</td>					
						<td>{{$notificacao['liga'] }}</td>
						<td>{{$notificacao['robo']->nome }}</td>
						<td>
							<a href="{{route('admin.jogo',['id' => $notificacao['jogo_id']])}}" class="btn btn-primary">Ver Jogo</a>
							<a href="{{route('robos.notificacoes.delete.id',['id' => $notificacao['notificacao_id']])}}" class="btn btn-danger">Excluir</a>
						</td>		
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
    
@stop

@section('js')
	<script type="text/javascript">

		
	</script>
@stop