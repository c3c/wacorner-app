


<?php $__env->startSection('content'); ?>

<div class="box">
	<div class="box-header">
		<h1>Configurar Robô <?php echo e($robo->nome); ?></h1>
	</div>
	<div class="box-body">
		<?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<div class="col-md-7">
			<form id="form-robo-edit" action="<?php echo e(route('robos.update',['id' => $robo->id])); ?>" method="POST">
				<?php echo csrf_field(); ?>
				<?php echo method_field('PUT'); ?>
				<input type="hidden" name="estrategia_id" value="">
				<div class="form-group"> 
					<label for="title">(Minutos) Intervalo de Notificação (<span id="intervalo-notificacao"></span>)</label>
					<div class="slider-container"  style="margin-top: 2em;">
			            <input type="text" id="intervalo" class="slider" />
			            <input type="hidden" name="intervalo_inicio" id="intervalo_inicio" value="<?php echo e($robo->intervalo_inicio); ?>">
			            <input type="hidden" name="intervalo_fim" id="intervalo_fim" value="<?php echo e($robo->intervalo_fim); ?>">
			        </div>
			    </div>
			    <hr>
			    <div class="row">
			    	<div class="col-md-6">
			    		<div class="form-group">
			    			<label for="title"> Diferença máxima de gols entre os times?</label>
			    			<input type="number" name="diferenca_gols" class="form-control" value="<?php echo e($robo->diferenca_gols); ?>" required>
			    		</div>
			    		<div class="form-group">
			    			<label for="title"> Quantidade mínima de escanteios na partida?</label>
			    			<input type="number" name="escanteios_min" class="form-control" value="<?php echo e($robo->escanteios_min); ?>" required>
			    		</div>
			    		
			    	</div>
			    	<div class="col-md-6">
			    		<div class="form-group">
			    			<label for="title"> Qual situação o Jogo deve estar?</label>
			    			<div class="radio">
			    				<label>
			    					<?php if($robo->situacao == 'f-s-p'): ?>
			    						<input type="radio" name="situacao" onclick="ativa_campos()" value="f-s-p" checked>
			    					<?php else: ?>
			    						<input type="radio" name="situacao" onclick="ativa_campos()" value="f-s-p">
			    					<?php endif; ?>
			    					Favorito ou Super Favorito perdendo
			    				</label>
			    			</div>
			    			<div class="radio">
			    				<label>
			    					<?php if($robo->situacao == 'f-s-e'): ?>
			    						<input type="radio" name="situacao" onclick="ativa_campos()" value="f-s-e" checked>
			    					<?php else: ?>
			    						<input type="radio" name="situacao" onclick="ativa_campos()" value="f-s-e">
			    					<?php endif; ?>
			    					Favorito ou Super Favorito empatando
			    				</label>
			    			</div>
			    			<div class="radio">
			    				<label>
			    					<?php if($robo->situacao == 'f-s-p-e'): ?>
			    						<input type="radio" name="situacao" onclick="ativa_campos()" value="f-s-p-e" checked>
			    					<?php else: ?>
			    						<input type="radio" name="situacao" onclick="ativa_campos()" value="f-s-p-e">
			    					<?php endif; ?>
			    					Favorito ou Super Favorito perdendo ou empatando
			    				</label>
			    			</div>
			    			<div class="radio">
			    				<label>
			    					<?php if($robo->situacao == 'jogo-parelho'): ?>
			    						<input type="radio" name="situacao" onclick="desativa_campos()" value="jogo-parelho" checked>
			    					<?php else: ?>
			    						<input type="radio" name="situacao" onclick="desativa_campos()" value="jogo-parelho">
			    					<?php endif; ?>
			    					Jogo Parelho
			    				</label>
			    			</div>
			    		</div>
			    	</div>
			    </div>
				<span class="tem-favorito">
					<hr>
					<div class="form-group" >
						<label for="title">(%) Superioridade mínima do Favorito ou Super Favoito?</label>
						<div class="slider-container"  style="margin-top: 2em;">
				            <input type="text" id="slider2" class="slider" />
				            <input type="hidden" name="superioridade" id="superioridade" value="<?php echo e($robo->superioridade); ?>">
		
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
							<input type="number" max="10" min="1" class="form-control" name="qtd_min_jogos_casa" value="<?php echo e($robo->qtd_min_jogos_casa); ?>" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="title">Fora</label>
							<input type="number" max="10" min="1" class="form-control" name="qtd_min_jogos_fora" value="<?php echo e($robo->qtd_min_jogos_fora); ?>" required>
						</div>
					</div>
				</div>
				<hr>
				<div class="form-group">
					<label for="title">(%) Qual a porcentagem mínima nessa estratégia?</label>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="title">Total</label>
							<input type="number" max="90" min="0" step="1" class="form-control" name="porcentagem_min_total" value="<?php echo e($robo->porcentagem_min_total); ?>" required>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="title">Casa</label>
							<input type="number" max="90" min="0" step="1" class="form-control" name="porcentagem_min_casa" value="<?php echo e($robo->porcentagem_min_casa); ?>" required>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="title">Fora</label>
							<input type="number" max="90" min="0" step="1" class="form-control" name="porcentagem_min_fora" value="<?php echo e($robo->porcentagem_min_fora); ?>" required>
						</div>
					</div>
				</div>
				<span class="tem-favorito">
				<div class="form-group">
					<label for="title">Media miníma de cantos Favorito ou Superfavorito na estratégia <?php echo e($robo->nome); ?>?</label>
				</div>
				<div class="row">
					<span id="superioridade-input">
						<div class="col-md-4">
							<div class="form-group">
								<label for="title">Total</label>
								<input type="number" max="90" min="0" step="0.1" class="form-control" name="media_total_estrategia_favorito" value="<?php echo e($robo->media_total_estrategia_favorito); ?>" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="title">A favor</label>
								<input type="number" max="90" min="0" step="0.1" class="form-control" name="media_favor_estrategia_favorito" value="<?php echo e($robo->media_favor_estrategia_favorito); ?>" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="title">Contra</label>
								<input type="number" max="90" min="0" step="0.1" class="form-control" name="media_contra_estrategia_favorito" value="<?php echo e($robo->media_contra_estrategia_favorito); ?>" required>
							</div>
						</div>
					</span>
				</div>
				<div class="form-group">
					<label for="title">Media miníma de cantos da Zebra na estratégia <?php echo e($robo->nome); ?>?</label>
				</div>
				<div class="row">
					<span id="superioridade-input">
						<div class="col-md-4">
							<div class="form-group">
								<label for="title">Total</label>
								<input type="number" max="90" min="0" step="0.1" class="form-control" name="media_total_estrategia_zebra" value="<?php echo e($robo->media_total_estrategia_zebra); ?>" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="title">A favor</label>
								<input type="number" max="90" min="0" step="0.1" class="form-control" name="media_favor_estrategia_zebra" value="<?php echo e($robo->media_favor_estrategia_zebra); ?>" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="title">Contra</label>
								<input type="number" max="90" min="0" step="0.1" class="form-control" name="media_contra_estrategia_zebra" value="<?php echo e($robo->media_contra_estrategia_zebra); ?>" required>
							</div>
						</div>
					</span>
				</div>
				</span>
				<div class="form-group">
					<button form="form-robo-edit" type="submit" class="btn btn-success"> Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<script type="text/javascript">
		var intervalo = new rSlider({
                    target: '#intervalo',
                    values: {min: 0, max: 90},
                    step: 1,
                    range: true,
                    set: [<?php echo e($robo->intervalo_inicio); ?>, <?php echo e($robo->intervalo_fim); ?>],
                    scale: true,
                    labels: false,
                    onChange: function (vals) {
                        var valores = vals.split(',');
                       	$("#intervalo_inicio").val(valores[0]);
                       	$("#intervalo_fim").val(valores[1]);
						$("#intervalo-notificacao").html(valores[0]+" - "+valores[1]);
                    }
                });

		var slider2 = new rSlider({
                    target: '#slider2',
                    values: {min: 0, max: 90},
                    step: 1,
                    range: false,
                    set: [<?php echo e($robo->superioridade); ?>],
                    scale: true,
                    labels: false,
                    onChange: function (vals) {
                        $("#superioridade").val(vals);
                    }
                });
		<?php if($robo->situacao == 'jogo-parelho'): ?>
			$('.tem-favorito').hide();
		<?php endif; ?>

		function desativa_campos() {
			$('.tem-favorito').hide();
		}
		function ativa_campos() {
			$('.tem-favorito').show();
		}
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>