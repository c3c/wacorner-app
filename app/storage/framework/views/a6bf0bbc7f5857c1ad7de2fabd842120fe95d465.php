

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
    		<h3 class="box-title">Informe uma nova senha </h3>
    		<div class="box-body">
    			<?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    			<form method="POST" id="altera-senha"  action="<?php echo e(route('admin.usuario.nova.senha')); ?>">
    				<input type="hidden" name="id" value="<?php echo e($usuario->id); ?>">
    					<?php echo csrf_field(); ?>
    				<div class="form-group">
    					<label>Nova senha</label>
    					<input type="password" name="password" class="form-control">
    				</div>
                    
    				<div class="form-group">
    					<button class="btn btn-success" form="altera-senha" type="submit"> Salvar</button>
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