@extends('adminlte::page')


@section('content')

<div class="box">
	<div class="box-header">
		<h1>Meus Robôs</h1>
		<!-- <a href="{{route('robos.notificacoes')}}" class="btn btn-warning" target="_blank"><i class="fa fa-bell-o"></i> Notificações dos Robôs</a> -->
		@if(auth()->user()->telegram_chat_id == null)
		<a href="https://telegram.me/WAcornerBot?start={{auth()->user()->id}}" class="btn btn-success" target="_blank"><i class="fa fa-bell-o"></i> Conectar ao Telegram</a>
		@else
		<h5><b>☑️ Conectado ao Telegram </b> <a href="{{route('robos.desconectar',['id' => auth()->user()->id])}}" class="btn btn-warning" > Desconectar</a></h5>
		@endif
	</div>
	<div class="box-body">
		@include('admin.includes.alerts')
		<table class="table">
			<thead>
				<tr>
					<th>Nome</th>
					<th>Status</th>
					<th>Ativo?</th>
				</tr>
			</thead>
			<tbody>
				@if($robos->count() != 0)
					@foreach($robos as $robo)
						<tr>
							<td>{{$robo->nome}}</td>					
							<td>{{$robo->status == 0 ? 'Desativado' : 'Ativo'}}</td>
							@if($robo->status == '0')					
								<td><a href="{{route('robos.alterar.status',['id' => $robo->id])}}" class="btn btn-primary">Ativar</a></td>		
							@else
								<td>
									<a href="{{route('robos.alterar.status',['id' => $robo->id])}}" class="btn btn-danger">Desativar</a>
									<a href="{{route('robos.edit',['id' => $robo->id])}}" class="btn btn-warning">Configurar</a>
								</td>		
							@endif
						</tr>
					@endforeach
				@else
					<tr>
						<td>HT1020</td>					
						<td>Desativado</td>					
						<td><a href="{{route('robos.create.nome',['nome' => 'HT1020'])}}" class="btn btn-primary">Ativar</a></td>	
					</tr>
					<tr>
						<td>HT35</td>					
						<td>Desativado</td>					
						<td><a href="{{route('robos.create.nome',['nome' => 'HT35'])}}" class="btn btn-primary">Ativar</a></td>	
					</tr>
					<tr>
						<td>HT38</td>					
						<td>Desativado</td>					
						<td><a href="{{route('robos.create.nome',['nome' => 'HT38'])}}" class="btn btn-primary">Ativar</a></td>	
					</tr>
					<tr>
						<td>FT75</td>					
						<td>Desativado</td>					
						<td><a href="{{route('robos.create.nome',['nome' => 'FT75'])}}" class="btn btn-primary">Ativar</a></td>	
					</tr>
					<tr>
						<td>FT82</td>					
						<td>Desativado</td>					
						<td><a href="{{route('robos.create.nome',['nome' => 'FT82'])}}" class="btn btn-primary">Ativar</a></td>	
					</tr>
					<tr>
						<td>FT88</td>					
						<td>Desativado</td>					
						<td><a href="{{route('robos.create.nome',['nome' => 'FT88'])}}" class="btn btn-primary">Ativar</a></td>	
					</tr>
				@endif
			</tbody>
		</table>
		
	</div>
</div>
    
@stop