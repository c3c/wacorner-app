@extends('adminlte::page')


@section('content_header')


	@if($data == date('Y-m-d'))
		<a href="{{route('admin.ft.data', ['data' => date('Y-m-d', strtotime('+1 days'))])}}" class="btn btn-primary"><i class="fa fa-share" aria-hidden="true"></i> Jogos de amanhã</a>
	@else
		<a href="{{route('admin.ft')}}" class="btn btn-primary"><i class="fa fa-share" aria-hidden="true"></i> Jogos de hoje</a>
	@endif

@stop

@section('content')

<div class="box">
    	<div class="box-header">
	        <div class="row">
		        <div class="col-md-2">
		        	<h3 class="box-title">Média Total</h3>
		        </div>
		        <div class="col-md-10">
		            <div class="form-inline">
		            	<form id="form-media" action="" method="POST">
		            	@csrf
		            	<input type="hidden" name="data" value="{{$data}}">
			            <label for="title"> Min. de jogos ant. por time</label>
			            <select name="n_jogos" class="form-control">
			                <option value="">-</option>
			                <option value="1">1</option>
			                <option value="2">2</option>
			                <option value="3">3</option>
			                <option value="4">4</option>
			                <option value="5">5</option>
			                <option value="6">6</option>
			                <option value="7">7</option>
			                <option value="8">8</option>
			                <option value="9">9</option>
			                <option value="10">10</option>
			            </select>
			            <label for="title"> Média min.</label>
				        <input type="text" name="media_min" class="form-control">
				        <button form="form-media" class="btn btn-primary">Filtrar</button>
				        </form>
			                 
		            </div>         
	          	</div>
	        </div>
	    </div>
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
			                  	<td><span class="badge bg-green">{{$jogo->ft}} cantos</span></td>
			                </tr>
		                @endforeach
	              </tbody>
	          	</table>
  	    		@if(isset($dataForm))
  			   		{{$jogos->appends($dataForm)->links()}}	
  			   	@else
  			   		{{$jogos->links()}}	
  			   	@endif	  								
    		</div>
    	</div>
    </div>
    
@stop