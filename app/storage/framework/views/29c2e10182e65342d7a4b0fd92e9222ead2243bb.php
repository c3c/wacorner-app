<?php $__env->startSection('js_header'); ?>

  <?php if(auth()->check()): ?>
      <?php if(auth()->user()->user_id != null): ?>
        <script>
          fbq('track', 'InitiateCheckout');
        </script>
      <?php endif; ?>
  <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_header'); ?>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="box">
    	<div class="box-header">
    			<h3 class="box-title">Adquira um plano  - PicPay</h1>
    		<div class="box-body">
    			<div class="alert alert-info"><?php if(auth()->user()->ativo()): ?>
    				Data de expiração: <?php echo e(date('d/m/Y',strtotime(auth()->user()->data_expiracao))); ?> <?php else: ?> NENHUM PLANO ATIVO <?php endif; ?> </div>

    			<?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="row">
                    <div class="col-md-4">
                        <form action="<?php echo e(route('venda.picpay.purchase')); ?>" method="POST">
                            <label>Valor Plano = R$ 29,99</lable>
                            <br>
                            <label>Cupom</label>
                            <?php echo csrf_field(); ?>
                            <input class="form-control" type="text" name="cupom"/>
                            <br>
                            <input type="hidden" value="29.99" name="valor"/>
                            <input class="btn btn-success" type="submit" value="Comprar">
                        </form>
                    </div>
                </div>

    		</div>
    	</div>
    </div>





<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>