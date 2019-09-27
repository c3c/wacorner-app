<?php $__env->startSection('css'); ?>
<style>

@keyframes  flash {
	0% {
		background: #0059b3;
	}

	50% {
		background: #1a8cff;
	}

	100% {
		background: #0059b3;
	}
}

.flash{
	animation-name: flash;
	animation-duration: 1.5s;
	animation-iteration-count: infinite;
}

.slidecontainer {
  width: 100%;
}

.slider {
  -webkit-appearance: none;
  width: 100%;
  height: 25px;
  background: #d3d3d3;
  outline: none;
  opacity: 0.7;
  -webkit-transition: .2s;
  transition: opacity .2s;
}

.slider:hover {
  opacity: 1;
}

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 25px;
  height: 25px;
  background: #4CAF50;
  cursor: pointer;
}

.slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  background: #4CAF50;
  cursor: pointer;
}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content_header'); ?>
	
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="box">
	<div class="alert"><button class="btn btn-xs btn-info">S</button> Super Favorito <button class="btn btn-xs btn-info">F</button> Favorito <button class="btn btn-xs btn-success">%</button> Superioridade </div>
	<tabela-ao-vivo url_assets="<?php echo e(asset('assets/images')); ?>" admin="<?php echo e(auth()->user()->admin); ?>" url_gestao="<?php echo e(route('gestao.estrategias')); ?>"></tabela-ao-vivo>

	<modal  nome="adicionar-gestao" titulo="⛳️ Adicionar a GESTÃO">
	<form-add-gestao id='form-add-gestao' token="<?php echo e(csrf_token()); ?>" url_gestao="<?php echo e(route('gestao')); ?>" entrada="<?php echo e(auth()->user()->gestao->stake); ?>"></form-add-gestao>
    <span slot="botoes">
        <button form="form-add-gestao" class="btn btn-info">Adicionar</button>
    </span>
</modal>
</div>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<!-- <script type="text/javascript">
		
		function atualiza(){
			seleciona_estrategia();

			setTimeout(function(){ atualiza();}, 30000);
		}

		atualiza();

		function seleciona_estrategia(){				
				busca_jogos(document.getElementById("estrategia").value,document.getElementById("n_jogos").value , document.getElementById("myRange").value);
		}
		
		function busca_jogos(estrategia,n_jogos,porcentagem){
			
				$.ajax({
					url:"<?php echo e(route('admin.live.search')); ?>",
					method:'GET',
					data:{estrategia: estrategia,porcentagem:porcentagem, n_jogos:n_jogos},
					dataType:'json',
					success:function(data)
					{
						
						if(data.table_data !='')
						{
							$('tbody').html(data.table_data);
						}else{
							$('tbody').html('<tr style="height: 40px;"><td colspan="11">Sem jogos</td></tr>');
						}
					}
				});
		}

		var slider = document.getElementById("myRange");
		var output = document.getElementById("demo");
		output.innerHTML = slider.value;

		slider.oninput = function() {
		  output.innerHTML = this.value;
		  busca_jogos(document.getElementById("estrategia").value,document.getElementById("n_jogos").value , this.value);
		}

	</script> -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>