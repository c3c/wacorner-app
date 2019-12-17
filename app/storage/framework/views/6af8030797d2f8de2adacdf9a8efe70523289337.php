

<?php $__env->startSection('content'); ?>

<div class="box">
	<div class="box-header">
		<h3 class="box-title">RELATÓRIO DE SAQUES</h1>
    <div class="alert alert-info">
      <h4>Regras Básicas para Sacar um Valor:</h4>
      <ul>
        <li>Você deve ter no minímo R$100,00 para poder sacar.</li>
        <li>Só pagamos através de PicPay, caso não tenha uma conta crie clicando no nosso link a seguir: <a href="http://www.picpay.com/convite?@P9246G" class="btn btn-success">CRIAR CONTA NO PICPAY</a></li>
      </ul>
    </div>
	</div>
	<div class="box-body">
		<?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>    			
		<h4>Total pago: <span class="badge bg-green">R$ <?php echo e($total); ?></span> | Meu Saldo Agora: <span class="badge bg-blue">R$ <?php echo e($user->saldo); ?></span></h4>
		<?php if($user->saldo >= 100 ): ?>
		  <!-- Button trigger modal -->
			<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal"> <i class="fa fa-usd"></i> Novo Saque
			</button>

		<?php endif; ?>
		<table class="table table-striped">
            <tbody>
            	<tr>
                  	<th>Data</th>
                  	<th>Valor</th>
                  	<th>Status</th>
                    <th>OBS</th>
                </tr>
                <?php $__currentLoopData = $saques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $saque): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                <tr>
	                  	<td><?php echo e($saque->created_at); ?></td>
	                  	<td><?php echo e($saque->valor); ?></td>
	                  	<td><?php echo e($saque->status); ?></td>
                      <td><?php echo e($saque->obs); ?></td>
	                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
      	</table>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Novo Saque</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form id="form-saque" action="<?php echo e(route('saque.store')); ?>" method="POST">
        	<?php echo csrf_field(); ?>
        	<input type="hidden" name="user_id" value="<?php echo e($user->id); ?>">
        	<div class="form-group">
        		<label for="title"> Valor (Obrigatório)</label>
        		<input type="number" name="valor" step="0.01" max="<?php echo e($user->saldo); ?>" min="100" class="form-control" required>
        	</div>        	
        	<div class="form-group">
        		<label for="title"> Seu Usuário no PICPAY (Ex: @wacorner)(Obrigatório)</label>
        		<input name="obs" class="form-control" required> 
        	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button form="form-saque" type="submit" class="btn btn-primary">Salvar</button>
        </form>	
      </div>

    </div>
  </div>
</div>



    

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>