<?php $__env->startSection('js_header'); ?>

  <?php if(auth()->check()): ?>
      <?php if(auth()->user()->user_id != null): ?>
        <script>
          fbq('track', 'Purchase', {
            value: 3,
          });
        </script>
      <?php endif; ?>
  <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_header'); ?>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="box">
    	<div class="box-header">
    			<h3 class="box-title"></h1>
    		<div class="box-body">
    			<div class="row">
                    <div class="col-md-12">

                          <h1>Obrigado por adquirir um plano!</h1>

                          <?php if($tipo_pagamento == 'PayPal' || $tipo_pagamento == 'cartão'): ?>
                            <div class="alert alert-success" role="alert">
                                <p>No maximo em 30 minutos será liberado seu plano. Caso contrario entre em contato.</p>
                            </div>
                          <?php elseif($tipo_pagamento == 'PicPay'): ?>
                            <div class="alert alert-success" role="alert">
                                <a href="<?php echo e($link); ?>" target="_blank" class="btn btn-warning" style="text-decoration:none"> <i class="fa fa-money"></i> Clique aqui para pagar seu plano no PICPAY</a>
                                <hr>
                            <p>No maximo em 30 minutos será liberado seu plano. Caso contrario entre em contato!</p>
                            </div>
                          <?php else: ?>
                            <div class="alert alert-success" role="alert">
                                <a href="<?php echo e($link); ?>" target="_blank" class="btn btn-warning" style="text-decoration:none"> <i class="fa fa-money"></i> Clique aqui para acessar seu boleto</a>
                                <hr>
                            <p>A confirmação de pagamento pode levar até 3 dias úteis. Por favor, esperar a liberação de forma automática!</p>
                            </div>
                          <?php endif; ?>


                    </div>
                </div>

    		</div>
    	</div>
    </div>





<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>