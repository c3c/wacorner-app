<?php $__env->startSection('content'); ?>

<div class="box">
	<div class="box-header">
		<h1>Meus Robôs</h1>
		<!-- <a href="<?php echo e(route('robos.notificacoes')); ?>" class="btn btn-warning" target="_blank"><i class="fa fa-bell-o"></i> Notificações dos Robôs</a> -->
		<?php if(auth()->user()->telegram_chat_id == null): ?>
		<a href="https://telegram.me/WAcornerBot?start=<?php echo e(auth()->user()->id); ?>" class="btn btn-success" target="_blank"><i class="fa fa-bell-o"></i> Conectar ao Telegram</a>
		<?php else: ?>
		<h5><b>☑️ Conectado ao Telegram </b> <a href="<?php echo e(route('robos.desconectar',['id' => auth()->user()->id])); ?>" class="btn btn-warning" > Desconectar</a></h5>
		<?php endif; ?>
	</div>
	<div class="box-body">
		<?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<table class="table">
			<thead>
				<tr>
					<th>Nome</th>
					<th>Status</th>
					<th>Ativo?</th>
				</tr>
			</thead>
			<tbody>
				<?php if($robos->count() != 0): ?>
					<?php $__currentLoopData = $robos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $robo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($robo->nome); ?></td>					
							<td><?php echo e($robo->status == 0 ? 'Desativado' : 'Ativo'); ?></td>
							<?php if($robo->status == '0'): ?>					
								<td><a href="<?php echo e(route('robos.alterar.status',['id' => $robo->id])); ?>" class="btn btn-primary">Ativar</a></td>		
							<?php else: ?>
								<td>
									<a href="<?php echo e(route('robos.alterar.status',['id' => $robo->id])); ?>" class="btn btn-danger">Desativar</a>
									<a href="<?php echo e(route('robos.edit',['id' => $robo->id])); ?>" class="btn btn-warning">Configurar</a>
								</td>		
							<?php endif; ?>
						</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php else: ?>
					<tr>
						<td>HT1020</td>					
						<td>Desativado</td>					
						<td><a href="<?php echo e(route('robos.create.nome',['nome' => 'HT1020'])); ?>" class="btn btn-primary">Ativar</a></td>	
					</tr>
					<tr>
						<td>HT35</td>					
						<td>Desativado</td>					
						<td><a href="<?php echo e(route('robos.create.nome',['nome' => 'HT35'])); ?>" class="btn btn-primary">Ativar</a></td>	
					</tr>
					<tr>
						<td>HT38</td>					
						<td>Desativado</td>					
						<td><a href="<?php echo e(route('robos.create.nome',['nome' => 'HT38'])); ?>" class="btn btn-primary">Ativar</a></td>	
					</tr>
					<tr>
						<td>FT75</td>					
						<td>Desativado</td>					
						<td><a href="<?php echo e(route('robos.create.nome',['nome' => 'FT75'])); ?>" class="btn btn-primary">Ativar</a></td>	
					</tr>
					<tr>
						<td>FT82</td>					
						<td>Desativado</td>					
						<td><a href="<?php echo e(route('robos.create.nome',['nome' => 'FT82'])); ?>" class="btn btn-primary">Ativar</a></td>	
					</tr>
					<tr>
						<td>FT88</td>					
						<td>Desativado</td>					
						<td><a href="<?php echo e(route('robos.create.nome',['nome' => 'FT88'])); ?>" class="btn btn-primary">Ativar</a></td>	
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
		
	</div>
</div>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>