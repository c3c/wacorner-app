<?php $__env->startSection('content_header'); ?>


	<?php if($data == date('Y-m-d')): ?>
		<a href="<?php echo e(route('admin.estatistica', ['estatistica'=>$estatistica,'data' => date('Y-m-d', strtotime('+1 days'))])); ?>" class="btn btn-primary"><i class="fa fa-share" aria-hidden="true"></i> Jogos de amanhã</a>
	<?php else: ?>
		<a href="<?php echo e(route('admin.estatistica', ['estatistica'=>$estatistica,'data' => date('Y-m-d')])); ?>" class="btn btn-primary"><i class="fa fa-share" aria-hidden="true"></i> Jogos de hoje</a>
	<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="box">
    
	<tabela-estatisticas admin="<?php echo e(auth()->user()->admin); ?>" url_jogo="<?php echo e(route('admin.jogo',['id' =>''])); ?>" estatistica="<?php echo e($estatistica); ?>" url="<?php echo e(route('admin.jogos.estatistica',['estatistica'=>$estatistica,'data' => $data])); ?>" url_lista="<?php echo e(route('listas')); ?>" zona="<?php echo e(auth()->user()->zona); ?>" url_gestao="<?php echo e(route('gestao.estrategias')); ?>"></tabela-estatisticas>

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
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>