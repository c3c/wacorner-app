@if($errors->any())
	<div class="alert alert-warning">
		@foreach($errors->all() as $error)
			<p><span class="fa fa-thumbs-o-down"></span> {{$error}}</p>
		@endforeach
	</div>
@endif

@if(session('success'))
	<div class="alert alert-success">
			<p><span class="fa fa-thumbs-o-up"></span> {{session('success')}}</p>
	</div>
@endif

@if(session('success_link'))
	<div class="alert alert-success">
			<p><span class="fa fa-thumbs-o-up"></span> <a target="_blank" href="{{session('success_link')}}">Visualizar Boleto</a></p>
	</div>
@endif

@if(session('error'))
	<div class="alert alert-danger">
			<p><span class="fa fa-thumbs-o-down"></span> {{session('error')}}</p>
	</div>
@endif

