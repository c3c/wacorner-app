@extends('adminlte::page')


@section('content')

<div class="box">
	<div class="box-header">
		<div class="row">
		<div class="col-md-5">
			<h3 class="box-title"><i class="fa fa-money"></i> Apostas Resolvidas </h1>
				<a href="{{route('gestao')}}" class="btn btn-warning btn-xs"><i class="fa fa-reply"></i> Voltar a Gestão</a>
				<a href="{{route('gestao.entradas.excluir.tudo')}}" class="btn btn-danger btn-xs"><i class="fa fa-navicon"></i> Excluir tudo</a>
	   </div>
	</div>
	<div class="box-body">
		@include('admin.includes.alerts')	               	
    <section class="content">
    	<table class="table table-striped">
    		<thead>
    			<tr>
    				<th>Data</th>
    				<th>Liga</th>
    				<th>Jogo</th>
    			@if(auth()->user()->admin == 1)	<th>Over 9</th> @endif
    				<th>Stake</th>
    				<th>Odd</th>
    				<th>Estratégia</th>
    				<th>Resultado</th>
    				<th>Excluir</th>
    			</tr>
    		</thead>
    		<tbody>
    			@forelse($entradas as $entrada)
	    			<tr>
	    				<td>{{date('d/m/Y',strtotime($entrada->jogo->start))}}</td>
	    				<td>{{$entrada->jogo->liga->l}}</td>
	    				<td><a style="color: #00b300" target="_blank" href="{{route('admin.jogo',['id'=>$entrada->jogo->id])}}">  {{$entrada->jogo->time_casa->nome}} x {{$entrada->jogo->time_fora->nome}} </i></a></td>
	    				@if(auth()->user()->admin == 1)	<td>{{$entrada->jogo->over9}}%</td> @endif
						<td>R$ {{$entrada->stake}}</td>
	    				<td>{{$entrada->odd}}</td>
	    				<td>{{$entrada->estrategia->nome}}</td>
	    				@if($entrada->resultado == 'green')
	    					<td><span class="badge bg-green"><i class="fa fa-check"></i> {{$entrada->resultado}}</span></td>
	    				@elseif ($entrada->resultado == 'neutro')
	    					<td><span class="badge bg-blue"><i class="fa fa-circle"></i> {{$entrada->resultado}}</span></td>
	    				@else
	    					<td><span class="badge bg-red"><i class="fa fa-close"></i> {{$entrada->resultado}}</span></td>
	    				@endif
	    				<td><a href="{{route('gestao.entradas.excluir',[ 'id' => $entrada->id])}}"  class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button></td>
	    			</tr>
    			@empty
    				<tr><td colspan="7">Sem entradas</td></tr>
    			@endforelse
    		</tbody>
    	</table>

    	{{ $entradas->links() }}
    </section>
  </div>
</div>
    
@stop
