export default{
	state: {
		itens: []
	},
	mutations: {
		LOAD_NOTIFICATIONS(state,notifications){
			state.itens = notifications
		},
		MARK_AS_READ_ALL(state){
			state.itens = []
		}
	},
	actions: {
		loadNotifications(context,url){
			axios.get(url).then(response => {
				context.commit('LOAD_NOTIFICATIONS',response.data.notifications);
			});
		},
		markAsReadAll(context,url){
			axios.put(url+'/mark-as-read-all');
			context.commit('MARK_AS_READ_ALL');
			swal ( "Sucesso..." ,  "Notificações limpadas!" , "success" );
		}
	},
	getters: {
		
	}
}