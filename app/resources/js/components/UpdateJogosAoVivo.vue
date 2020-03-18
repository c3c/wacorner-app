<template>
	<div></div>
</template>
<script>
	export default{
		mounted(){
			this.loadJogos();
		},
		methods:{
			loadJogos(){
				var vm = this;
            	axios.get('.').then(res => {
                	vm.loadJogos();	                
                });

                            	
			}
		}
	}
</script>