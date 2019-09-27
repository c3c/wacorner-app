<?php $__env->startSection('content'); ?>

<div class="box">
	<div class="box-header">
		<h1>Jogos Encontrados pelos Robôs</h1>
		<a href="<?php echo e(route('robos.notificacoes.delete.all')); ?>" class="btn btn-danger">Excluir Todas</a>
	</div>
	<div class="box-body">
		<?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<table class="table">
			<thead>
				<tr>
					<th>Data</th>
					<th>Jogo</th>
					<th>Liga</th>
					<th>Robo</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php $__currentLoopData = $notificacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notificacao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td><?php echo e($notificacao['data']); ?></td>					
						<td><?php echo e($notificacao['time_casa']); ?> x <?php echo e($notificacao['time_fora']); ?></td>					
						<td><?php echo e($notificacao['liga']); ?></td>
						<td><?php echo e($notificacao['robo']->nome); ?></td>
						<td>
							<a href="<?php echo e(route('admin.jogo',['id' => $notificacao['jogo_id']])); ?>" class="btn btn-primary">Ver Jogo</a>
							<a href="<?php echo e(route('robos.notificacoes.delete.id',['id' => $notificacao['notificacao_id']])); ?>" class="btn btn-danger">Excluir</a>
						</td>		
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</tbody>
		</table>
	</div>
</div>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<script type="text/javascript">

		
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>