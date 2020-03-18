@extends('adminlte::page')


@section('content_header')
@stop

@section('content')

<div class="box">
    	<div class="box-header">
    		<div class="col-md-3">
	   			<h3 class="box-title">Afiliados - Valor: R${{$total}}</h1>
	   		</div>
	   		<div class="col-md-offset-3 col-md-6">

		   		<!-- <form action="{{route('usuario.search')}}" class="form form-inline" method="POST">
		   			@csrf
		   			<input type="text" name="email" class="form-control" placeholder="E-mail">
		   			<input type="text" name="cpf" class="form-control" placeholder="CPF">
		   			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
		   		</form> -->
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
		                  	<th>Nº Indicados</th>
		                  	<th>Saldo</th>
		                  	<th>Ações</th>
		                  	
		         
		                </tr>
		                @foreach($afiliados as $afiliado)
		                	
			                <tr>
			                  	<td>{{$afiliado->id}}</td>
			                  	<td>{{$afiliado->email}}</td>
			                  	<td>{{$afiliado->nome}}</td>
			                  	<td>{{$afiliado->users()->count()}}</td>
			                  	<td>R$ {{$afiliado->saldo}}</td>
			                  	<td><a href="{{route('indicados.show',['id' => $afiliado->id])}}" class="btn btn-success"><i class="fa fa-users" aria-hidden="true"></i> Indicados</a></td>
			                </tr>
			            	
		                @endforeach
	              </tbody>
	          	</table>
	          	</div>	
	          	{{$afiliados->links()}}					
    		</div>
    </div>
@stop

