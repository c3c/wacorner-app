<?php if($errors->any()): ?>
	<div class="alert alert-warning">
		<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<p><span class="fa fa-thumbs-o-down"></span> <?php echo e($error); ?></p>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
<?php endif; ?>

<?php if(session('success')): ?>
	<div class="alert alert-success">
			<p><span class="fa fa-thumbs-o-up"></span> <?php echo e(session('success')); ?></p>
	</div>
<?php endif; ?>

<?php if(session('success_link')): ?>
	<div class="alert alert-success">
			<p><span class="fa fa-thumbs-o-up"></span> <a target="_blank" href="<?php echo e(session('success_link')); ?>">Visualizar Boleto</a></p>
	</div>
<?php endif; ?>

<?php if(session('error')): ?>
	<div class="alert alert-danger">
			<p><span class="fa fa-thumbs-o-down"></span> <?php echo e(session('error')); ?></p>
	</div>
<?php endif; ?>

