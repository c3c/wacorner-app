@extends('adminlte::page')

@section('js_header')
		<script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>

@stop
@section('content_header')
<h1>{{$jogo->time_casa->nome}} x {{$jogo->time_fora->nome}} - {{$jogo->liga->l}} - <i class="fa fa-calendar"></i> <span class="fuso"> {{date('Y-m-d H:i', strtotime($jogo->start))}}</span></h1><sup>Ref.{{$jogo->id}}</sup>
@stop

@section('content')

<div class="box">
    	<div class="box-header">
    			 
    		<div class="box-body">
    			@if(auth()->user()->admin == 1)
    			<div class="row">
    				<div class="col-md-6">
    				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tabela">
						<i class="fa fa-list"></i> Tabela de Classificação
					</button>
					<modal-link tipo="button" nome="adicionar-lista" icone="fa fa-plus" css="btn btn-warning" titulo="Adicionar a lista" item="{{$jogo->id}}" url="{{route('listas')}}"></modal-link>
					<modal-link tipo="button" nome="adicionar-gestao" icone="fa fa-usd" css="btn btn-info" titulo="Nova entrada" item="{{$jogo->id}}" url="{{route('gestao.estrategias')}}"></modal-link>
					</div>
				</div>
				<hr>
				@endif
    			<div class="row">

    				<div class="col-md-4">
    					<div class="info-box bg-aqua">
				            <span class="info-box-icon">FT</span>
				            <div class="info-box-content">
				              <span class="info-box-text">Media Total</span>
				              <span class="info-box-number">{{$jogo->ft}} cantos</span>

				              <div class="progress">
				                <div class="progress-bar" style="width: 100%"></div>
				              </div>
				              <span class="progress-description"></span>
				              <modal-link css="btn btn-warning btn-xs" nome="ft-medias" tipo="button" titulo="Ver mais"></modal-link>
				            </div>
				            <!-- /.info-box-content -->
				        </div>
    				</div>
    				<div class="col-md-4">
    					<div class="info-box bg-green">
				            <span class="info-box-icon">1º</span>
				            <div class="info-box-content">
				              <span class="info-box-text">Media 1º Tempo</span>
				              <span class="info-box-number">{{$jogo->ht1}} cantos</span>
				              <div class="progress">
				                <div class="progress-bar" style="width: 100%"></div>
				              </div>
				              <span class="progress-description"></span>
				              <modal-link css="btn btn-warning btn-xs" nome="ht1-medias" tipo="button" titulo="Ver mais"></modal-link>
				            </div>
				            <!-- /.info-box-content -->
				        </div>
    				</div>
    				<div class="col-md-4">
    					<div class="info-box bg-green">
				            <span class="info-box-icon">2º</span>
				            <div class="info-box-content">
				              <span class="info-box-text">Media 2º Tempo</span>
				              <span class="info-box-number">{{$jogo->ht2}} cantos</span>
				              <div class="progress">
				                <div class="progress-bar" style="width: 100%"></div>
				              </div>
				              <span class="progress-description"></span>
				              <modal-link css="btn btn-warning btn-xs" nome="ht2-medias" tipo="button" titulo="Ver mais"></modal-link>
				            </div>
				            <!-- /.info-box-content -->
				        </div>
    				</div>
    			</div>

    			<div class="row">
    				<hr>
    				<div class="col-md-6">
    					<h3>{{$jogo->n_jogos_casa}} jogo(s) anteriore(s) - {{$jogo->time_casa->nome}}</h3>
    					<div class="table-responsive">
		    				<table class="table table-striped">
			                <tbody>
			                	<tr>
				                  	
				                  	<th>Data</th>
				                  	<th>Hora</th>
				                  	<th>Casa</th>
				                  	<th>HT</th>
				                  	<th>FT</th>
				                  	<th>Fora</th>
				                  	<th>Cantos</th>
				                </tr>
				                @foreach($jogos_casa as $jogo_c)
				                		<tr>
						               	
						               	<td class="fuso_data">{{date('Y-m-d',  strtotime($jogo_c->start))}}</td>
	                  					<td class="fuso_time">{{date('H:i',  strtotime($jogo_c->start))}}</td>
						               	<td>{{$jogo_c->time_casa->nome}}</td>
						               	
						              	<td ><span class="badge bg-green">{{$ht_ft_casa[$jogo_c->id]['n_ht_casa']}} - {{$ht_ft_casa[$jogo_c->id]['n_ht_fora']}}</span></td>
						              	<td ><span class="badge bg-green">{{$ht_ft_casa[$jogo_c->id]['n_ft_casa']}} - {{$ht_ft_casa[$jogo_c->id]['n_ft_fora']}}</span></td>
						              	<td>{{$jogo_c->time_fora->nome}}</td>
						              	<td>
						              		<button type="button" class="btn btn-info" data-toggle="modal" data-target="#{{$jogo_c->id}}">
						              		  <img class="" src="{{asset('assets/images/canto_fora.png')}}" width="20" height="20" />
						              		</button>
						              	</td>
					            	</tr>

					            	<!-- Modal -->
					            	<div class="modal fade" id="{{$jogo_c->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					            	  <div class="modal-dialog" role="document">
					            	    <div class="modal-content">
					            	      <div class="modal-header">
					            	        <h3 class="modal-title" id="exampleModalLabel">Cantos</h3>
					            	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					            	          <span aria-hidden="true">&times;</span>
					            	        </button>
					            	      </div>
					            	      <div class="modal-body">
					            	      	<ul class="list-group">
					            		        @foreach($jogo_c->eventos as $evento)
					            		        	<li class="list-group-item d-flex justify-content-between align-items-center">
					            		        		
					            		        		@if($evento->casa == 1) 
					            		        			<img class="" src="{{asset('assets/images/canto_casa.png')}}" width="20" height="20" />
					            		        			{{$jogo_c->time_casa->nome}} 
					            		        		@else 
					            		        			<img class="" src="{{asset('assets/images/canto_fora.png')}}" width="20" height="20" />
					            		        			{{$jogo_c->time_fora->nome}} 
					            		        		@endif 
					            		        		<span class="badge bg-green"> {{$evento->t}}</span></li>
					            		        @endforeach
					            	    	</ul>
					            	      </div>
					            	      <div class="modal-footer">
					            	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
					            	      </div>
					            	    </div>
					            	  </div>
					            	</div>
					            	
					            	
					            @endforeach
			              </tbody>
			          		</table>
			          	</div>						
		    		</div>
		    		<div class="col-md-6">
    					<h3>{{$jogo->n_jogos_fora}} jogo(s) anteriore(s) - {{$jogo->time_fora->nome}}</h3>
    					<div class="table-responsive">
		    				<table class="table table-striped">
			                <tbody>
			                	<tr>
				                  	
				                  	<th>Data</th>
				                  	<th>Hora</th>
				                  	<th>Casa</th>
				                  	<th>HT</th>
				                  	<th>FT</th>
				                  	<th>Fora</th>
				                  	<th>Cantos</th>
				                </tr>
				                @foreach($jogos_fora as $jogo_f)
				                	<tr>
					              		
						               	<td class="fuso_data">{{date('Y-m-d',  strtotime($jogo_f->start))}}</td>
	                  					<td class="fuso_time">{{date('H:i',  strtotime($jogo_f->start))}}</td>
						               	<td>{{$jogo_f->time_casa->nome}}</td>
						               	
						              	<td ><span class="badge bg-green">{{$ht_ft_fora[$jogo_f->id]['n_ht_casa']}} - {{$ht_ft_fora[$jogo_f->id]['n_ht_fora']}}</span></td>
						              	<td ><span class="badge bg-green">{{$ht_ft_fora[$jogo_f->id]['n_ft_casa']}} - {{$ht_ft_fora[$jogo_f->id]['n_ft_fora']}}</span></td>
						              	<td>{{$jogo_f->time_fora->nome}}</td>
						              	<td>
						              		<button type="button" class="btn btn-info" data-toggle="modal" data-target="#{{$jogo_f->id}}">
						              		 <img class="" src="{{asset('assets/images/canto_fora.png')}}" width="20" height="20" />
						              		</button>
						              	</td>
					            	</tr>

					            	<!-- Modal -->
					            	<div class="modal fade" id="{{$jogo_f->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					            	  <div class="modal-dialog" role="document">
					            	    <div class="modal-content">
					            	      <div class="modal-header">
					            	        <h3 class="modal-title" id="exampleModalLabel">Cantos</h3>
					            	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					            	          <span aria-hidden="true">&times;</span>
					            	        </button>
					            	      </div>
					            	      <div class="modal-body">
					            	      	<ul class="list-group">
					            		        @foreach($jogo_f->eventos as $evento)
					            		        	<li class="list-group-item d-flex justify-content-between align-items-center">
					            		        		
					            		        		@if($evento->casa == 1) 
					            		        			<img class="" src="{{asset('assets/images/canto_casa.png')}}" width="20" height="20" />
					            		        			{{$jogo_f->time_casa->nome}} 
					            		        		@else 
					            		        			<img class="" src="{{asset('assets/images/canto_fora.png')}}" width="20" height="20" />
					            		        			{{$jogo_f->time_fora->nome}} 
					            		        		@endif 
					            		        		<span class="badge bg-green"> {{$evento->t}}</span></li>
					            		        @endforeach
					            	    	</ul>
					            	      </div>
					            	      <div class="modal-footer">
					            	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
					            	      </div>
					            	    </div>
					            	  </div>
					            	</div>

					            
					            @endforeach
			              </tbody>
			          		</table>
			          	</div>						
		    		</div>
	    		</div>
	    		<div class="row">
	    			<hr>
	    			<h1><i class="fa fa-line-chart"></i> Estatísticas <h4><b>Time casa:</b><i> {{$jogo->n_jogos_casa}} jogo(s) analisado(s)</i><br><b>Time fora:</b> <i>{{$jogo->n_jogos_fora}} jogo(s) analizado(s)</i></h4></h1>
	    			<div class="col-md-12">
	    				
	    				<div class="col-md-6">
		    				
		    				<tabela-media-favor-contra titulo='HT10' estrategia='ht10' :jogo='{{$jogo}}'></tabela-media-favor-contra>
		    				<tabela-media-favor-contra titulo='10 a 20 min HT' estrategia='ht1020' :jogo='{{$jogo}}'></tabela-media-favor-contra>
		    				<tabela-media-favor-contra titulo='HT35' estrategia='ht35' :jogo='{{$jogo}}'></tabela-media-favor-contra>
		    				<tabela-media-favor-contra titulo='HT38' estrategia='ht38' :jogo='{{$jogo}}'></tabela-media-favor-contra>
		    			</div>
		    			<div class="col-md-6">
		    				<tabela-media-favor-contra titulo='FT75' estrategia='ft75' :jogo='{{$jogo}}'></tabela-media-favor-contra>
		    				<tabela-media-favor-contra titulo='FT82' estrategia='ft82' :jogo='{{$jogo}}'></tabela-media-favor-contra>
		    				<tabela-media-favor-contra titulo='FT88' estrategia='ft88' :jogo='{{$jogo}}'></tabela-media-favor-contra>
		            	</div>
	    			</div>
	    			<hr>
	    			<div class="col-md-12">
	    				<h1>Estatísticas Over</h1>
	    				<div class="col-md-6">
		                  <div class="progress-group">
		                    <span class="progress-text">Over 7</span>
		                    <span class="progress-number"><b>{{round($jogo->over7)}}%</b></span>
		                    <div class="progress sm">
		                      <div class="progress-bar progress-bar-aqua" style="width: {{$jogo->over7}}%"></div>
		                    </div>
		                  </div>
		                  <div class="progress-group">
		                    <span class="progress-text">Over 8</span>
		                    <span class="progress-number"><b>{{round($jogo->over8)}}%</b></span>
		                    <div class="progress sm">
		                      <div class="progress-bar progress-bar-aqua" style="width: {{round($jogo->over8)}}%"></div>
		                    </div>
		                  </div>
		                  <div class="progress-group">
		                    <span class="progress-text">Over 9</span>
		                    <span class="progress-number"><b>{{round($jogo->over9)}}%</b></span>
		                    <div class="progress sm">
		                      <div class="progress-bar progress-bar-aqua" style="width: {{round($jogo->over9)}}%"></div>
		                    </div>
		                  </div>
		                </div>
		                <div class="col-md-6">
		                  <div class="progress-group">
		                    <span class="progress-text">Over 10</span>
		                    <span class="progress-number"><b>{{round($jogo->over10)}}%</b></span>
		                    <div class="progress sm">
		                      <div class="progress-bar progress-bar-aqua" style="width: {{round($jogo->over10)}}%"></div>
		                    </div>
		                  </div>
		                  <div class="progress-group">
		                    <span class="progress-text">Over 11</span>
		                    <span class="progress-number"><b>{{round($jogo->over11)}}%</b></span>
		                    <div class="progress sm">
		                      <div class="progress-bar progress-bar-aqua" style="width: {{round($jogo->over11)}}%"></div>
		                    </div>
		                  </div>
		                  <div class="progress-group">
		                    <span class="progress-text">Over 12</span>
		                    <span class="progress-number"><b>{{round($jogo->over12)}}%</b></span>
		                    <div class="progress sm">
		                      <div class="progress-bar progress-bar-aqua" style="width: {{round($jogo->over12)}}%"></div>
		                    </div>
		                  </div>	
		                </div>	                  
	    			</div>
	    		</div>
    		</div>
    		<div class="row">
    			<div class="col-md-6">
    				<h1>{{$jogo->time_casa->nome}}</h1>
		    		<grafico style="background: #F2F2F2 url({{asset('assets/images/logo.png')}}) no-repeat -130px 30px;" id="time_casa" :jogos="{{$jogos_casa}}"  :labels="['0-5','6-10','11-15','16-20','21-25','26-30','31-35','36-40','41-45+','46-50','51-55','56-60','61-65','66-70','71-75','76-80','81-85','86-90+']"></grafico>
				</div>

				<div class="col-md-6">
    				<h1>{{$jogo->time_fora->nome}}</h1>
		    		<grafico style="background: #F2F2F2 url({{asset('assets/images/logo.png')}}) no-repeat -130px 30px;" id="time_fora" :jogos="{{$jogos_fora}}" :labels="['0-5','6-10','11-15','16-20','21-25','26-30','31-35','36-40','41-45+','46-50','51-55','56-60','61-65','66-70','71-75','76-80','81-85','86-90+']"></grafico>
				</div>
				
    		</div>
    		<div class="row">
    			<div class="col-md-6">
    				
				</div>
    		</div>
    	</div><!--FIM DA DIV BOX-BODY-->
    </div><!--FIM DA DIV BOX-->

    <!--ft-medias-->
    <modal nome="ft-medias" titulo="FT - Mais detalhes">
	    <table class="table table-bordered">
	    	<thead>
	    		<th>Time</th>
	    		<th>Media Favor</th>
	    		<th>Media Contra</th>
	    		<th>Total</th>
	    	</thead>
	    	<tbody>
	    		<tr class="info">
	        		<td>{{$jogo->time_casa->nome}}</td>
	        		<td>{{$jogo->ft_media_favor_casa}}</td>
	        		<td>{{$jogo->ft_media_contra_casa}}</td>
	        		<td>{{($jogo->ft_media_favor_casa + $jogo->ft_media_contra_casa)}}</td>
	    		</tr>
	    		<tr class="active">
	        		<td>{{$jogo->time_fora->nome}}</td>
	        		<td>{{$jogo->ft_media_favor_fora}}</td>
	        		<td>{{$jogo->ft_media_contra_fora}}</td>
	        		<td>{{($jogo->ft_media_favor_fora + $jogo->ft_media_contra_fora)}}</td>	        		
	    		</tr>
	    	</tbody>
	    </table>
    </modal>

    <!--ht1-medias-->
    <modal nome="ht1-medias" titulo="HT1 - Mais detalhes">
	    <table class="table table-bordered">
	    	<thead>
	    		<th>Time</th>
	    		<th>Media Favor</th>
	    		<th>Media Contra</th>
	    		<th>Total</th>
	    		
	    	</thead>
	    	<tbody>
	    		<tr class="info">
	        		<td>{{$jogo->time_casa->nome}}</td>
	        		<td>{{$jogo->ht1_media_favor_casa}}</td>
	        		<td>{{$jogo->ht1_media_contra_casa}}</td>
	        		<td>{{($jogo->ht1_media_favor_casa + $jogo->ht1_media_contra_casa)}}</td>
	        		
	    		</tr>
	    		<tr class="active">
	        		<td>{{$jogo->time_fora->nome}}</td>
	        		<td>{{$jogo->ht1_media_favor_fora}}</td>
	        		<td>{{$jogo->ht1_media_contra_fora}}</td>
	        		<td>{{($jogo->ht1_media_favor_fora + $jogo->ht1_media_contra_fora)}}</td>
	        		
	    		</tr>
	    	</tbody>
	    </table>
    </modal>
    
    <!--ht2-medias-->
    <modal nome="ht2-medias" titulo="HT2 - Mais detalhes">
	    <table class="table table-bordered">
	    	<thead>
	    		<th>Time</th>
	    		<th>Media Favor</th>
	    		<th>Media Contra</th>
	    		<th>Total</th>
	    		
	    	</thead>
	    	<tbody>
	    		<tr class="info">
	        		<td>{{$jogo->time_casa->nome}}</td>
	        		<td>{{$jogo->ht2_media_favor_casa}}</td>
	        		<td>{{$jogo->ht2_media_contra_casa}}</td>
	        		<td>{{($jogo->ht2_media_favor_casa + $jogo->ht2_media_contra_casa)}}</td>
	        		
	    		</tr>
	    		<tr class="active">
	        		<td>{{$jogo->time_fora->nome}}</td>
	        		<td>{{$jogo->ht2_media_favor_fora}}</td>
	        		<td>{{$jogo->ht2_media_contra_fora}}</td>
	        		<td>{{($jogo->ht2_media_favor_fora + $jogo->ht2_media_contra_fora)}}</td>
	        		
	    		</tr>
	    	</tbody>
	    </table>
    </modal>
    
    <!-- Modal -->
    <div class="modal fade" id="tabela" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-list"></i> Tabela de Classificação</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
      	    <table class="table table-striped">
      	        <tbody>
      	        	<tr>
      	              	
      	              	<th>Posição</th>
      	              	<th>Time</th>
      	              	<th>Pontos</th>
      	              	<th>Vitórias</th>
      	              	<th>Empates</th>
      	              	<th>Derrotas</th>
      	              	<th>Nº Jogos</th>
      	            </tr>
      	            @foreach($jogo->liga->times as $liga_time)
      	            	@if($liga_time->nome == $jogo->time_casa->nome || $liga_time->nome == $jogo->time_fora->nome )
      	            		<tr style="background-color: rgb(255, 228, 143);">
      	              	@else
      	              		<tr>
      	              	@endif
      		               	<td>{{$liga_time->pivot->posicao}}</td>
      		               	<td>{{$liga_time->nome}}</td>
      		               	<td>{{$liga_time->pivot->pontos}}</td>
      		               	<td>{{$liga_time->pivot->vitorias}}</td>
      		               	<td>{{$liga_time->pivot->empates}}</td>
      		               	<td>{{$liga_time->pivot->derrotas}}</td>
      		               	<td>{{$liga_time->pivot->jogos}}</td>
      	  										               
      	            	</tr>
      				@endforeach
      			</tbody>
      		</table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>
    
<modal  nome="adicionar-lista" titulo="Adicionar na lista">
	<form-lista id='form-add-lista' token="{{ csrf_token() }}" url_lista="{{route('listas')}}"></form-lista>
    <span slot="botoes">
        <button form="form-add-lista" class="btn btn-info">Adicionar</button>
    </span>
</modal> 

<!--<modal-link tipo="button" nome="adicionar-gestao" icone="fa fa-plus" css="btn btn-info" titulo="Adicionar a gestão" item="{{$jogo->id}}" url="{{route('gestao.estrategias')}}"></modal-link>-->
<modal  nome="adicionar-gestao" titulo="⛳️ Adicionar a GESTÃO">
	<form-add-gestao id='form-add-gestao' token="{{ csrf_token() }}" url_gestao="{{route('gestao')}}" entrada="{{auth()->user()->gestao->stake}}"></form-add-gestao>
    <span slot="botoes">
        <button form="form-add-gestao" class="btn btn-info">Adicionar</button>
    </span>
</modal>

@stop
