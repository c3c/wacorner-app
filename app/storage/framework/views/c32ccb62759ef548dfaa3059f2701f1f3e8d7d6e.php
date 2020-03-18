


<?php $__env->startSection('content_header'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="box">
    	<div class="box-header">
    		<div class="col-md-3">
	   			<h3 class="box-title">Afiliados - Valor: R$<?php echo e($total); ?></h1>
	   		</div>
	   		<div class="col-md-offset-3 col-md-6">

		   		<!-- <form action="<?php echo e(route('usuario.search')); ?>" class="form form-inline" method="POST">
		   			<?php echo csrf_field(); ?>
		   			<input type="text" name="email" class="form-control" placeholder="E-mail">
		   			<input type="text" name="cpf" class="form-control" placeholder="CPF">
		   			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
		   		</form> -->
		   	</div>
		</div>
    			
    		<div class="box-body">
    			<?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    			<div class="table-responsive">
    			<table class="table table-striped">
	                <tbody>
	                	<tr>

		                 	<th>#</th>
		                  	<th>E-mail</th>
		                  	<th>Nome</th>
		                  	<th>Nº Indicados</th>
		                  	<th>Saldo</th>
		                  	<th>Ações</th>
		                  	
		         
		                </tr>
		                <?php $__currentLoopData = $afiliados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $afiliado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                	
			                <tr>
			                  	<td><?php echo e($afiliado->id); ?></td>
			                  	<td><?php echo e($afiliado->email); ?></td>
			                  	<td><?php echo e($afiliado->nome); ?></td>
			                  	<td><?php echo e($afiliado->users()->count()); ?></td>
			                  	<td>R$ <?php echo e($afiliado->saldo); ?></td>
			                  	<td><a href="<?php echo e(route('indicados.show',['id' => $afiliado->id])); ?>" class="btn btn-success"><i class="fa fa-users" aria-hidden="true"></i> Indicados</a></td>
			                </tr>
			            	
		                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	              </tbody>
	          	</table>
	          	</div>	
	          	<?php echo e($afiliados->links()); ?>					
    		</div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>