<?php $__env->startSection('content'); ?>

<div class="box">
	<div class="box-header">
		<div class="row">
		<div class="col-md-5">
			<h3 class="box-title"><i class="fa fa-money"></i> Apostas Resolvidas </h1>
				<a href="<?php echo e(route('gestao')); ?>" class="btn btn-warning btn-xs"><i class="fa fa-reply"></i> Voltar a Gestão</a>
				<a href="<?php echo e(route('gestao.entradas.excluir.tudo')); ?>" class="btn btn-danger btn-xs"><i class="fa fa-navicon"></i> Excluir tudo</a>
	   </div>
	</div>
	<div class="box-body">
		<?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>	               	
    <section class="content">
    	<table class="table table-striped">
    		<thead>
    			<tr>
    				<th>Data</th>
    				<th>Liga</th>
    				<th>Jogo</th>
    			<?php if(auth()->user()->admin == 1): ?>	<th>Over 9</th> <?php endif; ?>
    				<th>Stake</th>
    				<th>Odd</th>
    				<th>Estratégia</th>
    				<th>Resultado</th>
    				<th>Excluir</th>
    			</tr>
    		</thead>
    		<tbody>
    			<?php $__empty_1 = true; $__currentLoopData = $entradas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
	    			<tr>
	    				<td><?php echo e(date('d/m/Y',strtotime($entrada->jogo->start))); ?></td>
	    				<td><?php echo e($entrada->jogo->liga->l); ?></td>
	    				<td><a style="color: #00b300" target="_blank" href="<?php echo e(route('admin.jogo',['id'=>$entrada->jogo->id])); ?>">  <?php echo e($entrada->jogo->time_casa->nome); ?> x <?php echo e($entrada->jogo->time_fora->nome); ?> </i></a></td>
	    				<?php if(auth()->user()->admin == 1): ?>	<td><?php echo e($entrada->jogo->over9); ?>%</td> <?php endif; ?>
						<td>R$ <?php echo e($entrada->stake); ?></td>
	    				<td><?php echo e($entrada->odd); ?></td>
	    				<td><?php echo e($entrada->estrategia->nome); ?></td>
	    				<?php if($entrada->resultado == 'green'): ?>
	    					<td><span class="badge bg-green"><i class="fa fa-check"></i> <?php echo e($entrada->resultado); ?></span></td>
	    				<?php elseif($entrada->resultado == 'neutro'): ?>
	    					<td><span class="badge bg-blue"><i class="fa fa-circle"></i> <?php echo e($entrada->resultado); ?></span></td>
	    				<?php else: ?>
	    					<td><span class="badge bg-red"><i class="fa fa-close"></i> <?php echo e($entrada->resultado); ?></span></td>
	    				<?php endif; ?>
	    				<td><a href="<?php echo e(route('gestao.entradas.excluir',[ 'id' => $entrada->id])); ?>"  class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button></td>
	    			</tr>
    			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    				<tr><td colspan="7">Sem entradas</td></tr>
    			<?php endif; ?>
    		</tbody>
    	</table>

    	<?php echo e($entradas->links()); ?>

    </section>
  </div>
</div>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>