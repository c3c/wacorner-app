

<?php $__env->startSection('adminlte_css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/css/auth.css')); ?>">
    <?php echo $__env->yieldContent('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body_class', 'login-page'); ?>

<?php $__env->startSection('body'); ?>
<div class="login-box">
        <div class="login-logo">
            <a href="<?php echo e(url(config('adminlte.dashboard_url', 'home'))); ?>"><?php echo config('adminlte.logo', '<b>Admin</b>LTE'); ?></a>
        </div>
        
    	<div class="login-box-body">
    		<h3 class="box-title">Informe os dados para encontrarmos seu cadastro </h3>
    		<div class="box-body">
    			<?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    			<form method="POST" id="altera-senha"  action="<?php echo e(route('admin.usuario.busca.cadastro')); ?>">
    				
    					<?php echo csrf_field(); ?>
    				<div class="form-group">
    					<label>E-mail</label>
    					<input type="email" name="email" class="form-control">
    				</div>
    				<div class="form-group">
    					<label>Telefone sem DDD</label>
    					<input type="text" name="telefone" maxlength="11" class="form-control">
    				</div>
                    </div>
    				<div class="form-group">
    					<button class="btn btn-success" form="altera-senha" type="submit"> Enviar</button>
    				</div>
    			</form>
    		</div>
    	</div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('adminlte_js'); ?>
    <?php echo $__env->yieldContent('js'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>