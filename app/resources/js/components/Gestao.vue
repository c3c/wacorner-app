<template>
	<div>
	    <section class="content">
	      <!-- Small boxes (Stat box) -->
	      	<div class="row">
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-aqua">
		            <div class="inner">
		              <h3>R$ {{$store.state.Gestoes.banca_inicial | arredondar}}</h3>

		              <p>BANCA INICIAL</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-dollar"></i>
		            </div>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div :class="{'small-box bg-green': $store.state.Gestoes.roi>=0, 'small-box bg-red': $store.state.Gestoes.roi<0}">
		            <div class="inner">
		              <h3>{{$store.state.Gestoes.roi | arredondar}}<sup style="font-size: 20px">%</sup></h3>

		              <p>ROI</p>
		            </div>
		            <div class="icon">
		              %
		            </div>
		          </div>
		        </div>
		        <!-- ./col -->
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div :class="{'small-box bg-green': $store.state.Gestoes.lucro>=0, 'small-box bg-red': $store.state.Gestoes.lucro<0}">
		            <div class="inner">
		              <h3>R$ {{$store.state.Gestoes.lucro | arredondar}}</h3>

		              <p>LUCRO</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-line-chart"></i>
		            </div>
		        	</div>
	        	</div>
		        <div class="col-lg-3 col-xs-6">
		          <!-- small box -->
		          <div class="small-box bg-aqua">
		            <div class="inner">
		              <h3>R$ {{$store.state.Gestoes.banca_final | arredondar}}</h3>

		              <p>BANCA FINAL</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-dollar"></i>
		            </div>
		          </div>
		        </div>
		        <!-- ./col -->
	    	</div>
		</section>
		<hr>
		<section class="content">
			<h4><i class="fa fa-refresh"></i> Apostas Pendentes</h4>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Liga</th>
						<th>Jogo</th>
						<th>Stake</th>
						<th>Odd</th>
						<th>Estratégia</th>
						<th>Resultado</th>
						<th>Excluir</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="entrada in $store.state.Gestoes.entradasPendentes">
						<td>{{entrada.jogo.liga.l}}</td>
						<td>{{entrada.jogo.time_casa.nome}} x {{entrada.jogo.time_fora.nome}}</td>
						<td>R$ {{entrada.stake | arredondar}}</td>
						<td>{{entrada.odd | arredondar}}</td>
						<td>{{entrada.estrategia.nome}}</td>
						<td><button @click.prevent="setResultado(entrada.id,'green')" class="btn btn-success btn-xs"><i class="fa fa-thumbs-o-up"></i> GREEN</button> | <button @click.prevent="setResultado(entrada.id,'neutro')" class="btn btn-primary btn-xs"><i class="fa fa-refresh"></i> NEUTRO</button> | <button @click.prevent="setResultado(entrada.id,'red')" class="btn btn-danger btn-xs"><i class="fa fa-thumbs-o-down"></i> RED</button></td>
						<td><button @click.prevent="excluirEntrada(entrada.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button></td>
					</tr>
				</tbody>
			</table>
		</section>
	</div> 
</template>

<script>
	export default{
		mounted(){
			this.$store.dispatch('getGestao');
			this.$store.dispatch('getEntradasPendentes');
		},
		props:[],
		filters: {
			arredondar: function (value) {
				return parseFloat(value).toFixed(2);
			},
		},
		methods:{
			setResultado(id,resultado){
				this.$store.dispatch('updateResultado',{id: id, resultado: resultado});
			},
			excluirEntrada(id){
				this.$store.dispatch('excluirEntrada',id);
			}
		}
	}
</script>