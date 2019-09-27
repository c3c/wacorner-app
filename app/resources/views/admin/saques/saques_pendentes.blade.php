@extends('adminlte::page')


@section('content_header')
@stop

@section('content')

<div class="box">
    	<div class="box-header">
    		<div class="col-md-3">
	   			<h3 class="box-title"><i class="fa fa-usd"></i> Saques Pendentes ( {{$total}} )</h1>
	   		</div>
	   		
		</div>
    			
    		<div class="box-body">
    			@include('admin.includes.alerts')
    			<div class="table-responsive">
    			<table class="table table-striped">
	                <tbody>
	                	<tr>
		                 	<th>#</th>
		                  	<th>E-mail</th>
		                  	<th>Nome</th>
		                  	<th>Status</th>
		                  	<th>Valor</th>                	
		                  	<th>Valor</th>                	
		         		</tr>
		                @foreach($saques as $saque)
		                	<b>
			                <tr class="info">
			                  	<td>{{$saque->id}}</td>
			                  	<td>{{$saque->user->email}}</td>
			                  	<td>{{$saque->user->nome}}</td>
			                  	<td>{{$saque->status}}</td>
			                  	<td>R$ {{$saque->valor}}</td>
			                  	<td><a href="{{route('saque.confirmar',['id' => $saque->id])}}" class="btn btn-success"><i class="fa fa-check"></i> Confirmar Pagamento</a></td>
			                </tr>
			            	</b>
			                <tr><td colspan="6"><b>Observação:</b> {{$saque->obs}}</td></tr>
			            
		                @endforeach
	              </tbody>
	          	</table>
	          	</div>	
	          	{{$saques->links()}}					
    		</div>
    </div>
@stop