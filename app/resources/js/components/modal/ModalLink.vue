<template>
	<span>
		<span v-if="item && !dado_id">
			<button @click="preencherFormulario" v-if="tipo == 'button'" type="button" :class="css || 'btn btn-primary'" data-toggle="modal" :data-target="'#'+ nome"><i v-if="icone" :class="icone"></i> {{titulo}}</button>
		    <button @click="preencherFormulario" v-if="!tipo || (tipo != 'button' && tipo != 'link')" type="button" :class="css || 'btn btn-primary'" data-toggle="modal" :data-target="'#'+ nome"><i v-if="icone" :class="icone"></i> {{titulo}}</button>
		    <a @click="preencherFormulario" v-if="tipo == 'link'" href="#" :class="css || ''" data-toggle="modal" :data-target="'#'+ nome"><i v-if="icone" :class="icone"></i> {{titulo}}</a>

	    </span>
		<span v-if="!item && !dado_id">
			<button v-if="tipo == 'button'" type="button" :class="css || 'btn btn-primary'" data-toggle="modal" :data-target="'#'+ nome"><i v-if="icone" :class="icone"></i> {{titulo}}</button>
		    <button v-if="!tipo || (tipo != 'button' && tipo != 'link')" type="button" :class="css || 'btn btn-primary'" data-toggle="modal" :data-target="'#'+ nome"><i v-if="icone" :class="icone"></i> {{titulo}}</button>
		    <a v-if="tipo == 'link'" href="#" :class="css || ''" data-toggle="modal" :data-target="'#'+ nome"><i v-if="icone" :class="icone"></i> {{titulo}}</a>
	    </span>
        <span v-if="dado_id && !item">
            <button @click="carregarDados" v-if="tipo == 'button'" type="button" :class="css || 'btn btn-primary'" data-toggle="modal" :data-target="'#'+ nome"><i v-if="icone" :class="icone"></i> {{titulo}}</button>
            <button @click="carregarDados" v-if="!tipo || (tipo != 'button' && tipo != 'link')" type="button" :class="css || 'btn btn-primary'" data-toggle="modal" :data-target="'#'+ nome"><i v-if="icone" :class="icone"></i> {{titulo}}</button>
            <a @click="carregarDados" v-if="tipo == 'link'" href="#" :class="css || ''" data-toggle="modal" :data-target="'#'+ nome"><i v-if="icone" :class="icone"></i> {{titulo}}</a>
        </span>
	</span>
    
</template>

<script>
    export default {
        props:['tipo','nome','titulo','css','item','dado_id','url','icone'],
        methods:{
        	preencherFormulario () {
        		this.$store.dispatch('getLista',this.url);
        		this.$store.commit('SET_ITEM',this.item);
        	},
            carregarDados: function(){
                this.$store.commit('SET_ITEM',this.dado_id);
            }
        }
    }
</script>
