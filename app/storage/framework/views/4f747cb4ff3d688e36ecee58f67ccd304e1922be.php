<?php $__env->startSection('content_header'); ?>
    <a href="<?php echo e(route('admin.amanha')); ?>" class="btn btn-primary"><i class="fa fa-share" aria-hidden="true"></i> Jogos de amanhã</a>
    

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="box">
	<div class="box-header">
		<div class="row">
		<div class="col-md-3">
				<h3 class="box-title">Jogos de Hoje</h1>
			</div>
	   </div>
	</div>
	<div class="box-body">
    <?php if($dias_para_expirar > 0): ?>
      <div class="alert alert-warning">
        <p><span class="fa fa-warning"></span> Renove seu plano, falta(m) <b><?php echo e($dias_para_expirar); ?> DIA(s)</b> para acabar seu acesso ao sistema.</p>
      </div>
    <?php elseif($dias_para_expirar == 0): ?>
      <div class="alert alert-warning">
        <p><span class="fa fa-warning"></span> Vixe😱, você só tem até HOJE para acessar nosso sitema, compre mais dias para continuar utilizando.</p>
      </div>
    <?php endif; ?>
		<?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>	               	
       	<tabela-principal url_gestao="<?php echo e(route('gestao.estrategias')); ?>" url_jogo="<?php echo e(route('admin.jogo',['id' =>''])); ?>" url="<?php echo e(route('admin.jogos.data',['data' => date('Y-m-d')])); ?>" url_lista="<?php echo e(route('listas')); ?>" zona="<?php echo e(auth()->user()->zona); ?>"></tabela-principal>
       	
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