@extends('adminlte::page')


@section('content_header')
@stop

@section('content')
<div class="box">
    <div class="box-header">
    	<h3 class="box-title">Descrição das estratégias</h1>
    	<div class="box-body">
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
    		<div class="row">
    			<br>
			<ul class="nav nav-tabs" id="myTabs" role="tablist"> 
				<li role="presentation"  class="active">
					<a href="#ht10" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">HT10</a>
				</li> 
				<li role="presentation" class="">
					<a href="#ht1020" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">HT1020</a>
				</li>
				<li role="presentation" class="">
					<a href="#ht35" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false">HT35</a>
				</li>
				<li role="presentation" class="">
					<a href="#ht38" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false">HT38</a>
				</li>
				<li role="presentation" class="">
					<a href="#ft75" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false">FT75</a>
				</li>
				<li role="presentation" class="">
					<a href="#ft82" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false">FT82</a>
				</li>
				<li role="presentation" class="">
					<a href="#ft88" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false">FT88</a>
				</li>
			</ul>
			</div>
			  <!-- Tab panes -->
			  <div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="ht10">
			    	<div class="embed-responsive embed-responsive-16by9">
					  <iframe class="embed-responsive-item" src="{{ asset('pdfs/F I E - Tec 0 a 10 HT - over 0.5.pdf')}}"></iframe>
					</div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="ht1020">
			    	EM BREVE
			    </div>
			    <div role="tabpanel" class="tab-pane" id="ht35">
			    	<div class="embed-responsive embed-responsive-16by9">
					  <iframe class="embed-responsive-item" src="{{ asset('pdfs/F I E - Tec 35 HT - Asiático.pdf')}}"></iframe>
					</div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="ht38">
			    	<div class="embed-responsive embed-responsive-16by9">
					  <iframe class="embed-responsive-item" src="{{ asset('pdfs/F I E - Tec 38 HT - Asiático Limite.pdf')}}"></iframe>
					</div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="ft75">
			    	<div class="embed-responsive embed-responsive-16by9">
					  <iframe class="embed-responsive-item" src="{{ asset('pdfs/F I E - Tec 75 FT - Alternativo.pdf')}}"></iframe>
					</div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="ft82">
			    	<div class="embed-responsive embed-responsive-16by9">
					  <iframe class="embed-responsive-item" src="{{ asset('pdfs/F I E - Tec 82 FT - Asiático.pdf')}}"></iframe>
					</div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="ft88">
			    	<div class="embed-responsive embed-responsive-16by9">
					  <iframe class="embed-responsive-item" src="{{ asset('pdfs/F I E - Tec 88 FT - Asiático Limite.pdf')}}"></iframe>
					</div>
			    </div>
			  </div>
		</div>
	</div>
</div>

@stop