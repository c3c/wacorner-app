<template>
	<div>
		<div class="box-header">
			<div class="row">
				<div class="col-md-2">
					<h3 class="box-title"><i class="fa fa-dashboard"></i> Jogos Ao Vivo</h3>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label> Escolha a estrategia e a porcentagem:</label>
						<select id="estrategia" class="form-control" v-model="estrategia">
							<option value="">Escolha uma estratégia</option>
							<option value="ht1020">Estratégia 10 a 20min HT</option>
							<option value="ht35">Estratégia HT35</option>
							<option value="ht38">Estratégia HT38</option>
							<option value="ft75">Estratégia FT75</option>
							<option value="ft82">Estratégia FT82</option>
							<option value="ft88">Estratégia FT88</option>
						</select>
						<div class="slidecontainer">
						  <input type="range" min="0" max="99" v-model="porcentagem" class="slider" id="myRange">
						  <p>Jogos acima de : {{porcentagem}} %</p>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<label for="title"> Min. de jogos ant. por time</label>
					<select name="n_jogos" id="n_jogos" class="form-control" v-model="n_jogos">
						<option value="">-</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
					</select>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="title"> Buscar time ou liga</label>
                  		<input type="text" placeholder="Nome do time ou liga" v-model="buscar" class="form-control">
              		</div>
              	</div>
			</div>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table-striped table">
				            <thead>
				              	<tr>
				              		<th>Gestão</th>
				              		<th>Liga</th>
				              		<th><i class="fa fa-flag" title="Cantos Realizados"></i></th>
                                    <th><i class="fa fa-clock-o" title="Tempo de Jogo"></i></th>
				              		<th><i class="fa fa-rocket"></i> APPM</th>
				                  	<th>Jogo<small>(Resultado)</small></th>
                                    <th><i class="fa fa-rocket"></i> APPM</th>
				                  	<th>HT1020</th>
				                  	<th>HT35</th>
				                  	<th>HT38</th>
				                  	<th>FT75</th>
				                  	<th>FT82</th>
				                  	<th>FT88</th>
				                  	<th>Média Total</th>
				                </tr>
				            </thead>
							<tbody>
								<h2 v-if="lista == null"> SEM JOGOS AO VIVO!</h2>
				                <tr style="height: 20px;" v-for="live in lista">
				                  <td><modal-link tipo="button" nome="adicionar-gestao" icone="fa fa-usd" css="btn btn-info" :item="live.jogo.id" :url="url_gestao"></modal-link></td>
			                      <td><span v-if="buscaJogoNaLista(live)" class="fa fa-star"></span> {{live.jogo.liga.l}}</td>
			                      <td>{{live.c_casa}} - {{live.c_fora}}</td>
			                      <td>
			                      	<button class="btn btn-xs btn-primary flash" v-if="live.tempo == 'half'"> HT </button>
			                      	<button class="btn btn-xs btn-primary flash" v-if="live.tempo != 'half'"> {{live.tempo}} </button>
                          		  </td>
                                  <td><strong>{{appm_casa(live)}}</strong></td>
                          		  <td>
			                          <strong>
			                            <!-- <a style="color: #000;" :href="'jogo/'+live.jogo.id" target="_blank">
			                              <span  v-if="live.superioridade[1] == 'fora' || admin != 1">{{live.jogo.time_casa.nome}}</span>
			                               <button class="btn btn-xs btn-success" v-if="live.superioridade[1] == 'casa' && admin == 1">{{live.jogo.time_casa.nome}}<span>({{live.odds | favoritoCasa}})</span>  ({{live.superioridade[0]}}%)</button>
			                              <button class="btn btn-xs btn-danger">{{live.eventos_gols | golsCasa}}</button>
			                              x
			                              <button class="btn btn-xs btn-danger">{{live.eventos_gols | golsFora}}</button>
			                              <span  v-if="live.superioridade[1] == 'casa' || admin != 1">{{live.jogo.time_fora.nome}}</span>
			                               <button class="btn btn-xs btn-success" v-if="live.superioridade[1] == 'fora'  && admin == 1"> {{live.jogo.time_fora.nome}}<span>({{live.odds | favoritoFora}})</span>  ({{live.superioridade[0]}}%)</button>
			                            </a> -->

			                            <a style="color: #000;" :href="'jogo/'+live.jogo.id" target="_blank">
			                               <button class="btn btn-xs btn-info" v-if="favorito(live) == 'casa'">{{live.odds | favoritoCasa}}</button>
			                               <button class="btn btn-xs btn-success" v-if="live.superioridade[1] == 'casa'">  {{live.superioridade[0]}} %</button>
			                               {{live.jogo.time_casa.nome}}
			                              <button class="btn btn-xs btn-danger">{{live.eventos_gols | golsCasa}}</button>
			                              x
			                              <button class="btn btn-xs btn-danger">{{live.eventos_gols | golsFora}}</button>
			                              {{live.jogo.time_fora.nome}} <button class="btn btn-xs btn-info" v-if="favorito(live) == 'fora'">{{live.odds | favoritoFora}}</button>
			                               <button class="btn btn-xs btn-success" v-if="live.superioridade[1] == 'fora'">  {{live.superioridade[0]}} %</button>
			                            </a>
			                          </strong>
			                          <div class="progress" style=" position: relative; width:90%;">
			                            <div class="progress-bar progress-bar-primary" v-if="live.tempo == 'half'" role="progressbar" style="width:45%; position: absolute; height: 50%; margin-top: 10px;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
			                            </div>
			                            <div class="progress-bar progress-bar-primary" v-if="live.tempo != 'half'" role="progressbar" :style="'width:'+parseInt(live.tempo)+'%; position: absolute; height: 50%; margin-top: 10px;'" :aria-valuenow="parseInt(live.tempo)" aria-valuemin="0" aria-valuemax="100">
			                            </div>

			                            <span v-if="live.eventos" v-for='evento in live.eventos'>
			                            	<img v-if='evento.casa == 1' :src="url_assets+'/corner-home.png'" :title="evento.t+' - '+live.jogo.time_casa.nome" :style="'position: absolute; left: '+evento.t+'%; width: 20px;'">
			                            	<img v-if='evento.casa == 0' :src="url_assets+'/corner-aways.png'" :title="evento.t+' - '+live.jogo.time_fora.nome" :style="'position: absolute; left: '+evento.t+'%; width: 20px;'">
           		                        </span>

			                          </div>
			                          <div class="progress-bar progress-bar-warning" role="progressbar" style="width:45%; height:10%; border-right:1px solid #fff;">1º Tempo</div>
			                          <div class="progress-bar progress-bar-warning" role="progressbar" style="width:45%; height:10%;">2º Tempo</div>
			                      </td>
                                  <td><strong>{{appm_fora(live)}}</strong></td>
			                      <td><span class="badge bg-green">HT1020<br>{{live.jogo.ht1020}}%</span></td>
			                      <td><span class="badge bg-green">HT35<br>{{live.jogo.ht35}}%</span></td>
			                      <td><span class="badge bg-green">HT38<br>{{live.jogo.ht38}}%</span></td>
			                      <td><span class="badge bg-green">FT75<br>{{live.jogo.ft75}}%</span></td>
			                      <td><span class="badge bg-green">FT82<br>{{live.jogo.ft82}}%</span></td>
			                      <td><span class="badge bg-green">FT88<br>{{live.jogo.ft88}}%</span></td>
			                      <td><span class="badge bg-green">FT<br>{{live.jogo.ft}} cantos</span></td>
			                    </tr>
				          	</tbody>
			        	</table>
			    	</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>

	export default{

		mounted(){
			this.$store.dispatch('getLista','listas');

			this.loadJogos();

		},
		props:['url_assets','admin','url_gestao'],
		data(){
			return {
				jogos:[],
				estrategia:'',
				porcentagem:0,
				n_jogos:1,
				buscar:'',
			}
		},
		methods:{
			loadJogos(){

				let vm = this;
				axios.get('jogos-ao-vivo').then(res => {
                	vm.jogos = res.data;
                });

                setTimeout(this.loadJogos,30000);
				// Echo.join('ao-vivo')
				// 	.here(users => {
				// 		axios.get('jogos-ao-vivo').then(res => {
    //              			vm.jogos = res.data;
    //             		});

				// 		console.log('here');
				// 		console.log(users);
				// 	})
				// 	.joining( user => {
				// 		console.log('joining');
				// 		console.log(user);
				// 	})
				// 	.leaving( user => {
				// 		console.log('leaving');
				// 		console.log(user);
				// 	})
				// 	.listen('AtualizaJogosAoVivo', e =>{

				//   		axios.get('jogos-ao-vivo').then(res => {
    //              			vm.jogos = res.data;
    //             		});


				// 	})
			},
			buscaJogoNaLista(jogo){
				return this.$store.state.Listas.listas.find(res => {
                	return res.jogos.find( res2 => {
                		if(res2.id == jogo.jogo.id){
                			return true;
                		}
                		return false;
                	});
                });
			},
            appm_casa(live) {
                if(live.tempo == "half"){
                    return (parseInt(live.ataques_perigosos[0])/45).toFixed(2);
                } else {
                    return (parseInt(live.ataques_perigosos[0])/parseInt(live.tempo)).toFixed(2);
                }
            },
            appm_fora(live) {
                if(live.tempo == "half"){
                    return (parseInt(live.ataques_perigosos[1])/45).toFixed(2);
                } else {
                    return (parseInt(live.ataques_perigosos[1])/parseInt(live.tempo)).toFixed(2);
                }
            },
			favorito(live){
				if(live.odds[0]>=live.odds[2]){
					var diferenca = live.odds[0]-live.odds[2];
			  		if(diferenca>1){
						return 'fora';
					}else{
						return '';
					}
				}else{
					var diferenca = live.odds[2]-live.odds[0];
			  		if(diferenca>1){
						return 'casa';
					}else{
						return '';
					}
				}
			}
		},
		filters: {
			golsCasa: function (value) {
				if(value){
				    var gols = value.filter( res => {
				    	return res.casa == 1;
				    })
				    return gols.length;
				}

				return 0;
			},
			golsFora: function (value) {
			    if(value){
				    var gols = value.filter( res => {
				    	return res.casa == 0;
				    })
				    return gols.length;
				}

				return 0;
			},
			favoritoCasa: function (value) {
			  	if(value[0]<=value[2]){
			  		var diferenca = value[2]-value[0];
			  		if(diferenca<=1){
			  			return '';
			  		}else if(diferenca>1 && diferenca<=3){
			  			return 'F';
			  		}else{
			  			return 'S';
			  		}
			  	}
			  	return '';
			},
			favoritoFora: function (value) {
			  	if(value[0]>value[2]){
			  		var diferenca = value[0]-value[2];
			  		if(diferenca<=1){
			  			return '';
			  		}else if(diferenca>1 && diferenca<=3){
			  			return 'F';
			  		}else{
			  			return 'S';
			  		}
			  	}
			  	return '';
			}
		},
		computed:{
			lista: function () {
				var jogos_filtrados = this.jogos;
				var vm = this;
				if(this.jogos){

				jogos_filtrados = jogos_filtrados.sort(function(a,b){
	                if(vm.buscaJogoNaLista(a) && !vm.buscaJogoNaLista(b)){
	                	return -1;
	                }
	                if(!vm.buscaJogoNaLista(a) && vm.buscaJogoNaLista(b)){
	                	return 1;
	                }
	              return 0;
	            });

				jogos_filtrados = jogos_filtrados.filter(res => {
	                if(res.jogo.liga.ativo == 1 && res.jogo.n_jogos_casa >= vm.n_jogos && res.jogo.n_jogos_fora>=vm.n_jogos){
	                	if(vm.estrategia == 'ht1020'){
	                		return (res.jogo.ht1020 >= vm.porcentagem && res.tempo<10);
	                	}
	                	if(vm.estrategia == 'ht35'){
	                		return (res.jogo.ht35 >= vm.porcentagem && res.tempo<37);
	                	}
	                	if(vm.estrategia == 'ht38'){
	                		return (res.jogo.ht38 >= vm.porcentagem && res.tempo<40);
	                	}
	                	if(vm.estrategia == 'ft75'){
	                		return (res.jogo.ft75 >= vm.porcentagem && res.tempo<80);
	                	}
	                	if(vm.estrategia == 'ft82'){
	                		return (res.jogo.ft82 >= vm.porcentagem);
	                	}
	                	if(vm.estrategia == 'ft88'){
	                		return (res.jogo.ft88 >= vm.porcentagem);
	                	}
	                	if(vm.estrategia == ''){
	                		return true;
	                	}
	                }
	            });
				}

				//FILTRO
		        if(this.buscar && this.jogos){
		            jogos_filtrados = jogos_filtrados.filter(res => {
		                if( res.jogo.time_casa.nome.toLowerCase().indexOf(this.buscar.toLowerCase())>=0 ||
		                    res.jogo.time_fora.nome.toLowerCase().indexOf(this.buscar.toLowerCase())>=0 ||
		                    res.jogo.liga.l.toLowerCase().indexOf(this.buscar.toLowerCase())>=0){
		                    return true;
		                }
		                return false;
		            });
		        }
				return jogos_filtrados;
			},
		}
	}


</script>

