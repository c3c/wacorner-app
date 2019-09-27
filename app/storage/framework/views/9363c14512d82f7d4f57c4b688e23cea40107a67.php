<?php $__env->startSection('content_header'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="box">
    	<div class="box-header">
    		<div class="col-md-3">
	   			<h3 class="box-title">Usuarios cadastrados - <?php echo e($total-3); ?></h1>
	   		</div>
	   		<div class="col-md-offset-3 col-md-6">

		   		<form action="<?php echo e(route('usuario.search')); ?>" class="form form-inline" method="POST">
		   			<?php echo csrf_field(); ?>
		   			<input type="text" name="email" class="form-control" placeholder="E-mail">
		   			<input type="text" name="cpf" class="form-control" placeholder="CPF">
		   			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
		   		</form>
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
		                  	<th>Data_Expiração</th>
		                  	<th>Data</th>
		                  	<th>Hora</th>
		                  	<th>Ações</th>
		         
		                </tr>
		                <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                	
			                <tr>
			                  	<td><?php echo e($usuario->id); ?></td>
			                  	<td><?php echo e($usuario->email); ?></td>
			                  	<td><?php echo e(date('d/m/Y',strtotime($usuario->data_expiracao))); ?></td>
			                  	<td><?php echo e(date('d/m/Y',strtotime($usuario->created_at))); ?></td>
			                  	<td><?php echo e(date('H:i',strtotime($usuario->created_at))); ?></td>
			                  	<td>
			                  		<modal-link tipo="button" nome="add-dias" titulo="Add Dias" css="btn btn-success btn-xs" dado_id="<?php echo e($usuario->id); ?>"></modal-link>
			                  		<a href="<?php echo e(route('venda.show.user',['id'=>$usuario->id])); ?>" class="btn btn-info btn-xs">Vendas</a>
			                  		<!-- <a href="<?php echo e(route('usuario.plano',['email' => $usuario->email, 'plano' => 'basico'])); ?>" onclick="return confirm('Tem certeza que deseja adicionar um plano?')" class="btn btn-success btn-xs">Add Basico</a> -->
			                  		<a href="<?php echo e(route('usuario.plano',['email' => $usuario->email, 'plano' => 'profissional'])); ?>" onclick="return confirm('Tem certeza que deseja adicionar um plano?')" class="btn btn-success btn-xs">Add Profissional</a>
			                  	</td>
			                  	
			                </tr>
			            
		                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	              </tbody>
	          	</table>
	          	</div>	
				<?php if(isset($data)): ?>
	          		<?php echo e($usuarios->appends($data)->links()); ?>

				<?php else: ?>
					<?php echo e($usuarios->links()); ?>

				<?php endif; ?>					
    		</div>
    </div>
    

    <modal  nome="add-dias" titulo="Adicionar dias na data de expiração">
    	<form-add-dias id='form-add-dias' token="<?php echo e(csrf_token()); ?>" url="<?php echo e(route('usuario.add.dias')); ?>"></form-add-dias>
        <span slot="botoes">
            <button form="form-add-dias" class="btn btn-info">Adicionar</button>
        </span>
	</modal> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>