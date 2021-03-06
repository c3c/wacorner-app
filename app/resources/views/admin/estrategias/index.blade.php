@extends('adminlte::page')



@section('content_header')


	@if($data == date('Y-m-d'))
		<a href="{{route('admin.estrategia', ['estrategia'=>$estrategia,'data' => date('Y-m-d', strtotime('+1 days'))])}}" class="btn btn-primary"><i class="fa fa-share" aria-hidden="true"></i> Jogos de amanhã</a>
	@else
		<a href="{{route('admin.estrategia', ['estrategia'=>$estrategia,'data' => date('Y-m-d')])}}" class="btn btn-primary"><i class="fa fa-share" aria-hidden="true"></i> Jogos de hoje</a>
	@endif

@stop

@section('content')

<div class="box">
    
	<tabela-porcentagem url_jogo="{{route('admin.jogo',['id' =>''])}}" estrategia="{{$estrategia}}" url="{{route('admin.jogos.estrategia',['estrategia'=>$estrategia,'data' => $data])}}" url_lista="{{route('listas')}}" zona="{{auth()->user()->zona}}" url_gestao="{{route('gestao.estrategias')}}"></tabela-porcentagem>

	<modal  nome="adicionar-lista" titulo="Adicionar na lista">
    	<form-lista id='form-add-lista' token="{{ csrf_token() }}" url_lista="{{route('listas')}}"></form-lista>
        <span slot="botoes">
            <button form="form-add-lista" class="btn btn-info">Adicionar</button>
        </span>
	</modal> 

	<modal  nome="adicionar-gestao" titulo="⛳️ Adicionar a GESTÃO">
		<form-add-gestao id='form-add-gestao' token="{{ csrf_token() }}" url_gestao="{{route('gestao')}}" entrada="{{auth()->user()->gestao->stake}}"></form-add-gestao>
	    <span slot="botoes">
	        <button form="form-add-gestao" class="btn btn-info">Adicionar</button>
	    </span>
	</modal>

</div>
    
@stop