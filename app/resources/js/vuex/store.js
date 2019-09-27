import Vue from 'vue'
import Vuex from 'vuex'
import Notifications from './modules/notifications/index'
import Listas from './modules/listas/index'
import Gestoes from './modules/gestao/index'

Vue.use(Vuex)

export default new Vuex.Store({
	modules: {
		Notifications,
		Listas,
		Gestoes
	}
})

