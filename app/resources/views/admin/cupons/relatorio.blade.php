@extends('adminlte::page')


@section('content_header')



@stop

@section('content')

<div class="box">
    	<div class="box-header">
    		<h3 class="box-title">RELATÓRIO DE VENDAS - CUPON {{$cupon->codigo}}</h1>
    	</div>
    	<div class="box-body">    			
    		<h3>Filtrar</h3>
			<form class="form-inline" action="{{route('cupon.relatorio.search')}}" method="post">
				@csrf
				<input type="hidden" name="id" value="{{$cupon->id}}">
				<div class="form-group">
					<label for="title">Data inicial</label>
					<input type="date" name="data_inicio" class="form-control">
				</div>
				<div class="form-group">
					<label for="title">Data final</label>
					<input type="date" name="data_fim" class="form-control">
				</div>
    			<div class="form-group">
    				<button class="btn btn-primary" type="submit"> Buscar</button>
    			</div>
			</form><hr>
			@if(isset($vendas_cupon))
    			<h4>Total de pedidos: <span class="badge bg-green">{{$total_pedidos}} </span>/ Total pago: <span class="badge bg-green">R$ {{$total_pago}}</span></h4>
    			<table class="table table-striped">
	                <tbody>
	                	<tr>
		                  	<th>Usuário</th>
		                  	<th>Nº Vendas</th>
		                </tr>
		                @foreach($vendas_cupon as $key => $venda)
			                <tr>
			                  	<td>{{$key}}</td>
			                  	
			                  	<td>{{$venda}}</td>
			                  	
			                  
			                </tr>
		                @endforeach
	              </tbody>
	          	</table>
	        @endif	
    	</div>
    </div>



    

@stop
