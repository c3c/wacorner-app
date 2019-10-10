


<?php $__env->startSection('content_header'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="box">
  <div class="box-header">
      <div class="col-md-3">
        <h3 class="box-title">Minhas Listas</h1>
      </div>
      <div class="col-md-offset-7 col-md-2">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#lista-add">
          Nova Lista
        </button>
        
      </div>
    </div>
  <div class="box-body">
    <?php echo $__env->make('admin.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__empty_1 = true; $__currentLoopData = $listas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo e($lista->id); ?>" aria-expanded="true" aria-controls="collapseOne">
              <i class="fa fa-soccer-ball-o "></i> <?php echo e($lista->nome); ?> 
            </a>
          </h4>
        </div>
        <div id="collapse<?php echo e($lista->id); ?>" class="panel panel-default" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
            <a href="<?php echo e(route('lista.delete',['id' => $lista->id])); ?>" class="btn btn-danger btn-xs"> <i class="fa fa-remove"></i> Excluir a lista</a>
            <a href="<?php echo e(route('lista.limpar',['id' => $lista->id])); ?>" class="btn btn-primary btn-xs"> <i class="fa fa-bomb"></i> Limpar lista</a>
            <br><br>
            <?php $__empty_2 = true; $__currentLoopData = $lista->jogos()->orderBy('start','desc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jogo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
              <ul>
                <li><b>DATA:</b> <span class="fuso"><?php echo e(date('Y-m-d H:i',  strtotime($jogo->start))); ?></span>  - <b>LIGA:</b> <?php echo e($jogo->liga->l); ?> - <b>JOGO: <a style="color: #00b300" target="_blank" href="<?php echo e(route('admin.jogo',['id'=>$jogo->id])); ?>">  <?php echo e($jogo->time_casa->nome); ?> x <?php echo e($jogo->time_fora->nome); ?> </i></a></b> <a href="<?php echo e(route('lista.delete.jogo',['id_lista'=>$lista->id, 'id_jogo' => $jogo->id])); ?>" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a></li>
              </ul>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
              SEM JOGOS
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>   
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      SEM LISTAS
    <?php endif; ?>   
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="lista-add" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nova lista</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-lista-new" action="<?php echo e(route('lista.new')); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <div class="form-group">
            <label for="title"> Nome da lista</label>
            <input type="text" name="nome" class="form-control" required>
          </div>
        </form>  
      </div>
      <div class="modal-footer">
        <button  type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button form="form-lista-new" class="btn btn-primary">Salvar</button>
         
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>