<?php

$this->get('/telegram','Admin\BotTelegramController@index');
$this->post('/telegram/webhook','Admin\BotTelegramController@getWebhook');

/****************************************************************************************/

//								GESTÃO DE BANCA 										//

/****************************************************************************************/

//PRECISA ESTAR LOGADO E A DATA DE EXPIRAÇÃO MAIOR OU IGUAL A DE HOJE
$this->group(['middleware' => ['auth','ativo','auth.unique.user'], 'namespace' => 'Gestao','prefix'=>'admin'],function()
{

	//ESTRATEGIAS REGISTRADAS PARA GESTÂO
	$this->get('/gestao/estrategias/','EstrategiaController@estrategias')->name('gestao.estrategias');
	$this->get('/gestao/estrategias/show','EstrategiaController@show')->name('gestao.estrategias.show');
	$this->get('/gestao/estrategias/new','EstrategiaController@new')->name('gestao.estrategias.new');
	$this->post('/gestao/estrategias/create','EstrategiaController@create')->name('gestao.estrategias.create');
	$this->post('/gestao/estrategias/update','EstrategiaController@update')->name('gestao.estrategias.update');
	$this->get('/gestao/estrategias/edit/{id}','EstrategiaController@edit')->name('gestao.estrategias.edit');
	$this->get('/gestao/estrategias/delete/{id}','EstrategiaController@delete')->name('gestao.estrategias.delete');

	//GESTÂO
	$this->get('/gestao','GestaoController@index')->name('gestao');
	$this->get('/gestao/show','GestaoController@show')->name('gestao.show');
	$this->post('/gestao/update','GestaoController@update')->name('gestao.update');
	

	//ENTRADA REGISTRADAS PARA GESTÃO
	$this->post('/gestao/entrada/criar','EntradaController@criar')->name('gestao.entrada.criar');
	$this->get('/gestao/entradas/pendentes','EntradaController@entradasPendentes');
	$this->put('/gestao/entrada/update','EntradaController@updateResultado');
	$this->get('/gestao/entrada/excluir/{id}','EntradaController@excluir')->name('gestao.entradas.excluir');
	$this->get('/gestao/entrada/excluir-all','EntradaController@excluirAll')->name('gestao.entradas.excluir.tudo');
	$this->get('/gestao/entradas/', 'EntradaController@index')->name('gestao.entradas.index');

});

//PRECISA ESTAR LOGADO E A DATA DE EXPIRAÇÃO MAIOR OU IGUAL A DE HOJE
$this->group(['middleware' => ['auth','ativo','auth.unique.user'], 'namespace' => 'Admin','prefix'=>'admin'],function(){

	//ROBÔ
	Route::resource('robos', 'RoboController');
	$this->get('/robos/{id}/alterar/status','RoboController@alterarStatus')->name('robos.alterar.status');
	$this->get('/robos/{nome}/create','RoboController@create')->name('robos.create.nome');
	$this->get('/robos/jogos/notificados','RoboController@notificacoes')->name('robos.notificacoes');
	$this->get('/robos/{id}/desconectar','RoboController@desconectar')->name('robos.desconectar');
	$this->get('/robos/jogos/notificados/delete/all','RoboController@excluirTodasNotificacoes')->name('robos.notificacoes.delete.all');
	$this->get('/robos/jogos/notificados/delete/{id}','RoboController@excluirNotificacao')->name('robos.notificacoes.delete.id');
	

	//MINHAS LISTAS
	$this->get('/lista','ListaController@index')->name('lista');
	$this->get('/listas','ListaController@listas')->name('listas');
	$this->post('/lista-jogo','ListaController@listaJogo')->name('lista.jogo');
	$this->post('/listas/new','ListaController@new')->name('lista.new');
	$this->get('/listas/delete/{id}','ListaController@delete')->name('lista.delete');
	$this->get('/listas/limpar/{id}','ListaController@limpar')->name('lista.limpar');
	$this->get('/listas/delete/{id_lista}/{id_jogo}','ListaController@deleteJogo')->name('lista.delete.jogo');
	$this->post('/listas/jogo/add','ListaController@jogo_add')->name('lista.jogo.add');

	//Jogos de hoje
	$this->get('/','AdminController@index')->name('admin.home');
	$this->get('/jogos/{data}','AdminController@jogos')->name('admin.jogos.data');

	//Jogos ao vivo
	$this->get('/live','AdminController@live')->name('admin.live');
	$this->get('/jogos-ao-vivo','AdminController@jogosAoVivo')->name('admin.jogos.aovivo');
	$this->get('/live/search','AdminController@liveSearch')->name('admin.live.search');
	
	//Over ligas
	$this->get('/over/ligas','EstatisticasController@lista_over_liga')->name('admin.over.ligas');
	
	//Over times
	$this->get('/over/times','EstatisticasController@lista_over_time')->name('admin.over.times');
	
	//Jogos de amanhã
	$this->get('/amanha','AdminController@index_amanha')->name('admin.amanha');
	
	//Jogo especifico
	$this->get('/jogo/{id}','JogoController@index')->name('admin.jogo');
	
	//End point - Jogos por estrategia e data - SEM FILTROS
	$this->get('/jogos/{estrategia}/{data}','AdminController@jogosEstrategia')->name('admin.jogos.estrategia');

	//End point - Jogos por estrategia e data - COM FILTROS
	$this->get('/jogos/{estrategia}/{data}/{min_jogos}/{porcentagem}','AdminController@jogosEstrategiaFiltro')->name('admin.jogos.estrategia.filtro');

	//Lista jogos por estrategia e data
	$this->get('/jogos/index/{estrategia}/{data}','AdminController@indexEstrategia')->name('admin.estrategia');



	//End point - Jogos por estatistica e data
	$this->get('/jogos-estatistica/{estatistica}/{data}','EstatisticasController@jogosEstatisticas')->name('admin.jogos.estatistica');

	//Lista jogos por estrategia e data
	$this->get('/jogos-estatistica/index/{estatistica}/{data}','EstatisticasController@index')->name('admin.estatistica');	
});

//SÓ PRECISA ESTAR LOGADO PARA ACESSAR
$this->group(['middleware' => ['auth','auth.unique.user'], 'namespace' => 'Admin','prefix'=>'admin'],function(){
	//SAQUES
	$this->get('/saque/cupon/{user_id}','SaqueController@index_cupon')->name('saque.index');
	$this->post('/saque/store','SaqueController@store')->name('saque.store');
	$this->get('/saque/delete/{id}','SaqueController@delete')->name('saque.delete');
	$this->get('/saque/pendentes','SaqueController@pendentes')->name('saque.pendentes');
	$this->get('/saque/confirmar/{id}','SaqueController@confirmar_saque')->name('saque.confirmar');

	//INDICADOS
	$this->get('/indicados/','IndicadoController@index')->name('indicados');
	$this->get('/indicados/{id}','IndicadoController@show')->name('indicados.show');
	

	//CUPONS DOS USUARIOS PARCEIROS
	$this->get('/cupon/user','CuponController@index_user')->name('cupon.user');
	$this->get('/cupon/relatorio/{id}','CuponController@relatorio')->name('cupon.relatorio');
	$this->post('/cupon/relatorio/search','CuponController@relatorio_search')->name('cupon.relatorio.search');

	$this->any('/venda/compra', 'VendaController@compra')->name('venda.compra');
	$this->get('/venda', 'VendaController@index')->name('venda');
	$this->get('/venda/expirado', 'VendaController@expirado')->name('venda.expirado');
	$this->get('/venda/paypal/{plano}', 'VendaController@index_paypal')->name('venda.paypal.new');
	$this->get('/venda/paypal/', 'VendaController@index_paypal')->name('venda.paypal');
	$this->get('/venda/transferencia/', 'VendaController@index_transferencia')->name('venda.transferencia');
	$this->get('/venda/picpay/', 'VendaController@index_picpay')->name('venda.picpay');
	$this->get('/venda/cupom/promocional', 'VendaController@index_cupom')->name('venda.cupom');
	$this->post('/venda/cupom/promocional/validar', 'VendaController@index_cupom_validar')->name('venda.cupom.validar');
	$this->post('/venda/cupom/desconto/validar', 'VendaController@cupom_desconto_validar')->name('venda.cupom.desconto.validar');
	$this->get('/venda/show', 'VendaController@show')->name('venda.show');
	$this->get('/venda/show/{id}', 'VendaController@show')->name('venda.show.user');
	$this->get('/venda/delete/{id}', 'VendaController@delete')->name('venda.delete');
	$this->get('/venda/obrigado/{tipo}', 'VendaController@obrigado')->name('venda.obrigado');
	
	$this->get('/usuario/perfil','UserController@perfil')->name('usuario.perfil');
	$this->post('/usuario/update','UserController@perfilUpdate')->name('usuario.perfil.update');

	//Descrição das estrategias
	$this->get('/estrategias','AdminController@estrategias')->name('admin.estrategias');

	//Notifications
	$this->get('notifications','NotificationController@notifications')->name('notifications');
	$this->get('notification','NotificationController@notification')->name('notification');
	$this->post('notification/send','NotificationController@send')->name('notification.send');
	$this->put('notifications/mark-as-read-all','NotificationController@markAsReadAll');

});

//SOMENTE ADMINISTRADORES
$this->group(['middleware' => ['auth','is_admin','auth.unique.user'], 'namespace' => 'Admin','prefix'=>'admin'],function(){
	
	//VENDAS
	$this->post('/venda/relatorio', 'VendaController@search')->name('venda.show.search');

	//USUARIOS
	$this->get('/usuario','UserController@show')->name('usuario');
	$this->get('/usuario/{email}/{plano}','VendaController@planoAdd')->name('usuario.plano');
	$this->get('/usuario/cancelar/{email}/{plano}','UserController@planoCancelar')->name('usuario.plano.cancelar');
	$this->any('/usuario/search','UserController@search')->name('usuario.search');
	$this->any('/usuario/add/dias','UserController@addDias')->name('usuario.add.dias');
	//LIGAS
	$this->get('/liga','LigaController@index')->name('liga');
	$this->get('/liga/ativar/{id}','LigaController@ativar')->name('liga.ativar');
	$this->any('/liga/search','LigaController@search')->name('liga.search');
	//CUPONS
	$this->get('/cupon','CuponController@index')->name('cupon');
	$this->post('/cupon/store','CuponController@store')->name('cupon.store');
	$this->get('/cupon/delete/{id}','CuponController@delete')->name('cupon.delete');
	$this->get('/cupon/delete/users/{id}','CuponController@deleteUsers')->name('cupon.delete.users');

	//LIBERAR PLANO
	$this->get('/venda/liberar/{id}','VendaController@liberar_plano')->name('venda.liberar');

});

//Pagina incial
$this->get('afi/{id}', 'Site\HomeController@index')->name('afiliado');
$this->get('/', 'Site\HomeController@index')->name('home');

//Receber notificacoes da API do pagseguro
$this->post('/venda/pagseguro', 'Admin\VendaController@status')->name('venda.pagseguro');
$this->get('/venda/pagseguro', 'Admin\VendaController@status')->name('venda.pagseguro');

//Atualizar os jogos
$this->get('/update', 'UpdateController@all');
$this->get('/update/bot_lista', 'UpdateController@listaJogosBot');

//Todas as rotas do login
Auth::routes();


