<!DOCTYPE html>
<html>
<head>
	<title>Send email</title>
	<!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site de estatísticas de escanteios(cantos) onde você irá encontrar estatisticas especificar para suas apostas. Estrategia 35ht, 10ht, 75ft, 82ft">
    <meta name="author" content="Wacorner - Site de Estatisticas de Cantos">   
    <link rel="shortcut icon" href="{{{ asset('assets/images/icone.png') }}}"> 
     
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Global CSS -->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">   
    <!-- Theme CSS -->  
    <link id="theme-style" rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
	<div class="container">

	     <!-- The justified navigation menu is meant for single line per list item.
	          Multiple lines will require custom code not provided by Bootstrap. -->
	    <div class="masthead">
	    	<br>
	       <h3 class="text-muted">WACORNER - Estatísticas direto ao ponto!</h3>
	    </div>

	     <!-- Jumbotron -->
	    <div class="jumbotron">
	       	<h1>Olá,</h1>
	       	<p class="lead"> {{$msg}}.</p>
	       	<hr>
	       	<a target="new" href="https://t.me/wacorner" style="">Telegram</a>
		    <a target="new" href="https://www.youtube.com/channel/UCFETZpCgwV52YLG-evfAvow" class="btn btn-danger">Canal no YouTube</a>
		    <a target="new" href="https://www.instagram.com/wacorner" class="btn btn-warning">Instagram</a>
	    </div>

	    
	    <!-- Site footer -->
	    <footer class="footer">
	    </footer>
	</div> <!-- /container -->

	<!-- Javascript -->          
    
    <script type="text/javascript" src="assets/plugins/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/plugins/jquery-scrollTo/jquery.scrollTo.min.js"></script>     
    <script type="text/javascript" src="assets/js/main.js"></script> 
</body>
</html>