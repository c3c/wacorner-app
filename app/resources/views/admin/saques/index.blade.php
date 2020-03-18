@extends('adminlte::page')

@section('content')

<div class="box">
	<div class="box-header">
		<h3 class="box-title">RELATÓRIO DE SAQUES</h1>
    <div class="alert alert-info">
      <h4>Regras Básicas para Sacar um Valor:</h4>
      <ul>
        <li>Você deve ter no minímo R$100,00 para poder sacar.</li>
        <li>Só pagamos através de PicPay, caso não tenha uma conta crie clicando no nosso link a seguir: <a href="http://www.picpay.com/convite?@P9246G" class="btn btn-success">CRIAR CONTA NO PICPAY</a></li>
      </ul>
    </div>
	</div>
	<div class="box-body">
		@include('admin.includes.alerts')    			
		<h4>Total pago: <span class="badge bg-green">R$ {{$total}}</span> | Meu Saldo Agora: <span class="badge bg-blue">R$ {{$user->saldo}}</span></h4>
		  <!-- Button trigger modal -->
			<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal"> <i class="fa fa-usd"></i> Novo Saque
			</button>
		<table class="table table-striped">
            <tbody>
            	<tr>
                  	<th>Data</th>
                  	<th>Valor</th>
                  	<th>Status</th>
                    <th>OBS</th>
                </tr>
                @foreach($saques as $key => $saque)
	                <tr>
	                  	<td>{{$saque->created_at}}</td>
	                  	<td>{{$saque->valor}}</td>
	                  	<td>{{$saque->status}}</td>
                      <td>{{$saque->obs}}</td>
	                </tr>
                @endforeach
          </tbody>
      	</table>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Novo Saque</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form id="form-saque" action="{{route('saque.store')}}" method="POST">
        	@csrf
        	<input type="hidden" name="user_id" value="{{$user->id}}">
        	<div class="form-group">
        		<label for="title"> Valor (Obrigatório)</label>
        		<input type="number" name="valor" step="0.01" max="{{$user->saldo}}" min="100" class="form-control" required>
        	</div>        	
        	<div class="form-group">
        		<label for="title"> Seu Usuário no PICPAY (Ex: @wacorner)(Obrigatório)</label>
        		<input name="obs" class="form-control" required> 
        	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button form="form-saque" type="submit" class="btn btn-primary">Salvar</button>
        </form>	
      </div>

    </div>
  </div>
</div>



    

@stop
