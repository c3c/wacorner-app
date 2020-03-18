@extends('adminlte::page')


@section('content_header')
@stop

@section('content')

<div class="box">
    	<div class="box-header">
    			<h3 class="box-title">Top ligas em cantos</h1>
    		<div class="box-body">
    			<table class="table table-striped">
	                <tbody>
	                	<tr>
		                 	<th>Liga</th>
		                  	
		                  	<th>Média</th>
		                </tr>
		                @foreach($ligas as $liga)
		                	
			                <tr>
			                  	<td>{{$liga->l}}</td>
			                  	
			         			<td>{{round($liga->cantos)}} cantos</td>
			                </tr>
			            
		                @endforeach
	              </tbody>
	          	</table>						
    		</div>
    	</div>
    </div>
    
@stop