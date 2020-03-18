@extends('adminlte::page')


@section('content_header')
@stop

@section('content')

<div class="box">
  <div class="box-header">
      <div class="col-md-3">
        <h3 class="box-title">Minhas Listas</h1>
      </div>
      <div class="col-md-offset-7 col-md-2">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#lista-add">
          Nova Lista
        </button>
        
      </div>
    </div>
  <div class="box-body">
    @include('admin.includes.alerts')
    @forelse($listas as $lista)
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$lista->id}}" aria-expanded="true" aria-controls="collapseOne">
              <i class="fa fa-soccer-ball-o "></i> {{$lista->nome}} 
            </a>
          </h4>
        </div>
        <div id="collapse{{$lista->id}}" class="panel panel-default" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
            <a href="{{route('lista.delete',['id' => $lista->id])}}" class="btn btn-danger btn-xs"> <i class="fa fa-remove"></i> Excluir a lista</a>
            <a href="{{route('lista.limpar',['id' => $lista->id])}}" class="btn btn-primary btn-xs"> <i class="fa fa-bomb"></i> Limpar lista</a>
            <br><br>
            @forelse($lista->jogos()->orderBy('start','desc')->get() as $jogo)
              <ul>
                <li><b>DATA:</b> <span class="fuso">{{date('Y-m-d H:i',  strtotime($jogo->start))}}</span>  - <b>LIGA:</b> {{$jogo->liga->l}} - <b>JOGO: <a style="color: #00b300" target="_blank" href="{{route('admin.jogo',['id'=>$jogo->id])}}">  {{$jogo->time_casa->nome}} x {{$jogo->time_fora->nome}} </i></a></b> <a href="{{route('lista.delete.jogo',['id_lista'=>$lista->id, 'id_jogo' => $jogo->id])}}" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a></li>
              </ul>
            @empty
              SEM JOGOS
            @endforelse
          </div>
        </div>
      </div>
    </div>   
    @empty
      SEM LISTAS
    @endforelse   
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="lista-add" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nova lista</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-lista-new" action="{{route('lista.new')}}" method="POST">
          @csrf
          <div class="form-group">
            <label for="title"> Nome da lista</label>
            <input type="text" name="nome" class="form-control" required>
          </div>
        </form>  
      </div>
      <div class="modal-footer">
        <button  type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button form="form-lista-new" class="btn btn-primary">Salvar</button>
         
      </div>
    </div>
  </div>
</div>
@stop