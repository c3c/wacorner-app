@extends('adminlte::page')


@section('content')

<div class="box">
	<div class="box-header">
		<h1>Configurar Robô {{$robo->nome}}</h1>
	</div>
	<div class="box-body">
		@include('admin.includes.alerts')
		<div class="col-md-6">
			<form id="form-robo-edit" action="" method="POST">
				@csrf
				<input type="hidden" name="estrategia_id" value="">
				<div class="form-group"> 
					<label for="title">(Minutos) Intervalo de Notificação</label>
					<div class="slider-container"  style="margin-top: 2em;">
			            <input type="text" id="intervalo" class="slider" />
			            <input type="hidden" name="intervalo_inicio" id="intervalo_inicio">
			            <input type="hidden" name="intervalo_fim" id="intervalo_fim">
			        </div>
			    </div>
			    <hr>
			    <div class="row">
			    	<div class="col-md-6">
			    		<div class="form-group">
			    			<label for="title"> Diferença de gols entre os times?</label>
			    			<input type="number" name="diferenca_gols" class="form-control">
			    		</div>
			    		<div class="form-group">
			    			<label for="title"> Quantidade mínima de escanteios na partida?</label>
			    			<input type="number" name="escanteios_min" class="form-control">
			    		</div>
			    		
			    	</div>
			    	<div class="col-md-6">
			    		<div class="form-group">
			    			<label for="title"> Qual situação o Jogo deve estar?</label>
			    			<div class="radio">
			    				<label>
			    					<input type="radio" name="situacao" onclick="$('#superioridade-input').show()" value="f-s-p" checked>
			    					Favorito ou Super Favorito perdendo
			    				</label>
			    			</div>
			    			<div class="radio">
			    				<label>
			    					<input type="radio" name="situacao" onclick="$('#superioridade-input').show()" value="f-s-e">
			    					Favorito ou Super Favorito empatando
			    				</label>
			    			</div>
			    			<div class="radio">
			    				<label>
			    					<input type="radio" name="situacao" onclick="$('#superioridade-input').show()" value="f-s-p-e">
			    					Favorito ou Super Favorito perdendo ou empatando
			    				</label>
			    			</div>
			    			<div class="radio">
			    				<label>
			    					<input type="radio" name="situacao" onclick="$('#superioridade-input').hide()" value="jogo-parelho">
			    					Jogo Parelho
			    				</label>
			    			</div>
			    		</div>
			    	</div>
			    </div>

				
				<span id="superioridade-input">
					<hr>
					<div class="form-group" >
						<label for="title">(%) Superioridade mínima do Favorito ou Super Favoito?</label>
						<div class="slider-container"  style="margin-top: 2em;">
				            <input type="text" id="slider2" class="slider" />
				            <input type="hidden" name="superioridade" id="superioridade">
		
				        </div>
				    </div>
				</span>
				<hr>
				<div class="form-group">
					<label for="title">Qual a quantidade mínima de jogos anteriores devem ser analisados?</label>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="title">Casa</label>
							<input type="number" max="10" min="1" class="form-control" name="qtd_min_jogos_casa">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="title">Fora</label>
							<input type="number" max="10" min="1" class="form-control" name="qtd_min_jogos_fora">
						</div>
					</div>
				</div>
				<hr>
				<div class="form-group">
					<label for="title">(%) Qual a porcentagem mínima nessa estratégia?</label>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="title">Casa</label>
							<input type="number" max="90" min="0" step="10" class="form-control" name="porcentagem_min_casa">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="title">Fora</label>
							<input type="number" max="90" min="0" step="10" class="form-control" name="porcentagem_min_fora">
						</div>
					</div>
				</div>
				<div class="form-group">
					<button form="form-robo-edit" type="submit" class="btn btn-success"> Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>
    
@stop

@section('js')
	<script type="text/javascript">
		var intervalo = new rSlider({
                    target: '#intervalo',
                    values: {min: 0, max: 90},
                    step: 1,
                    range: true,
                    set: [0, 90],
                    scale: true,
                    labels: false,
                    onChange: function (vals) {
                        var valores = vals.split(',');
                       	$("#intervalo_inicio").val(valores[0]);
                       	$("#intervalo_fim").val(valores[1]);
                    }
                });

		var slider2 = new rSlider({
                    target: '#slider2',
                    values: {min: 0, max: 90},
                    step: 1,
                    range: false,
                    set: [0],
                    scale: true,
                    labels: false,
                    onChange: function (vals) {
                        $("#superioridade").val(vals);
                       	
                    }
                });
			
	</script>
@stop