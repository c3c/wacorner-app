<?php $__env->startSection('content_header'); ?>
	
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div id="loader"></div>

<div class="box">
   	<div class="box-header">
   		<div class="col-md-3">
   			<h3 class="box-title">Cupons</h1>
   		</div>
   		<div class="col-md-offset-7 col-md-2">
   			<!-- Button trigger modal -->
   			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
   			  Novo cupom
   			</button>
   			
	   	</div>
   	</div>

	<div class="box-body">
		<?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<table class="table table-striped">
	        <tbody>
	        	<tr>
	             	<th>#</th>
	             	<th>Codigo</th>
	               	<th>Tipo</th>
                  <th>Dias</th>
	               	<th><i class="fa fa-user"></i></th>
                  <th>Fim do Cupom</th>
                  <th>Usuario_REF</th>
                  <th>Parceiro</th>
                  <?php if(auth()->user()->admin == 1): ?>
	               	 <th>Desconto</th>
                   <th>Ações</th>
                  <?php else: ?>
                    <th>Ações</th>
                  <?php endif; ?>

	     
	            </tr>
	            <?php $__empty_1 = true; $__currentLoopData = $cupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
	                <tr>
	                  	<td><?php echo e($cupon->id); ?></td>
	                  	<td><?php echo e($cupon->codigo); ?></td>
	         			<td><?php echo e($cupon->tipo); ?></td>
                <td><?php echo e($cupon->dias); ?></td>
	         			<td>
                    <?php echo e($cupon->users->count()); ?>

                </td>
                <td><?php echo e($cupon->fim); ?></td>
                <td><?php echo e(isset($cupon->user->nome)? $cupon->user->nome: ''); ?></td>
                <td><?php echo e(isset($cupon->user_parceiro()->nome)? $cupon->user_parceiro()->nome: ''); ?></td>
                <?php if(auth()->user()->admin == 1): ?>
	         			  <td><?php echo e($cupon->desconto); ?>%</td>
                  <td>
  							   
  	         			<a class="btn btn-danger btn-xs" href="<?php echo e(route('cupon.delete',['id'=>$cupon->id])); ?>" onclick="return confirm('Tem certeza disso?');"><i class="glyphicon glyphicon-remove"></i> Excluir</a>
  	         			<?php if($cupon->users->count()!= 0): ?>
  	         				<a class="btn btn-danger btn-xs" href="<?php echo e(route('cupon.delete.users',['id'=>$cupon->id])); ?>" onclick="return confirm('Tem certeza disso?');"><i class="glyphicon glyphicon-remove"></i> Excluir Usuários</a>
  	         			<?php endif; ?>
                  <a class="btn btn-info btn-xs" href="<?php echo e(route('cupon.relatorio',['id'=>$cupon->id])); ?>"><i class="glyphicon glyphicon-eye-open"></i> Relatório</a>
                  <a class="btn btn-success btn-xs" href="<?php echo e(route('saque.index',['user_id'=>$cupon->user->id])); ?>"><i class="glyphicon glyphicon-usd"></i> Saques</a>
  	         			</td>
                <?php else: ?>
                  <td>
                    <?php if(auth()->user()->cupon->count()>0 && auth()->user()->id == $cupon->user->id && $cupon->remunerado != null && $cupon->remunerado == 1 || auth()->user()->admin == 1 ): ?>
                    <a class="btn btn-info btn-xs" href="<?php echo e(route('cupon.relatorio',['id'=>$cupon->id])); ?>"><i class="glyphicon glyphicon-eye-open"></i> Relatório</a>
                    <a class="btn btn-success btn-xs" href="<?php echo e(route('saque.index',['user_id'=>$cupon->user->id])); ?>"><i class="glyphicon glyphicon-usd"></i> Saques</a>
                    <?php endif; ?>
                  </td>
                <?php endif; ?>

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
        <h5 class="modal-title" id="exampleModalLabel">Novo Cupom</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="cupon-add" action="<?php echo e(route('cupon.store')); ?>" method="POST">
        	<?php echo csrf_field(); ?>
        	<div class="form-group">
        		<label for="title"> Codigo</label>
        		<input type="text" name="codigo" class="form-control" required>
        	</div>
        	<div class="form-group">
        		<label for="title"> Tipo</label>
        		<select name="tipo" class="form-control" required>
        			<option value="">Selecione o Tipo</option>
        			<option value="desconto">Desconto</option>
        			<option value="promocional">Promocional</option>
        		</select>
        	</div>
        	<div class="form-group">
        		<label for="title"> Desconto(%)</label>
        		<input type="text" name="desconto" class="form-control">
        	</div>
        	<div class="form-group">
        		<label for="title"> Dias</label>
        		<input type="text" name="dias" class="form-control">
        	</div>
        	<div class="form-group">
        		<label for="title"> Fim do cupom</label>
        		<input type="date" name="fim" class="form-control" required>
        	</div>
          <div class="form-group">
            <label for="title"> Usuário de referencia (ID):</label>
            <input type="text" name="user_id" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="title"> Parceiro (ID):</label>
            <input type="text" name="parceiro_id" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="title"> Remunerado:</label>
            <select name="remunerado">
              <option value="">-</option>
              <option value="1">Sim</option>
              <option value="2">Não</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" form="cupon-add" class="btn btn-primary">Salvar</button>
        </form>	
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>