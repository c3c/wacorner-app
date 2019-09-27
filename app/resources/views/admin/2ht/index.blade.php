@extends('adminlte::page')



@section('content_header')


	@if($data == date('Y-m-d'))
		<a href="{{route('admin.2ht.data', ['data' => date('Y-m-d', strtotime('+1 days'))])}}" class="btn btn-primary"><i class="fa fa-share" aria-hidden="true"></i> Jogos de amanhã</a>
	@else
		<a href="{{route('admin.2ht')}}" class="btn btn-primary"><i class="fa fa-share" aria-hidden="true"></i> Jogos de hoje</a>
	@endif

@stop

@section('content')

<div class="box">
    	<div class="box-header">
    			<h3 class="box-title">Média 2º Tempo</h1>
  		
    		<div class="box-body">

    			<table class="table table-striped">
	                <tbody>
	                	<tr>
		                 	<th>Liga</th>
		                  	<th>Data</th>
		                  	<th>Hora</th>
		                  	<th>Jogo</th>
		                  	<th>Média</th>
		                </tr>
		                @foreach($jogos as $jogo)
			                <tr>
			                  	<td>{{$jogo->liga->l}}</td>
			                  	<td class="fuso_data">{{date('Y-m-d',  strtotime($jogo->start))}}</td>
	                  			<td class="fuso_time">{{date('H:i',  strtotime($jogo->start))}}</td>
			                  	<td><strong><a style="color: #000;" target="_blank" href="{{route('admin.jogo',['id'=>$jogo->id])}}">{{$jogo->time_casa->nome}} x {{$jogo->time_fora->nome}} </a></td>
			                  	<td><span class="badge bg-green">{{$jogo->ht2}} cantos</span></td>
			                </tr>
		                @endforeach
	              </tbody>
	          	</table>
    			  {{$jogos->links()}} 						
    		</div>
    	</div>
    </div>
    
@stop