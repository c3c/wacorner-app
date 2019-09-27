@extends('adminlte::page')


@section('content_header')



@stop

@section('content')

<div class="box">
    	<div class="box-header">
    			<h3 class="box-title">Histórico</h1>
    		<div class="box-body">
    			
    			<div class="alert alert-info">@if(auth()->user()->ativo())
    				Data de expiração: {{date('d/m/Y',strtotime(auth()->user()->data_expiracao))}} @else NENHUM PLANO ATIVO @endif </div>
    			@include('admin.includes.alerts')
    			@if(auth()->user()->admin == 1)
	    			<div class="row">
				        <div class="col-md-3 col-sm-6 col-xs-12">
				          <div class="info-box">
				            <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>

				            <div class="info-box-content">
				              <span class="info-box-text">Usuários Ativos</span>
				              <span class="info-box-number">{{$total_usuarios}} <small>usuários</small></span>
				            </div>
				            <!-- /.info-box-content -->
				          </div>
				          <!-- /.info-box -->
				        </div>
				        <!-- /.col -->
				        <div class="col-md-3 col-sm-6 col-xs-12">
				          <div class="info-box">
				            <span class="info-box-icon bg-blue"><i class="fa fa-usd"></i></span>

				            <div class="info-box-content">
				              <span class="info-box-text">Total básico Pago</span>
				              <span class="info-box-number">{{$total_basico}} <small>pedidos</small>@if(auth()->user()->admin == 1)<br>@endif</span>
				            </div>
				            <!-- /.info-box-content -->
				          </div>
				          <!-- /.info-box -->
				        </div>
				        <!-- /.col -->
				        <div class="col-md-3 col-sm-6 col-xs-12">
				          <div class="info-box">
				            <span class="info-box-icon bg-blue"><i class="fa fa-usd"></i></span>

				            <div class="info-box-content">
				              <span class="info-box-text">Total Profissional Pago</span>
				              <span class="info-box-number">{{$total_profissional}} <small>pedidos</small>@if(auth()->user()->admin == 1)<br>@endif</span>
				            </div>
				            <!-- /.info-box-content -->
				          </div>
				          <!-- /.info-box -->
				        </div>
				        <!-- /.col -->
				        <!-- fix for small devices only -->
				        <div class="clearfix visible-sm-block"></div>

				        <div class="col-md-3 col-sm-6 col-xs-12">
				          <div class="info-box">
				            <span class="info-box-icon bg-yellow"><i class="fa fa-spinner"></i></span>

				            <div class="info-box-content">
				              <span class="info-box-text">Total pendente</span>
				              <span class="info-box-number">{{$total_pendente}} <small>pedidos</small></span>
				            </div>
				            <!-- /.info-box-content -->
				          </div>
				          <!-- /.info-box -->
				        </div>
				        <!-- /.col -->
				      </div>
    			  @endif

    			@if(auth()->user()->admin == 1)
    			<hr>
	    			<div class="row">
	    				<div class="col-md-12">
	    					<h3><span class="label label-danger">Pedidos por mês</span></h3>
	    					
	    					<canvas id="porPlano"></canvas>
	    				</div>
	    				
	    			</div>
    			<hr>
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
    			</form>
    			@endif
    			<hr>
    			<table class="table table-striped">
	                <tbody>
	                	<tr>
		                 	<th>#</th>
		                  	<th>Plano</th>
		                  	<th>Valor</th>
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
			                  	<td>R$ {{$venda->valor != null ? $venda->valor:0}}</td>
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
    			{{ $vendas->links() }}   
    			 						
    		</div>
    	</div>
    </div>





@stop

@section('js')
	<script type="text/javascript">
		var ctx = document.getElementById('porPlano').getContext('2d');
		var chart = new Chart(ctx, {
		    // The type of chart we want to create
		    type: 'line',

		    // The data for our dataset
		    data: {
		        labels: [@foreach($info_grafico_por_plano['mesAno'] as $info_lable) "{{$info_lable}}", @endforeach],
		        datasets: [{
		            label: "Profissional Pago",
		            backgroundColor: 'rgb(92, 241, 0,0)',
		            borderColor: 'rgb(92, 241, 0)',
		            data: [@foreach($info_grafico_por_plano['mesAno'] as $key => $info_lable) 
		            		@if(isset($info_grafico_por_plano['num_vendas_profissional'][$key]))
		            			"{{$info_grafico_por_plano['num_vendas_profissional'][$key]}}"
		            		@else
		            			""
		            		@endif,
		            	@endforeach],
		        },
		        {
		            label: "Básico Pago",
		            backgroundColor: 'rgb(251, 230, 0,0)',
		            borderColor: 'rgb(251, 230, 0)',
		            data: [@foreach($info_grafico_por_plano['mesAno'] as $key => $info_lable) 
		            		@if(isset($info_grafico_por_plano['num_vendas_basico'][$key]))
		            			"{{$info_grafico_por_plano['num_vendas_basico'][$key]}}"
		            		@else
		            			""
		            		@endif,
		            	@endforeach ],
		        }]
		    },

		    // Configuration options go here
		    options: {
		    	scales: {
		            yAxes: [{
		                ticks: {
		                    beginAtZero:true
		                }
		            }]
		        }
		    }
		});
	</script>
@stop