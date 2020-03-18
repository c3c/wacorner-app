



<?php $__env->startSection('content_header'); ?>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div id="loader"></div>

<div class="box">
    	<div class="box-header">
				<?php if(auth()->user()->admin != 1): ?>
    				<h3 class="box-title">Meu Perfil </h1>
				<?php else: ?>
					<h3 class="box-title">Perfil </h1>
				<?php endif; ?>
    		<div class="box-body">
    			<?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    			<form method="POST" action="<?php echo e(route('usuario.perfil.update')); ?>">
					<input type="hidden" name="id" value="<?php echo e($usuario->id); ?>">
    				<div class="form-group">
    					<label>Nome</label>
    					<?php echo csrf_field(); ?>
    					<input type="text" name="nome" class="form-control" value="<?php echo e($usuario->nome); ?>">
    				</div>
    				<div class="form-group">
    					<label>Sobrenome</label>
    					<input type="text" name="sobrenome" class="form-control" value="<?php echo e($usuario->sobrenome); ?>">
    				</div>
    				<div class="form-group">
    					<label>E-mail</label>
    					<input type="email" name="email" class="form-control" value="<?php echo e($usuario->email); ?>">
    				</div>
    				<div class="form-group">
    					<label>CPF</label>
    					<input type="text" name="cpf" maxlength="11" class="form-control" value="<?php echo e($usuario->cpf); ?>">
    				</div>
    				<div class="form-group">
    					<label>DDD</label>
    					<input type="text" name="codigo_area" maxlength="3" class="form-control" value="<?php echo e($usuario->codigo_area); ?>">
    				</div>
    				<div class="form-group">
    					<label>Telefone</label>
    					<input type="text" name="telefone" maxlength="11" class="form-control" value="<?php echo e($usuario->telefone); ?>">
    				</div>
                    <div class="form-group">
                        <label>Fuso Horário (Time zone)</label>
                        <select class="form-control" name="zona">
                            <?php if($usuario->zona !=null): ?>
                                <option value="<?php echo e($usuario->zona); ?>">Zona Atual: <?php echo e($usuario->zona); ?></option>
                            <?php endif; ?>
                            <?php $__currentLoopData = $usuario->zonas(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e(explode('|',$zona)[0]); ?>"><?php echo e(explode('|',$zona)[0]); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
    				<div class="form-group">
    					<label>Senha</label>
    					<input type="password" name="password" class="form-control">
    				</div>
    				<div class="form-group">
    					<button class="btn btn-success" type="submit"> Atualizar</button>
    				</div>
    			</form>
    		</div>
    	</div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>