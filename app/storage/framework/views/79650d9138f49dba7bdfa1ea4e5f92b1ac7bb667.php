<?php $__env->startSection('js_header'); ?>

  <?php if(auth()->check()): ?>
      <?php if(auth()->user()->user_id != null): ?>
        <script>
          fbq('track', 'InitiateCheckout');
        </script>
      <?php endif; ?>
  <?php endif; ?>

  <script src="https://www.paypal.com/sdk/js?client-id=AXmIWrmocDUD9Oe1XOlrTSn0opLDlusCxCir28M8j5BgH6MEOHHa2nXix3qXYsYUSQw5ggSpwBjU8Pwg"></script>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div id="loader"></div>

<div class="box">
	<div class="box-header">
			<h3 class="box-title">Adquira um plano  - PAGAMENTO PAYPAL</h3>
    </div>
	<div class="box-body">
		<div class="alert alert-info"><?php if(auth()->user()->ativo()): ?>
			Data de expiração: <?php echo e(date('d/m/Y',strtotime(auth()->user()->data_expiracao))); ?> <?php else: ?> NENHUM PLANO ATIVO <?php endif; ?> </div>

		<?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<p><b>(*)</b>Campos obrigratórios caso esteja habilitado para preenchimento.</p>
        <?php if($profissional != true): ?>
			<div class="col-md-6">
                <form-paypal profissional="<?php echo e($profissional); ?>" pais="EUA" url_obrigado_profissional="<?php echo e(route('venda.paypal.new',['plano' => 'profissional'])); ?>" email="<?php echo e(auth()->user()->email); ?>"></form-paypal>

		    </div>
        <?php else: ?>
            <h3>VOCÊ TEM DOIS PAGAMENTO PELO PAYPAL, PEDENTES. EXCLUA ALGUM OU ESPERE A CONFIRMAÇÃO DE PAGAMENTO, CASO TENHA REALIZADO O PAGAMENTO, QUALQUER DUVIDA ENTRE EM CONTA PELO EMAIL: WACORNERSTATS@GMAIL.COM</h3>
        <?php endif; ?>
		 	<hr>
	</div>
</div>





<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>