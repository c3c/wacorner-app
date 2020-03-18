<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram;
use TelegramResponseException;
use Storage;
use App\User;
class BotTelegramController extends Controller
{
    public function index()
    {

		//$response  =  Telegram::getUpdates();
		//dd($response);
    }

    public function getWebhook(){
    	$updates = Telegram::getWebhookUpdates();
    	$msg_aux =json_decode($updates->getMessage());
    	//Storage::append('arquivo.txt', $msg_aux );    	
    	if(isset($msg_aux->text)){
    		    	if(strpos($msg_aux->text,'start')!= false){
    		    		$msg = explode(' ',$msg_aux->text);
    			    	if(isset($msg[1])){
    				    	$id_usuario = intval($msg[1]);
    				    	$usuario = User::find($id_usuario);
    				    	$usuario->telegram_chat_id = $updates->getMessage()->getChat()->getId();
    				    	$usuario->save();

    				    	$usuario->sendMenssageTelegram(
    				    		$updates->getMessage()->getChat()->getId(),
    				    		'Olá '.$usuario->nome.' agora você está habilitado para receber mensagens dos nossos Robôs🤖'
    				    	);
    				    	
    			    	}
    			    	

    				}else{
    					if(strpos($msg_aux->text,'@') != false){
    				    	$usuario = User::where('email',$msg_aux->text)->first();
    				    	if($usuario != null){
    				    	$usuario->telegram_chat_id = $updates->getMessage()->getChat()->getId();
    				    	$usuario->save();
    				    	$usuario->sendMenssageTelegram(
    				    		$updates->getMessage()->getChat()->getId(),
    				    		'Olá '.$usuario->nome.' agora você está habilitado para receber mensagens dos nossos Robôs🤖'
    				    	);
    				    	
    				    	}else{
    				    		$usuario = User::find(1);
    				    		$usuario->sendMenssageTelegram(
    					    		$updates->getMessage()->getChat()->getId(),
    					    		'Esse email não existe na nossa plataforma.'
    				    		);
    				    		
    				    	}
    					}
    				}
    	}
	    	
		
    	return 'ok';
	} 
	
}
