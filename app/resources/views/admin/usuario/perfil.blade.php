@extends('adminlte::page')



@section('content_header')



@stop

@section('content')
<div id="loader"></div>

<div class="box">
    	<div class="box-header">
    			<h3 class="box-title">Meu Perfil </h1>
    		<div class="box-body">
    			@include('admin.includes.alerts')
    			<form method="POST" action="{{route('usuario.perfil.update')}}">
    				<div class="form-group">
    					<label>Nome</label>
    					@csrf
    					<input type="text" name="nome" class="form-control" value="{{auth()->user()->nome}}">
    				</div>
    				<div class="form-group">
    					<label>Sobrenome</label>
    					<input type="text" name="sobrenome" class="form-control" value="{{auth()->user()->sobrenome}}">
    				</div>
    				<div class="form-group">
    					<label>E-mail</label>
    					<input type="email" name="email" class="form-control" value="{{auth()->user()->email}}">
    				</div>
    				<div class="form-group">
    					<label>CPF</label>
    					<input type="text" name="cpf" maxlength="11" class="form-control" value="{{auth()->user()->cpf}}">
    				</div>
    				<div class="form-group">
    					<label>DDD</label>
    					<input type="text" name="codigo_area" maxlength="3" class="form-control" value="{{auth()->user()->codigo_area}}">
    				</div>
    				<div class="form-group">
    					<label>Telefone</label>
    					<input type="text" name="telefone" maxlength="11" class="form-control" value="{{auth()->user()->telefone}}">
    				</div>
                    <div class="form-group">
                        <label>Fuso Horário (Time zone)</label>
                        <select class="form-control" name="zona">
                            @if(auth()->user()->zona !=null)
                                <option value="{{auth()->user()->zona}}">Zona Atual: {{auth()->user()->zona}}</option>
                            @endif
                            @foreach(auth()->user()->zonas() as $zona)
                                <option value="{{explode('|',$zona)[0]}}">{{explode('|',$zona)[0]}}</option>
                            @endforeach
                        </select>
                    </div>
    				<div class="form-group">
    					<label>Senha</label>
    					<input type="password" name="password" class="form-control">
    				</div>
    				<div class="form-group">
    					<button class="btn btn-success" type="submit"> Atualizar</button>
    				</div>
    			</form>
    		</div>
    	</div>
    </div>
@stop
