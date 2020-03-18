@extends('adminlte::page')


@section('content_header')



@stop

@section('content')

<div class="box">
    	<div class="box-header">
    		<h3 class="box-title">RELATÓRIO</h1>
    	</div>
    	<div class="box-body">    			
    		<h3>Filtrar pedidos</h3>
    			<form class="form-inline" action="{{route('venda.show.search')}}" method="post">
    				@csrf
    				<div class="form-group">
    					<label for="title">Data inicial</label>
    					<input type="date" name="data_inicio" class="form-control">
    				</div>
    				<div class="form-group">
    					<label for="title">Data final</label>
    					<input type="date" name="data_fim" class="form-control">
    				</div>
    				<div class="form-group">
    					<label for="title">Tipo</label>
	    				<select class="form-control" name="tipo_pagamento">
	    					<option value="">-</option>
	    					<option value="Transferência">Transferência</option>
	    					<option value="cartão">Cartão</option>
	    					<option value="boleto">Boleto</option>
	    				</select>
	    			</div>
	    			<div class="form-group">
	    				<button class="btn btn-primary" type="submit"> Buscar</button>
	    			</div>
    			</form><hr>

    			<h4>Total de pedidos: <span class="badge bg-green">{{$total_pedidos}} </span>/ Total pago: <span class="badge bg-green">R$ {{$total_pago}}</span></h4>
    			<table class="table table-striped">
	                <tbody>
	                	<tr>
		                 	<th>#</th>
		                  	<th>Plano</th>
		                  	@if(auth()->user()->admin == 1)
			                	<th>Usuario</th>
			                @endif
		                  	<th>Tipo</th>
		                  	<th>Status</th>
		                  	<th>Data</th>
		                  	<th>Ações</th>
		                </tr>
		                @foreach($vendas as $venda)
			                <tr>
			                  	<td>{{$venda->id}}</td>
			                  	<td>{{$venda->plano}}</td>
			                  	@if(auth()->user()->admin == 1)
			                  		<td>{{$venda->user->email}}</td>
			                  	@endif
			                  	<td>{{$venda->tipo_pagamento}}</td>
			                  	<td><span class="badge bg-green">{{$venda->status}}</span></td>
			                  	<td>{{$venda->created_at}}</td>
			                  	<td>
			                  		@if($venda->status != 'Paga' && $venda->status != 'Cancelada' || auth()->user()->admin == 1 )
				                  		@if($venda->tipo_pagamento == 'boleto' && $venda->status == 'pendente')
				                  		<a class="btn btn-info" href="{{$venda->referencia}}" target="_blank"><i class="glyphicon glyphicon-shopping-cart"></i> Pagar</a>
				                  		@endif
				                  		<a class="btn btn-danger" href="{{route('venda.delete',['id'=>$venda->id])}}" onclick="return confirm('Tem certeza disso?');"><i class="glyphicon glyphicon-remove"></i> Excluir</a>
				                  		@if(auth()->user()->admin == 1 && $venda->status == 'pendente')
				                  			<a class="btn btn-success" href="{{route('venda.liberar',['id'=>$venda->id])}}" onclick="return confirm('Tem certeza disso?');"><i class="glyphicon glyphicon-plus"></i> Liberar plano</a>
				                  		@endif
				                  	@endif
				                 </td>
			                  
			                </tr>
		                @endforeach
	              </tbody>
	          	</table>
    			
    	</div>
    </div>



    

@stop
