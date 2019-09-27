@extends('layouts.app')
@section('js_header')

    @if(auth()->check())
        @if(auth()->user()->user_id != null)  
            <script>
              fbq('track', 'StartTrial');
            </script>
        @endif
    @endif  
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verifique seu email</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Foi enviado um link para o email ({{auth()->user()->email}}) que você cadastro no nosso sistema, se o email não estiver na caixa de entrada verifique se não está no SPAM do seu email. Lá no seu E-mail clique no botão azul com o seguinte nome " Verify Email Address". Para poder verificar seu email e poder utilizar o sistema normalmente.
                        </div>
                    @endif

                    {{ __('Antes de qualquer coisa, verifique seu email, clicando no link a baixo.') }}
                    <br>
                    <a href="{{ route('verification.resend') }}">Clique aqui para receber o link de verificação no seu email</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
