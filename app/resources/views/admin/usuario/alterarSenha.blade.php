@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
<div class="login-box">
        <div class="login-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
        </div>
        
    	<div class="login-box-body">
    		<h3 class="box-title">Informe os dados para encontrarmos seu cadastro </h3>
    		<div class="box-body">
    			@include('admin.includes.alerts')
    			<form method="POST" id="altera-senha"  action="{{route('admin.usuario.busca.cadastro')}}">
    				
    					@csrf
    				<div class="form-group">
    					<label>E-mail</label>
    					<input type="email" name="email" class="form-control">
    				</div>
    				<div class="form-group">
    					<label>Telefone sem DDD</label>
    					<input type="text" name="telefone" maxlength="11" class="form-control">
    				</div>
                    </div>
    				<div class="form-group">
    					<button class="btn btn-success" form="altera-senha" type="submit"> Enviar</button>
    				</div>
    			</form>
    		</div>
    	</div>
    </div>
</div>
@stop

@section('adminlte_js')
    @yield('js')
@stop
