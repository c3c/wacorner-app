export default{
	state: {
		estrategias:[],
		jogo:0,
		stake:0,
		banca_inicial:0,
		banca_final:0,
		lucro:0,
		valor_investido:0,
		entradasPendentes:[],
		roi:0,
	},
	mutations: {
		SET_LISTA(state,obj){
			state.estrategias = obj;
		},
		SET_ENTRADAS_PENDENTES(state,obj){
			state.entradasPendentes = obj;
		},
		SET_ITEM(state,obj){
			state.jogo = obj;
		},
		SET_STAKE(state,obj){
			state.stake = obj;
		},
		SET_VALOR_INVESTIDO(state,obj){
			state.valor_investido = obj;
		},
		SET_ROI(state,obj){
			state.roi = obj;
		},
		SET_LUCRO(state,obj){
			state.lucro = obj;
		},
		SET_BANCA_INICIAL(state,obj){
			state.banca_inicial = obj;
		},
		SET_BANCA_FINAL(state,obj){
			state.banca_final = obj;
		},
		DELETE_ENTRADA(state,obj){
			var index = state.entradasPendentes.findIndex( res => res.id == obj);
			state.entradasPendentes.splice(index,1);
		}
	},
	actions: {
		getLista(context,url){
			axios.get(url).then(res => {
	        	context.commit('SET_LISTA',res.data);
	        })

	    },
	    getGestao(context){
	    	axios.get('./gestao/show').then( res => {
	    		context.commit('SET_BANCA_INICIAL',res.data.banca_inicial);
	    		context.commit('SET_BANCA_FINAL',res.data.banca_inicial + res.data.lucro);
	    		if(res.data.valor_investido == 0){
	    			context.commit('SET_ROI',0);
	    			context.commit('SET_VALOR_INVESTIDO',0);	
	    		}else{
	    			context.commit('SET_ROI',res.data.lucro/res.data.valor_investido*100);
	    			context.commit('SET_VALOR_INVESTIDO',res.data.valor_investido);
	    		}
	    		context.commit('SET_LUCRO',res.data.lucro);
	    		context.commit('SET_STAKE',res.data.stake);
	    	});

	    },
	    getEntradasPendentes(context){
	    	axios.get('./gestao/entradas/pendentes').then( res => {
	    		context.commit('SET_ENTRADAS_PENDENTES',res.data);
	    	});
	    },
	    updateResultado(context,params){
	    	axios.put('./gestao/entrada/update', params).then( res => {
	    		context.commit('SET_BANCA_INICIAL',res.data.banca_inicial);
	    		context.commit('SET_BANCA_FINAL',res.data.banca_inicial + res.data.lucro);
	    		if(res.data.valor_investido == 0){
	    			context.commit('SET_ROI',0);	
	    			context.commit('SET_VALOR_INVESTIDO',0);
	    		}else{
	    			context.commit('SET_ROI',res.data.lucro/res.data.valor_investido*100);
	    			context.commit('SET_VALOR_INVESTIDO',res.data.valor_investido);
	    		}
	    		context.commit('SET_LUCRO',res.data.lucro);
	    		context.dispatch('getEntradasPendentes');
	    		swal ( "Sucesso..." ,  "Sua entrada foi computada com sucesso!" , "success" );
	    	});
	    },
	    excluirEntrada(context,id){
	    	axios.get('./gestao/entrada/excluir/'+id).then( res => {
	    		this.dispatch('getGestao');
	    		this.dispatch('getEntradasPendentes');
	    		swal("Sucesso...", res.data.resultado,"success");
	    	});
	    }
	},
	getters: {
		
	}
}