


<?php $__env->startSection('content_header'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="box">
    	<div class="box-header">
    		<div class="col-md-3">
	   			<h3 class="box-title"><i class="fa fa-users"></i> Meus Indicados</h1>
	   		</div>
	   		<div class="col-md-offset-5 col-md-4">

		   		<a class="btn btn-warning" href="<?php echo e(route('saque.index',['user_id'=>$afiliado->id])); ?>"><i class="glyphicon glyphicon-usd"></i> Meus Saques</a>
		   		<a class="btn btn-success" href="<?php echo e(route('indicados.converter.dias',['id'=>$afiliado->id])); ?>"><i class="glyphicon glyphicon-usd"></i> Converter saldo em dias</a>
		   	</div>
		</div>
    			
    		<div class="box-body">
			<?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    			<div class="row">
				        <div class="col-md-3 col-sm-6 col-xs-12">
				          <div class="info-box">
				            <span class="info-box-icon bg-green"><i class="fa fa-usd"></i></span>

				            <div class="info-box-content">
				              <span class="info-box-text">Meu Saldo</span>
				              <span class="info-box-number"> R$<?php echo e($afiliado->saldo); ?></span>
				            </div>
				            <!-- /.info-box-content -->
				          </div>
				          <!-- /.info-box -->
				        </div>
				        <!-- /.col -->
				        <div class="col-md-3 col-sm-6 col-xs-12">
				          <div class="info-box">
				            <span class="info-box-icon bg-blue"><i class="fa fa-users"></i></span>

				            <div class="info-box-content">
				              <span class="info-box-text">Total</span>
				              <span class="info-box-number"><?php echo e($total); ?><small> indicados</small></span>
				            </div>
				            <!-- /.info-box-content -->
				          </div>
				          <!-- /.info-box -->
				        </div>
				        <!-- /.col -->
				      </div>
    			<div class="alert alert-success">
    				<p><span class="fa fa-link"></span> <b>Seu Link de Divulgação:</b> https://wacorner.com/afi/<?php echo e($afiliado->id); ?></p>
    				<p><span class="fa fa-hand-pointer-o"></span> <b>Regra de comissionamento*:</b> último clique</p>
    				<br>
    				<p>*Utilizamos cookies para salvar sua indicação, então caso o usuario não se cadastre agora, mas no seu navegador será salvo seu id, e caso ele se cadastre você ganhará o indicado, mas caso ele se cadastre com outro link de afiliado, esse id é atualizado, ele só não atualiza caso o usario acesse diretamente o site sem ser por link de algum outro afiliado. Para mais informações, manda um email para wacornerstats@gmail.com</p>
    			</div>
    			
    			<div class="table-responsive">
    			<table class="table table-striped">
	                <tbody>
	                	<tr>

		                 	<th>#</th>
		                  	<th>E-mail</th>
		                  	<th>Nome</th>
		                  	<th>Compras do Mês</th>
		                  	<th>Data</th>
		                  	
		         
		                </tr>
		                <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                	
			                <tr>
			                  	<td><?php echo e($usuario->id); ?></td>
			                  	<td><?php echo e($usuario->email); ?></td>
			                  	<td><?php echo e($usuario->nome); ?></td>
			                  	<td><?php echo e($usuario->vendasMes()->count()); ?></td>
			                  	<td><?php echo e(date('d/m/Y',strtotime($usuario->created_at))); ?></td>
			                </tr>
			            
		                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	              </tbody>
	          	</table>
	          	</div>	
	          	<?php echo e($usuarios->links()); ?>					
    		</div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>