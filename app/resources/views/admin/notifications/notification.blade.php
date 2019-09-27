@extends('adminlte::page')


@section('content')

<div class="box">
	<div class="box-header">
		<h1>Enviar Notificações para E-mail e No Site</h1>
	</div>
	<div class="box-body">
		@include('admin.includes.alerts')
		<div class="col-md-5">
			<form id="form-notification-new" action="{{route('notification.send')}}" method="POST">
				@csrf
				<div class="form-group">
					<label for="title"> Vai enviar pra quem?</label><br>
					<input type="radio" name="destinatario" value="ativos" checked> Usuarios Ativos<br>
					<input type="radio" name="destinatario" value="inativos"> Usuarios Inativos<br>
					<input type="radio" name="destinatario" value="todos"> Todos
				</div>
				<div class="form-group">
					<label for="title"> Titulo</label>
					<input type="text" name="titulo" class="form-control">
				</div>
				<div class="form-group">
					<label for="title"> Icone (<a target="_blank" href="https://adminlte.io/themes/AdminLTE/pages/UI/icons.html">Link dos icones</a>)</label>
					<input type="text" name="icone" placeholder="Ex: no site vai estar 'fa-user', colocar só 'user'" class="form-control">
				</div>
				<div class="form-group">
					<label for="title"> Texto</label>
					<textarea name="texto" class="form-control">
					</textarea>
				</div>
				<div class="form-group">
					<label for="title"> URL</label>
					<input type="text" name="url" class="form-control">
				</div>
				<div class="form-group">
					<label for="title"> Texto Botão da URL</label>
					<input type="text" name="url_texto" class="form-control">
				</div>
				<div class="form-group">
					<button form="form-notification-new" type="submit" class="btn btn-success"> Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>
    
@stop