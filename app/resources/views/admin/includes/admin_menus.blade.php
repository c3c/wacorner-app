@if(auth()->user()->admin == 1)
	<a href="{{route('liga')}}" class="btn btn-danger"><i class="fa fa-soccer-ball-o" aria-hidden="true"></i> Ligas</a>
	<a href="{{route('usuario')}}" class="btn btn-warning"><i class="fa fa-group" aria-hidden="true"></i> Usuarios</a>
	<a href="{{route('cupon')}}" class="btn btn-info"><i class="fa fa-gift" aria-hidden="true"></i> Cupons</a>
	<a href="{{route('indicados')}}" class="btn btn-success"><i class="fa fa-users" aria-hidden="true"></i> Afiliados</a>
	<a href="{{route('saque.pendentes')}}" class="btn btn-danger"><i class="fa fa-retweet" aria-hidden="true"></i> Saques Pendentes</a>
	<a href="{{route('notification')}}" class="btn btn-info"><i class="fa fa-bell" aria-hidden="true"></i> Notificar Usuários</a>

@else
	
	<a href="{{route('indicados.show',['id'=>auth()->user()->id])}}" class="btn btn-success"><i class="fa fa-users" aria-hidden="true"></i> Meus Indicados</a>
@endif