<!DOCTYPE html>
<html lang="en">
<head>
    <title>WAcorner - Estatisticas direto ao ponto!</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site de estatísticas de escanteios(cantos) onde você irá encontrar estatisticas especificar para suas apostas. Estrategia 35ht, 10ht, 75ft, 82ft">
    <meta name="author" content="Wacorner - Site de Estatisticas de Cantos">   
    <link rel="shortcut icon" href="{{ asset('assets/images/icone.png') }}"> 
     
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Global CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">   
    <!-- Theme CSS -->  
    <link id="theme-style" rel="stylesheet" href="{{ asset('assets/css/styles.css')}}">
    @if($id != null)
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
    @endif
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-135732933-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-135732933-1');
    </script>

    
</head> 

<body>
    <!-- ******HEADER****** --> 
    <header id="header" class="header">  
        <div class="container">       
            <h1 class="logo">
                <a class="scrollto" href="#hero">
                   
                    <span class="text"><span class="highlight"><i class="fa fa-line-chart"></i> WA</span>corner</span></a>
            </h1><!--//logo-->
            <nav class="main-nav navbar-expand-md float-right navbar-inverse" role="navigation">
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button><!--//nav-toggle-->
                
                <div id="navbar-collapse" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item"><a class="active nav-link" href="{{ url('/admin/gestao') }}">Meu painel</a></li>
                            @else
                                <li class="nav-item"><a class="active nav-link" href="{{ route('login') }}">Login</a></li>
                            @endauth
                        @endif                     
                        <li class="nav-item"><a class="nav-link scrollto" href="#estrategia">Estratégias e Estatísticas</a></li>                        
                        <li class="nav-item"><a class="nav-link scrollto" href="#ranking">Ao Vivo</a></li>
                        <li class="nav-item"><a class="nav-link scrollto" href="#pricing">Planos</a></li>
                        <li class="nav-item"><a class="nav-link scrollto" href="#contact">Contato</a></li>
                    </ul><!--//nav-->
                </div><!--//navabr-collapse-->
            </nav><!--//main-nav-->                     
        </div><!--//container-->
    </header><!--//header-->
    
    <div id="hero" class="hero-section">
        
        <div id="hero-carousel" class="hero-carousel carousel carousel-fade slide" data-ride="carousel" data-interval="10000">
            
            <div class="figure-holder-wrapper">
                <div class="container">
                    <div class="row justify-content-end">
                        <div class="figure-holder">
                            <img class="figure-image img-fluid" src="{{ asset('assets/images/imac.png')}}" alt="image" />
                        </div><!--//figure-holder-->
                    </div><!--//row-->
                </div><!--//container-->
            </div><!--//figure-holder-wrapper-->
            
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li class="active" data-slide-to="0" data-target="#hero-carousel"></li>
                <li data-slide-to="1" data-target="#hero-carousel"></li>
                <li data-slide-to="2" data-target="#hero-carousel"></li>
                <li data-slide-to="3" data-target="#hero-carousel"></li>
            </ol>
            
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                
                <div class="carousel-item item-1 active">
                    <div class="item-content container">
                        <div class="item-content-inner">
                            
                            <h2 class="heading">Venha conhecer nosso sistema</h2>
                            <p class="intro">Teste por 1 dia gratuitamente.</p>
                            <a class="btn btn-primary btn-cta" href="#pricing">Registrar-se</a>
                            
                        </div><!--//item-content-inner-->
                    </div><!--//item-content-->
                </div><!--//item-->
                
                <div class="carousel-item item-2">
                    <div class="item-content container">
                        <div class="item-content-inner">
                            
                            <h2 class="heading">Analise Jogos Ao Vivo</h2>
                            <p class="intro">Caso não tenha tempo de fazer analise pré-live, use essa ferramenta para te auxiliar na escolha de suas entradas!</p>
                            
                            
                        </div><!--//item-content-inner-->
                    </div>
                </div><!--//item-->
                <div class="carousel-item item-3">
                    <div class="item-content container">
                        <div class="item-content-inner">
                            
                            <h2 class="heading">Gestão de Banca</h2>
                            <p class="intro">Pare de utilizar planilhas e venha fazer sua gestão no nosso site.</p>
                            
                            
                        </div><!--//item-content-inner-->
                    </div>
                </div><!--//item-->
                <div class="carousel-item item-4">
                    <div class="item-content container">
                        <div class="item-content-inner">
                            
                            <h2 class="heading">Robôs WAcorner</h2>
                            <p class="intro">Configure do seu jeito e de forma simples. Receba as notificações de jogos no seu telegram.</p>
                            
                            
                        </div><!--//item-content-inner-->
                    </div>
                </div><!--//item-->
                
            </div><!--//carousel-inner-->

        </div><!--//carousel-->
    </div><!--//hero-->
    
    <div id="estrategia" class="about-section">
        <div class="container text-center">
            <h2 class="section-title">Estratégias e Estatísticas</h2>
            <p class="intro">A baixo descrevemos todas as estratégias e estatísticas utilizadas pelo nosso site.</p>
            <div class="col-md-2"><h4>Estratégias</h4>
            <hr></div>
            <div class="items-wrapper row">
                <div class="item col-md-3 col-12">
                    <div class="item-inner">
                        <h3 class="item-title">10 HT</h3>
                        <div class="item-desc">
                            Nessa estratégia o objetivo será buscar 1 canto nos primeiros 10 minutos de jogo. 
                        </div><!--//item-desc-->
                    </div><!--//item-inner-->
                </div><!--//item-->
                <div class="item col-md-3 col-12">
                    <div class="item-inner">
                        <h3 class="item-title">1020 HT</h3>
                        <div class="item-desc">
                            Nessa estratégia o objetivo será buscar 1 canto entre os minutos 10 e 20 do jogo. 
                        </div><!--//item-desc-->
                    </div><!--//item-inner-->
                </div><!--//item-->
                <div class="item col-md-3 col-12">
                    <div class="item-inner">
                        <h3 class="item-title">35 HT</h3>
                        <div class="item-desc">
                            Nessa estratégia o objetivo será buscar 1 canto ou 2 cantos no final do 1º tempo. 
                        </div><!--//item-desc-->
                    </div><!--//item-inner-->
                </div><!--//item-->
                <div class="item col-md-3 col-12">
                    <div class="item-inner">
                        <h3 class="item-title">38 HT</h3>
                        <div class="item-desc">
                            Nessa estratégia o objetivo será buscar 1 canto no final do 1º tempo. 
                        </div><!--//item-desc-->
                    </div><!--//item-inner-->
                </div><!--//item-->
                <div class="item col-md-3 col-12">
                    <div class="item-inner">
                        <h3 class="item-title">75 FT</h3>
                        <div class="item-desc">
                            Nessa estratágia iremos buscar 2 cantos após os 75 min do jogo.
                        </div><!--//item-desc-->
                    </div><!--//item-inner-->
                </div><!--//item-->
                <div class="item col-md-3 col-12">
                    <div class="item-inner">
                        <h3 class="item-title">82 FT</h3>
                        <div class="item-desc">
                        Nessa estratégia o objetivo será buscar 1 canto ou 2 cantos no final do 2º tempo. 
                        </div><!--//item-desc-->
                    </div><!--//item-inner-->
                </div><!--//item-->
                <div class="item col-md-3 col-12">
                    <div class="item-inner">
                        <h3 class="item-title">88 FT</h3>
                        <div class="item-desc">
                            Nessa estratágia o objetivo será buscar 1 canto no final do 2º tempo.
                        </div><!--//item-desc-->
                    </div><!--//item-inner-->
                </div><!--//item-->
                
            </div><!--//items-wrapper-->
            <div class="col-md-2"><h4>Estatísticas</h4>
            <hr></div>
            <div class="items-wrapper row">
                <div class="item col-md-3 col-12">
                    <div class="item-inner">
                        <h3 class="item-title" style="color:#000">Média 1º tempo</h3>
                        <div class="item-desc">
                     
                        </div><!--//item-desc-->
                    </div><!--//item-inner-->
                </div><!--//item-->
                <div class="item col-md-3 col-12">
                    <div class="item-inner">
                        <h3 class="item-title" style="color:#000">Média 2º tempo</h3>
                        <div class="item-desc">
                        
                        </div><!--//item-desc-->
                    </div><!--//item-inner-->
                </div><!--//item-->
                <div class="item col-md-2 col-12">
                    <div class="item-inner">
                        <h3 class="item-title" style="color:#000">Média total</h3>
                        <div class="item-desc">
                            
                        </div><!--//item-desc-->
                    </div><!--//item-inner-->
                </div><!--//item-->
                <div class="item col-md-2 col-12">
                    <div class="item-inner">
                        <h3 class="item-title" style="color:#000">Porcentagem de over</h3>
                        <div class="item-desc">
                            Over 7,8,9,10,11,12.
                        </div><!--//item-desc-->
                    </div><!--//item-inner-->
                </div><!--//item-->
            </div><!--//items-wrapper-->
           
        </div><!--//container-->
    </div><!--//about-section-->
    
    <div id="ranking" class="testimonials-section">
        <div class="container">
            <h2 class="section-title text-center">Ferramenta Ao Vivo</h2>
            <div class="row">
                <div class="col-md-8">
                    <img class="figure-image img-fluid" src="{{ asset('assets/images/aovivo.png')}}" alt="image" />
                </div>
                <div class="col-md-4">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">Nessa ferramenta você pode filtrar os jogos que estão acontecendo no momento e decidir fazer ou não uma entrada em cantos. Você obtem alguns dados importantes como:</li>
                      <li class="list-group-item">1 - Numero de cantos no jogo</li>
                      <li class="list-group-item">2 - Estatisticas detalhadas</li>
                      <li class="list-group-item">3 - Superioridade no momento do jogo</li>
                      <li class="list-group-item">4 - Tempo de jogo</li>
                      <li class="list-group-item">5 - Nº de gols</li>
                    </ul>
                </div>
            </div>
        </div><!--//container-->
    </div><!--//testimonials-->
    
    <div id="pricing" class="pricing-section">
        <div class="container text-center">
            <h2 class="section-title">Nossos planos</h2>
            <div class="intro"></div>
            <div class="pricing-wrapper row">
                <div class="item item-1 col-md-6 col-12">
                    <div class="item-inner">
                        <h3 class="item-heading">GRÁTIS</h3>
                        <div class="price-figure">
                            <span class="currency">R$</span><span class="number">0</span>
                        </div><!--//price-figure-->
                        <ul class="list-unstyled mb-3">
                            <li class="mb-2"><i class="fa fa-check"></i> Tudo liberado</li>
                            <li class="mb-2"><i class="fa fa-calendar"></i> Válido por 1 dia</li>
                        </ul>
                        
                        <a class="btn btn-cta" href="{{route('venda')}}">Adquirir</a>
                        
                    </div><!--//item-inner-->
                </div><!--//item-->
                <div class="item item-3 col-md-6 col-12">
                    <div class="item-inner">
                        <h3 class="item-heading">Plano Profissional<br><span class="item-heading-desc">(Cliente profissional)</span></h3>
                        <div class="price-figure">
                            <span class="currency">R$</span><span class="number">29,99</span>
                        </div><!--//price-figure-->
                        <ul class="list-unstyled mb-3">
                            <li class="mb-2"><i class="fa fa-check"></i> Tudo liberado</li>
                            <li class="mb-2"><i class="fa fa-calendar"></i> Válido por 30 dias</li>
                        </ul>
                        
                        <a class="btn btn-cta" href="{{route('venda')}}">Adquirir</a>
                    </div><!--//item-inner-->
                </div><!--//item-->
            </div><!--//pricing-wrapper-->
            
        </div><!--//container-->
    </div><!--//pricing-section-->
    <div id="contact" class="contact-section">
        <div class="container text-center">
            <h2 class="section-title">Contato</h2>
            <div class="contact-content">
                <p>Para tirar alguma dúvida ou mandar sugestões entre em contato.</p>
                
            </div>
            <a class="btn btn-cta btn-success" href="#"><i class="fa fa-commenting-o"></i> E-mail - wacornerstats@gmail.com</a>
            <a class="btn btn-cta btn-primary" href="https://t.me/wacorner"><i class="fa fa-bullhorn"></i> Telegram</a>
            <a class="btn btn-cta btn-danger" href="https://www.youtube.com/channel/UCFETZpCgwV52YLG-evfAvow"><i class="fa fa-youtube-play"></i> Canal no Youtube</a>
            
        </div><!--//container-->
    </div><!--//contact-section-->
    
    <footer class="footer text-center">
        <div class="container">
            <!--/* This template is released under the Creative Commons Attribution 3.0 License. Please keep the attribution link below when using for your own project. Thank you for your support. :) If you'd like to use the template without the attribution, you can buy the commercial license via our website: themes.3rdwavemedia.com */-->
            <small class="copyright">Designed with <i class="fas fa-heart"></i> by <a href="https://themes.3rdwavemedia.com/" target="_blank">Xiaoying Riley</a> for developers</small>
            
            
        </div><!--//container-->
    </footer>
     
    
    <!-- Javascript -->          
    
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery-3.3.1.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery-scrollTo/jquery.scrollTo.min.js')}}"></script>     
    <script type="text/javascript" src="{{ asset('assets/js/main.js')}}"></script> 
    
</body>
</html> 

