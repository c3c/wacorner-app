@extends('adminlte::page')



@section('content_header')



@stop

@section('content')

<div class="box">
    	<div class="box-header">
    			<h3 class="box-title">Adicionar Cupom Promocional</h1>
    		<div class="box-body">
    			<div class="alert alert-info">@if(auth()->user()->ativo())
    				Data de expiração: {{date('d/m/Y',strtotime(auth()->user()->data_expiracao))}} @else NENHUM PLANO ATIVO @endif </div>
    			
    			@include('admin.includes.alerts')
    			
                <div class="row">
                    <div class="col-md-3">
                        <form action="{{route('venda.cupom.validar')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title"> Codigo do cupom</label>
                                <input type="text" name="codigo" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success"> Adicionar</button>
                        </form>
                    </div>
                </div>
                			
    		</div>
    	</div>
    </div>





@stop

