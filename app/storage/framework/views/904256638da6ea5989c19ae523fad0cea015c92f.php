<?php $__env->startSection('content_header'); ?>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div id="loader"></div>

<div class="box">
    	<div class="box-header">
    			<h3 class="box-title">Meu Perfil </h1>
    		<div class="box-body">
    			<?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    			<form method="POST" action="<?php echo e(route('usuario.perfil.update')); ?>">
    				<div class="form-group">
    					<label>Nome</label>
    					<?php echo csrf_field(); ?>
    					<input type="text" name="nome" class="form-control" value="<?php echo e(auth()->user()->nome); ?>">
    				</div>
    				<div class="form-group">
    					<label>Sobrenome</label>
    					<input type="text" name="sobrenome" class="form-control" value="<?php echo e(auth()->user()->sobrenome); ?>">
    				</div>
    				<div class="form-group">
    					<label>E-mail</label>
    					<input type="email" name="email" class="form-control" value="<?php echo e(auth()->user()->email); ?>">
    				</div>
    				<div class="form-group">
    					<label>CPF</label>
    					<input type="text" name="cpf" maxlength="11" class="form-control" value="<?php echo e(auth()->user()->cpf); ?>">
    				</div>
    				<div class="form-group">
    					<label>DDD</label>
    					<input type="text" name="codigo_area" maxlength="3" class="form-control" value="<?php echo e(auth()->user()->codigo_area); ?>">
    				</div>
    				<div class="form-group">
    					<label>Telefone</label>
    					<input type="text" name="telefone" maxlength="11" class="form-control" value="<?php echo e(auth()->user()->telefone); ?>">
    				</div>
                    <div class="form-group">
                        <label>Fuso Horário (Time zone)</label>
                        <select class="form-control" name="zona">
                            <?php if(auth()->user()->zona !=null): ?>
                                <option value="<?php echo e(auth()->user()->zona); ?>">Zona Atual: <?php echo e(auth()->user()->zona); ?></option>
                            <?php endif; ?>
                            <?php $__currentLoopData = auth()->user()->zonas(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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