if (!("Notification" in window)) {
    console.log("Este browser não suporta notificações de Desktop");
}else{
    Notification.requestPermission().then(status => {
        if (status == 'granted') {
            console.log('permissão concedida');

        }else{
            // pode ser default, ou denied
            console.log(status);
        }
    });

    // import store from './vuex/store'
    Echo.private("App.User."+window.Laravel.user+"")
    		.notification( e => {
    			axios.post(window.Laravel.url_inicial+'/admin/lista-jogo', {
                        jogo: e.jogo_id,
                        lista: e.lista.id
                    })
                    .then(function (response) {
                       	if(response.data.existe){
                       		Notification.requestPermission().then(status => {
    						    if (status == 'granted') {
    						        console.log('permissão concedida');
    						    
    						        var n = new Notification(e.time_casa+" x "+e.time_fora, {
    				                    // use \n para quebrar linhas
    				                    body: "Lista: "+e.lista.nome+"\nJá vai começar!",
    				                     // opcional
    				                    icon: window.Laravel.url_inicial+'/assets/images/icone_notification_inicio_do_jogo.png'
    				                });
    						    }
    						});
                       	}
                    })
                    .catch(function (error) {
                    });
    			
    		})
}