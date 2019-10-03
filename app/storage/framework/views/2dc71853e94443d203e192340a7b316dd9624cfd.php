
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title_prefix', config('adminlte.title_prefix', '')); ?>
    <?php echo $__env->yieldContent('title', config('adminlte.title', 'AdminLTE 2')); ?>
    <?php echo $__env->yieldContent('title_postfix', config('adminlte.title_postfix', '')); ?></title>
    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/icone.png')); ?>"> 
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css')); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css')); ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('vendor/range-slider-master/css/rSlider.min.css')); ?>">

    <script src="<?php echo e(asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js')); ?>"></script>
    <?php if(auth()->check()): ?>
        <?php if(auth()->user()->user_id != null): ?>
            <!-- Facebook Pixel Code -->
            <script>
              !function(f,b,e,v,n,t,s)
              {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
              n.callMethod.apply(n,arguments):n.queue.push(arguments)};
              if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
              n.queue=[];t=b.createElement(e);t.async=!0;
              t.src=v;s=b.getElementsByTagName(e)[0];
              s.parentNode.insertBefore(t,s)}(window, document,'script',
              'https://connect.facebook.net/en_US/fbevents.js');
              fbq('init', '836431290076781');
              fbq('track', 'PageView');
            </script>
            <noscript><img height="1" width="1" style="display:none"
              src="https://www.facebook.com/tr?id=836431290076781&ev=PageView&noscript=1"
            /></noscript>
            <!-- End Facebook Pixel Code -->
        <?php endif; ?>
    <?php endif; ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-135732933-1"></script>
    <script>

        window.Laravel = <?php echo json_encode([
            'csrf' => csrf_token(),
            'pusher' =>[
                'key'       => config('broadcasting.connections.pusher.key'),
                'cluster'   => config('broadcasting.connections.pusher.options.cluster')
            ],
            'user' => auth()->check() ? auth()->user()->id : '',
            'url_inicial' => route('home')

            ]); ?>


        
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-135732933-1');
    </script>

    <?php if(config('adminlte.plugins.select2')): ?>
        <!-- Select2 -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
    <?php endif; ?>

    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/adminlte/dist/css/AdminLTE.min.css')); ?>">

    <?php if(config('adminlte.plugins.datatables')): ?>
        <!-- DataTables with bootstrap 3 style -->
        <link rel="stylesheet" href="//cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.css">
    <?php endif; ?>

    <?php echo $__env->yieldContent('adminlte_css'); ?>

    <?php echo $__env->yieldContent('js_header'); ?>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style type="text/css">
        #loader {
            display: none;
        }
        #loader.on {
          position: fixed;
            z-index: 99;
            top:0;
            left: 0;
            width: 100%;
            height: 100%;
            background:#1a1a1a;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 1;
        }
        /*#loader {
            position: fixed;
            z-index: 99;
            top:0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            display: none;
            justify-content: center;
            align-items: center;
        }*/

    </style>
    
   <?php if(auth()->check()): ?>

        <link rel="manifest" href="<?php echo e(asset('manifest.json')); ?>" />
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
        <script>
          var OneSignal = window.OneSignal || [];
          OneSignal.push(function() {
            OneSignal.init({
              appId: "2ccc08ae-7390-447e-bce0-28033434f4bf",
            });

            OneSignal.sendTags({
                user_id: window.Laravel.user,
              }).then(function(tagsSent) {
                
                console.log(tagsSent);   
              });
          });
        </script>    
          
    <?php endif; ?>
</head>
<body class="hold-transition <?php echo $__env->yieldContent('body_class'); ?>">
    <div id="loader">
        <img src="<?php echo e(asset('assets/images/preloader.gif')); ?>" alt="Loading....">
    </div>
    <div id="app">
        <?php echo $__env->yieldContent('body'); ?>
    </div>
<script type="text/javascript">
    function preloader(val){
        if(val){
            $('#loader').addClass("on");
        }else{
            if($('#loader').hasClass('on')){
                $('#loader').removeClass("on");
            }
        }
    }
</script>
<script src="<?php echo e(asset('vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/jstz.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/moment.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/moment-timezone-with-data.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/range-slider-master/js/rSlider.min.js')); ?>"></script>


<script type="text/javascript">
  
    //MUDAR A DATA
    
    <?php if(auth()->check()): ?>
    function fuso(){
        var i;
        var data = document.getElementsByClassName('fuso_data');
        var time = document.getElementsByClassName('fuso_time');
        for (i = 0; i < data.length; i++) {
            var currentData = data[i].innerText+" "+time[i].innerText;
            var a = moment.tz(currentData, "America/Fortaleza");
            <?php if(auth()->user()->zona != null): ?>
                var b = a.clone().tz("<?php echo e(auth()->user()->zona); ?>");
            <?php else: ?>
                var b = a.clone().tz("America/Fortaleza");
            <?php endif; ?>

            data[i].innerHTML = b.format('DD-MM-YYYY');
            time[i].innerHTML = b.format('HH:mm');
        }

        var dataCompleta = document.getElementsByClassName('fuso');
        for (i = 0; i < dataCompleta.length; i++) {
            
            var a = moment.tz(dataCompleta[i].innerText, "America/Fortaleza");
            <?php if(auth()->user()->zona != null): ?>
                var b = a.tz("<?php echo e(auth()->user()->zona); ?>");
            <?php else: ?>
                var b = a.tz("America/Fortaleza");
            <?php endif; ?>

            dataCompleta[i].innerHTML = b.format('DD-MM-YYYY HH:mm');
        }

    }
    fuso();
    <?php endif; ?>
</script>
<?php if(config('adminlte.plugins.select2')): ?>
    <!-- Select2 -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<?php endif; ?>

<?php if(config('adminlte.plugins.datatables')): ?>
    <!-- DataTables with bootstrap 3 renderer -->
    <script src="//cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.js"></script>
<?php endif; ?>

<?php if(config('adminlte.plugins.chartjs')): ?>
    <!-- ChartJS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
<?php endif; ?>
<script src="<?php echo e(mix('js/app.js')); ?>"></script>
<?php echo $__env->yieldContent('adminlte_js'); ?>

</body>
</html>
