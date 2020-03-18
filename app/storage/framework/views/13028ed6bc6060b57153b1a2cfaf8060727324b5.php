



<?php $__env->startSection('content_header'); ?>
    <a href="<?php echo e(route('admin.home')); ?>" class="btn btn-primary"><i class="fa fa-reply" aria-hidden="true"></i> Jogos de Hoje</a>
  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="box">
	<div class="box-header">
		<div class="row">
		<div class="col-md-3">
				<h3 class="box-title">Jogos de Amanhã</h1>
			</div>
	   </div>
	</div>
	<div class="box-body">
		<?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>	               	
       	<tabela-principal url_gestao="<?php echo e(route('gestao.estrategias')); ?>" url_jogo="<?php echo e(route('admin.jogo',['id' =>''])); ?>" url="<?php echo e(route('admin.jogos.data',['data' => date('Y-m-d', strtotime('+1 days'))])); ?>" url_lista="<?php echo e(route('listas')); ?>" zona="<?php echo e(auth()->user()->zona); ?>"></tabela-principal>
       	
       	<modal  nome="adicionar-lista" titulo="Adicionar na lista">
        	<form-lista id='form-add-lista' token="<?php echo e(csrf_token()); ?>" url_lista="<?php echo e(route('listas')); ?>"></form-lista>
	        <span slot="botoes">
	            <button form="form-add-lista" class="btn btn-info">Adicionar</button>
	        </span>
    	</modal> 

    	<modal  nome="adicionar-gestao" titulo="⛳️ Adicionar a GESTÃO">
    		<form-add-gestao id='form-add-gestao' token="<?php echo e(csrf_token()); ?>" url_gestao="<?php echo e(route('gestao')); ?>" entrada="<?php echo e(auth()->user()->gestao->stake); ?>"></form-add-gestao>
    	    <span slot="botoes">
    	        <button form="form-add-gestao" class="btn btn-info">Adicionar</button>
    	    </span>
    	</modal>
  	</div>
</div>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>