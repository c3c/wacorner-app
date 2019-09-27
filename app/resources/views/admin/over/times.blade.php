@extends('adminlte::page')



@section('content_header')
@stop

@section('content')

<div class="box">
    	<div class="box-header">
    			<h3 class="box-title">Top times em cantos</h1>
    		<div class="box-body">
    			<table class="table table-striped">
	                <tbody>
	                	<tr>
		                 	<th>Time</th>
		                  	
		                  	<th>Faz por jogo (Média)</th>
		                </tr>
		                @foreach($times as $time)
		                	
			                <tr>
			                  	<td>{{$time->nome}}</td>
			                  	
			         			<td>{{round($time->cantos)}} cantos</td>
			                </tr>
			                
		                @endforeach
	              </tbody>
	          	</table>						
    		</div>
    	</div>
    </div>
    
@stop