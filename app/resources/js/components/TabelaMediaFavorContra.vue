<template>
	<div class="progress-group">
	    <span class="progress-text"><h3>{{titulo}}</h3></span>
	    <span class="progress-number"><b>{{jogo[estrategia]}}%</b></span>
	    <div class="progress sm">
	      <div class="progress-bar progress-bar-green" :style="'width:'+ jogo[estrategia]+'%'"></div>
	    </div>
	    <table class="table table-bordered">
	    	<thead>
	    		<th>Time</th>
	    		<th>Media Favor</th>
	    		<th>Media Contra</th>
	    		<th>Total</th>
	    		<th>Nº Vezes</th>
	    		<th>%</th>
	    	</thead>
	    	<tbody>
	    		<tr class="info">
	        		<td>{{jogo['time_casa']['nome']}}</td>
	        		<td>{{jogo[estrategia+'_media_favor_casa']}}</td>
	        		<td>{{jogo[estrategia+'_media_contra_casa']}}</td>
	        		<td>{{ total_casa }}</td>
	        		<td>{{ parseInt(jogo[estrategia+'_casa'])/100 * parseInt(jogo['n_jogos_casa']) }}</td>
	        		<td>{{jogo[estrategia+'_casa']}}%</td>
	    		</tr>
	    		<tr class="active">
	        		<td>{{jogo['time_fora']['nome']}}</td>
	        		<td>{{jogo[estrategia+'_media_favor_fora']}}</td>
	        		<td>{{jogo[estrategia+'_media_contra_fora']}}</td>
	        		<td>{{total_fora}}</td>
	        		<td>{{ parseInt(jogo[estrategia+'_fora'])/100 * parseInt(jogo['n_jogos_fora']) }}</td>
	        		<td>{{jogo[estrategia+'_fora']}}%</td>
	    		</tr>
	    	</tbody>
	    </table>
	</div>
</template>

<script>
	export default{
		props:['estrategia','jogo','titulo'],
		computed:{
			total_casa: function(){
				var media_favor = this.jogo[this.estrategia+'_media_favor_casa'];
				var media_contra = this.jogo[this.estrategia+'_media_contra_casa']
				return  (parseFloat(media_favor) + parseFloat(media_contra)).toFixed(2);
			},
			total_fora: function(){
				var media_favor = this.jogo[this.estrategia+'_media_favor_fora'];
				var media_contra = this.jogo[this.estrategia+'_media_contra_fora']
				return  (parseFloat(media_favor) + parseFloat(media_contra)).toFixed(2);
			}
		}
	}
</script>