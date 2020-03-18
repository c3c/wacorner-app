


<?php $__env->startSection('content_header'); ?>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="box">
    	<div class="box-header">
    			<h3 class="box-title">Histórico</h1>
    		<div class="box-body">
    			
    			<div class="alert alert-info"><?php if(auth()->user()->ativo()): ?>
    				Data de expiração: <?php echo e(date('d/m/Y',strtotime(auth()->user()->data_expiracao))); ?> <?php else: ?> NENHUM PLANO ATIVO <?php endif; ?> </div>
    			<?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    			<?php if(auth()->user()->admin == 1): ?>
	    			<div class="row">
				        <div class="col-md-3 col-sm-6 col-xs-12">
				          <div class="info-box">
				            <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>

				            <div class="info-box-content">
				              <span class="info-box-text">Usuários Ativos</span>
				              <span class="info-box-number"><?php echo e($total_usuarios); ?> <small>usuários</small></span>
				            </div>
				            <!-- /.info-box-content -->
				          </div>
				          <!-- /.info-box -->
				        </div>
				        <!-- /.col -->
				        <div class="col-md-3 col-sm-6 col-xs-12">
				          <div class="info-box">
				            <span class="info-box-icon bg-blue"><i class="fa fa-usd"></i></span>

				            <div class="info-box-content">
				              <span class="info-box-text">Total básico Pago</span>
				              <span class="info-box-number"><?php echo e($total_basico); ?> <small>pedidos</small><?php if(auth()->user()->admin == 1): ?><br><?php endif; ?></span>
				            </div>
				            <!-- /.info-box-content -->
				          </div>
				          <!-- /.info-box -->
				        </div>
				        <!-- /.col -->
				        <div class="col-md-3 col-sm-6 col-xs-12">
				          <div class="info-box">
				            <span class="info-box-icon bg-blue"><i class="fa fa-usd"></i></span>

				            <div class="info-box-content">
				              <span class="info-box-text">Total Profissional Pago</span>
				              <span class="info-box-number"><?php echo e($total_profissional); ?> <small>pedidos</small><?php if(auth()->user()->admin == 1): ?><br><?php endif; ?></span>
				            </div>
				            <!-- /.info-box-content -->
				          </div>
				          <!-- /.info-box -->
				        </div>
				        <!-- /.col -->
				        <!-- fix for small devices only -->
				        <div class="clearfix visible-sm-block"></div>

				        <div class="col-md-3 col-sm-6 col-xs-12">
				          <div class="info-box">
				            <span class="info-box-icon bg-yellow"><i class="fa fa-spinner"></i></span>

				            <div class="info-box-content">
				              <span class="info-box-text">Total pendente</span>
				              <span class="info-box-number"><?php echo e($total_pendente); ?> <small>pedidos</small></span>
				            </div>
				            <!-- /.info-box-content -->
				          </div>
				          <!-- /.info-box -->
				        </div>
				        <!-- /.col -->
				      </div>
    			  <?php endif; ?>

    			<?php if(auth()->user()->admin == 1): ?>
    			<hr>
	    			<div class="row">
	    				<div class="col-md-12">
	    					<h3><span class="label label-danger">Pedidos por mês</span></h3>
	    					
	    					<canvas id="porPlano"></canvas>
	    				</div>
	    				
	    			</div>
    			<hr>
    			<h3>Filtrar pedidos</h3>
    			<form class="form-inline" action="<?php echo e(route('venda.show.search')); ?>" method="post">
    				<?php echo csrf_field(); ?>
    				<div class="form-group">
    					<label for="title">Data inicial</label>
    					<input type="date" name="data_inicio" class="form-control">
    				</div>
    				<div class="form-group">
    					<label for="title">Data final</label>
    					<input type="date" name="data_fim" class="form-control">
    				</div>
    				<div class="form-group">
    					<label for="title">Tipo</label>
	    				<select class="form-control" name="tipo_pagamento">
	    					<option value="">-</option>
	    					<option value="Transferência">Transferência</option>
	    					<option value="cartão">Cartão</option>
	    					<option value="boleto">Boleto</option>
	    				</select>
	    			</div>
	    			<div class="form-group">
	    				<button class="btn btn-primary" type="submit"> Buscar</button>
	    			</div>
    			</form>
    			<?php endif; ?>
    			<hr>
    			<table class="table table-striped">
	                <tbody>
	                	<tr>
		                 	<th>#</th>
		                  	<th>Plano</th>
		                  	<th>Valor</th>
		                  	<?php if(auth()->user()->admin == 1): ?>
			                	<th>Usuario</th>
			                <?php endif; ?>
		                  	<th>Tipo</th>
		                  	<th>Status</th>
		                  	<th>Data</th>
		                  	<th>Ações</th>
		                </tr>
		                <?php $__currentLoopData = $vendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			                <tr>
			                  	<td><?php echo e($venda->id); ?></td>
			                  	<td><?php echo e($venda->plano); ?></td>
			                  	<td>R$ <?php echo e($venda->valor != null ? $venda->valor:0); ?></td>
			                  	<?php if(auth()->user()->admin == 1): ?>
			                  		<td><?php echo e($venda->user->email); ?></td>
			                  	<?php endif; ?>
			                  	<td><?php echo e($venda->tipo_pagamento); ?></td>
			                  	<td><span class="badge bg-green"><?php echo e($venda->status); ?></span></td>
			                  	<td><?php echo e($venda->created_at); ?></td>
			                  	<td>
			                  		<?php if($venda->status != 'Paga' && $venda->status != 'Cancelada' || auth()->user()->admin == 1 ): ?>
				                  		<?php if($venda->tipo_pagamento == 'boleto' && $venda->status == 'pendente'): ?>
				                  		<a class="btn btn-info" href="<?php echo e($venda->referencia); ?>" target="_blank"><i class="glyphicon glyphicon-shopping-cart"></i> Pagar</a>
				                  		<?php endif; ?>
				                  		<a class="btn btn-danger" href="<?php echo e(route('venda.delete',['id'=>$venda->id])); ?>" onclick="return confirm('Tem certeza disso?');"><i class="glyphicon glyphicon-remove"></i> Excluir</a>
				                  		<?php if(auth()->user()->admin == 1 && $venda->status == 'pendente'): ?>
				                  			<a class="btn btn-success" href="<?php echo e(route('venda.liberar',['id'=>$venda->id])); ?>" onclick="return confirm('Tem certeza disso?');"><i class="glyphicon glyphicon-plus"></i> Liberar plano</a>
				                  		<?php endif; ?>
				                  	<?php endif; ?>
				                 </td>
			                  
			                </tr>
		                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	              </tbody>
	          	</table>
    			<?php echo e($vendas->links()); ?>   
    			 						
    		</div>
    	</div>
    </div>





<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<script type="text/javascript">
		var ctx = document.getElementById('porPlano').getContext('2d');
		var chart = new Chart(ctx, {
		    // The type of chart we want to create
		    type: 'line',

		    // The data for our dataset
		    data: {
		        labels: [<?php $__currentLoopData = $info_grafico_por_plano['mesAno']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info_lable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> "<?php echo e($info_lable); ?>", <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
		        datasets: [{
		            label: "Profissional Pago",
		            backgroundColor: 'rgb(92, 241, 0,0)',
		            borderColor: 'rgb(92, 241, 0)',
		            data: [<?php $__currentLoopData = $info_grafico_por_plano['mesAno']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $info_lable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
		            		<?php if(isset($info_grafico_por_plano['num_vendas_profissional'][$key])): ?>
		            			"<?php echo e($info_grafico_por_plano['num_vendas_profissional'][$key]); ?>"
		            		<?php else: ?>
		            			""
		            		<?php endif; ?>,
		            	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
		        },
		        {
		            label: "Básico Pago",
		            backgroundColor: 'rgb(251, 230, 0,0)',
		            borderColor: 'rgb(251, 230, 0)',
		            data: [<?php $__currentLoopData = $info_grafico_por_plano['mesAno']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $info_lable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
		            		<?php if(isset($info_grafico_por_plano['num_vendas_basico'][$key])): ?>
		            			"<?php echo e($info_grafico_por_plano['num_vendas_basico'][$key]); ?>"
		            		<?php else: ?>
		            			""
		            		<?php endif; ?>,
		            	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> ],
		        }]
		    },

		    // Configuration options go here
		    options: {
		    	scales: {
		            yAxes: [{
		                ticks: {
		                    beginAtZero:true
		                }
		            }]
		        }
		    }
		});
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>