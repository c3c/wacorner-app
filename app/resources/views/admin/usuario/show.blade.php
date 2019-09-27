@extends('adminlte::page')


@section('content_header')
@stop

@section('content')

<div class="box">
    	<div class="box-header">
    		<div class="col-md-3">
	   			<h3 class="box-title">Usuarios cadastrados - {{$total-3}}</h1>
	   		</div>
	   		<div class="col-md-offset-3 col-md-6">

		   		<form action="{{route('usuario.search')}}" class="form form-inline" method="POST">
		   			@csrf
		   			<input type="text" name="email" class="form-control" placeholder="E-mail">
		   			<input type="text" name="cpf" class="form-control" placeholder="CPF">
		   			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
		   		</form>
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
		                  	<th>Data_Expiração</th>
		                  	<th>Data</th>
		                  	<th>Hora</th>
		                  	<th>Ações</th>
		         
		                </tr>
		                @foreach($usuarios as $usuario)
		                	
			                <tr>
			                  	<td>{{$usuario->id}}</td>
			                  	<td>{{$usuario->email}}</td>
			                  	<td>{{date('d/m/Y',strtotime($usuario->data_expiracao))}}</td>
			                  	<td>{{date('d/m/Y',strtotime($usuario->created_at))}}</td>
			                  	<td>{{date('H:i',strtotime($usuario->created_at))}}</td>
			                  	<td>
			                  		<modal-link tipo="button" nome="add-dias" titulo="Add Dias" css="btn btn-success btn-xs" dado_id="{{$usuario->id}}"></modal-link>
			                  		<a href="{{route('venda.show.user',['id'=>$usuario->id])}}" class="btn btn-info btn-xs">Vendas</a>
			                  		<!-- <a href="{{route('usuario.plano',['email' => $usuario->email, 'plano' => 'basico'])}}" onclick="return confirm('Tem certeza que deseja adicionar um plano?')" class="btn btn-success btn-xs">Add Basico</a> -->
			                  		<a href="{{route('usuario.plano',['email' => $usuario->email, 'plano' => 'profissional'])}}" onclick="return confirm('Tem certeza que deseja adicionar um plano?')" class="btn btn-success btn-xs">Add Profissional</a>
			                  	</td>
			                  	
			                </tr>
			            
		                @endforeach
	              </tbody>
	          	</table>
	          	</div>	
				@if(isset($data))
	          		{{$usuarios->appends($data)->links()}}
				@else
					{{$usuarios->links()}}
				@endif					
    		</div>
    </div>
    

    <modal  nome="add-dias" titulo="Adicionar dias na data de expiração">
    	<form-add-dias id='form-add-dias' token="{{ csrf_token() }}" url="{{route('usuario.add.dias')}}"></form-add-dias>
        <span slot="botoes">
            <button form="form-add-dias" class="btn btn-info">Adicionar</button>
        </span>
	</modal> 
@stop