export default{
	state: {
		listas:[],
		item:''
	},
	mutations: {
		SET_LISTA(state,obj){
			state.listas = obj;
		},
		SET_ITEM(state,obj){
			state.item = obj;
		}
	},
	actions: {
		getLista(context,url){
			axios.get(url).then(res => {
	        	context.commit('SET_LISTA',res.data);
	        })
	    },		
	},
	getters: {
		
	}
}