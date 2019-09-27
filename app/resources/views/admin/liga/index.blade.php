@extends('adminlte::page')



@section('content_header')

@stop

@section('content')
<div id="loader"></div>

<div class="box">
   	<div class="box-header">
   		<div class="col-md-3">
   			<h3 class="box-title">Ligas</h1>
   		</div>
   		<div class="col-md-offset-6 col-md-3">

	   		<form action="{{route('liga.search')}}" class="form form-inline" method="POST">
	   			@csrf
	   			<input type="text" name="l" class="form-control" placeholder="Nome da liga">
	   			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
	   		</form>
	   	</div>
   	</div>

	<div class="box-body">
		@include('admin.includes.alerts')
		<table class="table table-striped">
	        <tbody>
	        	<tr>
	             	<th>#</th>
	             	<th>Nome</th>
	               	<th>API ID</th>
	               	<th>Ativa?</th>
	     
	            </tr>
	            @foreach($ligas as $liga)
	                <tr>
	                  	<td>{{$liga->id}}</td>
	                  	<td>{{$liga->l}}</td>
	         			<td>{{$liga->l_id}}</td>
	         			<td>
							@if($liga->ativo == 1)
	         					<a href="{{route('liga.ativar',['id' => $liga->id])}}" class="btn btn-xs btn-success"><span class="fa fa-check"></span></a>
	         				@else
	         					<a href="{{route('liga.ativar',['id' => $liga->id])}}" class="btn btn-xs btn-danger"><span class="fa fa-close"></span></a>		         							
	         				@endif 
	         			</td>
	         			
	                </tr>
	            @endforeach
	      	</tbody>
  		</table>	
  		@if(isset($data))
  			{{$ligas->appends($data)->links()}}
  		@else
  			{{$ligas->links()}}
  		@endif				
	</div>
</div>
@stop


