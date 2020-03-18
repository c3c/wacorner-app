@extends('adminlte::page')


@section('content_header')
@stop

@section('content')

<div class="box">
    	<div class="box-header">
    		<div class="col-md-3">
	   			<h3 class="box-title"><i class="fa fa-users"></i> Meus Indicados</h1>
	   		</div>
	   		<div class="col-md-offset-5 col-md-4">

		   		<a class="btn btn-warning" href="{{route('saque.index',['user_id'=>$afiliado->id])}}"><i class="glyphicon glyphicon-usd"></i> Meus Saques</a>
		   		<a class="btn btn-success" href="{{route('indicados.converter.dias',['id'=>$afiliado->id])}}"><i class="glyphicon glyphicon-usd"></i> Converter saldo em dias</a>
		   	</div>
		</div>
    			
    		<div class="box-body">
			@include('admin.includes.alerts')
    			<div class="row">
				        <div class="col-md-3 col-sm-6 col-xs-12">
				          <div class="info-box">
				            <span class="info-box-icon bg-green"><i class="fa fa-usd"></i></span>

				            <div class="info-box-content">
				              <span class="info-box-text">Meu Saldo</span>
				              <span class="info-box-number"> R${{$afiliado->saldo}}</span>
				            </div>
				            <!-- /.info-box-content -->
				          </div>
				          <!-- /.info-box -->
				        </div>
				        <!-- /.col -->
				        <div class="col-md-3 col-sm-6 col-xs-12">
				          <div class="info-box">
				            <span class="info-box-icon bg-blue"><i class="fa fa-users"></i></span>

				            <div class="info-box-content">
				              <span class="info-box-text">Total</span>
				              <span class="info-box-number">{{$total}}<small> indicados</small></span>
				            </div>
				            <!-- /.info-box-content -->
				          </div>
				          <!-- /.info-box -->
				        </div>
				        <!-- /.col -->
				      </div>
    			<div class="alert alert-success">
    				<p><span class="fa fa-link"></span> <b>Seu Link de Divulgação:</b> https://wacorner.com/afi/{{$afiliado->id}}</p>
    				<p><span class="fa fa-hand-pointer-o"></span> <b>Regra de comissionamento*:</b> último clique</p>
    				<br>
    				<p>*Utilizamos cookies para salvar sua indicação, então caso o usuario não se cadastre agora, mas no seu navegador será salvo seu id, e caso ele se cadastre você ganhará o indicado, mas caso ele se cadastre com outro link de afiliado, esse id é atualizado, ele só não atualiza caso o usario acesse diretamente o site sem ser por link de algum outro afiliado. Para mais informações, manda um email para wacornerstats@gmail.com</p>
    			</div>
    			
    			<div class="table-responsive">
    			<table class="table table-striped">
	                <tbody>
	                	<tr>

		                 	<th>#</th>
		                  	<th>E-mail</th>
		                  	<th>Nome</th>
		                  	<th>Compras do Mês</th>
		                  	<th>Data</th>
		                  	
		         
		                </tr>
		                @foreach($usuarios as $usuario)
		                	
			                <tr>
			                  	<td>{{$usuario->id}}</td>
			                  	<td>{{$usuario->email}}</td>
			                  	<td>{{$usuario->nome}}</td>
			                  	<td>{{$usuario->vendasMes()->count()}}</td>
			                  	<td>{{date('d/m/Y',strtotime($usuario->created_at))}}</td>
			                </tr>
			            
		                @endforeach
	              </tbody>
	          	</table>
	          	</div>	
	          	{{$usuarios->links()}}					
    		</div>
    </div>
@stop