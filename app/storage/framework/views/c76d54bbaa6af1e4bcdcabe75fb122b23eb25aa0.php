<?php $__env->startSection('content_header'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div id="loader"></div>

<div class="box">
   	<div class="box-header">
   		<div class="col-md-3">
   			<h3 class="box-title">Ligas</h1>
   		</div>
   		<div class="col-md-offset-6 col-md-3">

	   		<form action="<?php echo e(route('liga.search')); ?>" class="form form-inline" method="POST">
	   			<?php echo csrf_field(); ?>
	   			<input type="text" name="l" class="form-control" placeholder="Nome da liga">
	   			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
	   		</form>
	   	</div>
   	</div>

	<div class="box-body">
		<?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<table class="table table-striped">
	        <tbody>
	        	<tr>
	             	<th>#</th>
	             	<th>Nome</th>
	               	<th>API ID</th>
	               	<th>Ativa?</th>
	     
	            </tr>
	            <?php $__currentLoopData = $ligas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $liga): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                <tr>
	                  	<td><?php echo e($liga->id); ?></td>
	                  	<td><?php echo e($liga->l); ?></td>
	         			<td><?php echo e($liga->l_id); ?></td>
	         			<td>
							<?php if($liga->ativo == 1): ?>
	         					<a href="<?php echo e(route('liga.ativar',['id' => $liga->id])); ?>" class="btn btn-xs btn-success"><span class="fa fa-check"></span></a>
	         				<?php else: ?>
	         					<a href="<?php echo e(route('liga.ativar',['id' => $liga->id])); ?>" class="btn btn-xs btn-danger"><span class="fa fa-close"></span></a>		         							
	         				<?php endif; ?> 
	         			</td>
	         			
	                </tr>
	            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	      	</tbody>
  		</table>	
  		<?php if(isset($data)): ?>
  			<?php echo e($ligas->appends($data)->links()); ?>

  		<?php else: ?>
  			<?php echo e($ligas->links()); ?>

  		<?php endif; ?>				
	</div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>