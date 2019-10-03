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
    		<h3 class="box-title">Informe uma nova senha </h3>
    		<div class="box-body">
    			@include('admin.includes.alerts')
    			<form method="POST" id="altera-senha"  action="{{route('admin.usuario.nova.senha')}}">
    				<input type="hidden" name="id" value="{{$usuario->id}}">
    					@csrf
    				<div class="form-group">
    					<label>Nova senha</label>
    					<input type="password" name="password" class="form-control">
    				</div>
                    
    				<div class="form-group">
    					<button class="btn btn-success" form="altera-senha" type="submit"> Salvar</button>
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
