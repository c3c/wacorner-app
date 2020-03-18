@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'register-page')

@section('body')
    <div class="register-box">
        <div class="register-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">{{ trans('adminlte::adminlte.register_message') }}</p>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ url(config('adminlte.register_url', 'register')) }}" method="post">
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('nome') ? 'has-error' : '' }}">
                    <input type="text" name="nome" class="form-control" value="{{ old('nome') }}"
                           placeholder="Nome">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                
                <div class="form-group has-feedback {{ $errors->has('sobrenome') ? 'has-error' : '' }}">
                    <input type="text" name="sobrenome" class="form-control" value="{{ old('sobrenome') }}"
                           placeholder="Sobrenome">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                
                <div class="form-group has-feedback {{ $errors->has('cpf') ? 'has-error' : '' }}">
                    <input type="text" name="cpf" class="form-control" value="{{ old('cpf') }}"
                           placeholder="*CPF - somente numeros" maxlength="11">
                    <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                    <small>*CPF - Opcional, mas na hora da comprar de um plano, você deve atualizar seu CPF caso seja BRASILEIRO, para poder pagar pelo PAGSEGURO.</small>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group has-feedback {{ $errors->has('codigo_area') ? 'has-error' : '' }}">
                            <input type="text" name="codigo_area" class="form-control" value="{{ old('codigo_area') }}"
                                   placeholder="DDD" maxlength="3">
                            <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group has-feedback {{ $errors->has('telefone') ? 'has-error' : '' }}">
                            <input type="text" name="telefone" class="form-control" value="{{ old('telefone') }}"
                                   placeholder="Telefone" maxlength="9">
                            <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                           placeholder="{{ trans('adminlte::adminlte.email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    
                </div>
                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" name="password" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                   
                </div>
                <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.retype_password') }}">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    
                </div>
                <button type="submit"
                        class="btn btn-primary btn-block btn-flat"
                >{{ trans('adminlte::adminlte.register') }}</button>
            </form>
            <div class="auth-links">
                <a href="{{ url(config('adminlte.login_url', 'login')) }}"
                   class="text-center">{{ trans('adminlte::adminlte.i_already_have_a_membership') }}</a>
            </div>
        </div>
        <!-- /.form-box -->
    </div><!-- /.register-box -->
@stop

@section('adminlte_js')
    @yield('js')
@stop
