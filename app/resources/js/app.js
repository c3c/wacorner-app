require('./bootstrap');

window.Vue = require('vue');

import store from './vuex/store'


//COMPONENTES GERAIS
Vue.component('update', require('./components/UpdateJogosAoVivo.vue'));
Vue.component('tabela-principal', require('./components/TabelaPrincipal.vue'));
Vue.component('tabela-estatisticas', require('./components/TabelaEstatisticas.vue'));
Vue.component('tabela-ao-vivo', require('./components/TabelaAoVivo.vue'));
Vue.component('tabela-porcentagem', require('./components/TabelaPorcentagem.vue'));
Vue.component('tabela-media-favor-contra', require('./components/TabelaMediaFavorContra.vue'));
Vue.component('gestao', require('./components/Gestao.vue'));

//MODAIS
Vue.component('modal', require('./components/modal/Modal.vue'));
Vue.component('modal-link', require('./components/modal/ModalLink.vue'));

//FORMULARIOS
Vue.component('form-lista', require('./components/forms/FormLista.vue'));
Vue.component('form-config-gestao', require('./components/forms/FormConfigGestao.vue'));
Vue.component('form-add-dias', require('./components/forms/FormAddDias.vue'));
Vue.component('form-add-gestao', require('./components/forms/FormGestao.vue'));
Vue.component('form-pagseguro', require('./components/forms/FormPagseguro.vue'));
Vue.component('form-paypal', require('./components/forms/FormPayPal.vue'));

//GRAFICOS
Vue.component('grafico', require('./components/graficos/Grafico.vue'));

//NOTIFICATIONS
Vue.component('notifications', require('./components/notifications/Notifications.vue'));
Vue.component('notification', require('./components/notifications/Notification.vue'));

const app = new Vue({
    el: '#app',
    store
});
