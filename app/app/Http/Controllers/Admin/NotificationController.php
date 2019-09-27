<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotificacaoAleatoria;
use App\User;

class NotificationController extends Controller
{
    
    public function __construct(){
    	$this->middleware('auth');
    }

    public function notification(){
        return view('admin.notifications.notification');
    }

    public function send(Request $request){
        if($request->destinatario == 'ativos'){

            $usuarios = User::whereDate('data_expiracao','>=',date('Y-m-d'))->get();
        }else if($request->destinatario == 'inativos'){
            $usuarios = User::whereDate('data_expiracao','<',date('Y-m-d'))->get();
        }else{
            $usuarios = User::all();
        }
        
        Notification::send($usuarios,new NotificacaoAleatoria($request->icone,$request->titulo,$request->texto,$request->url,$request->url_texto));

        return back()->with('success','Notificação enviada!');
    }

    public function notifications(Request $request){
    	$notifications = $request->user()->unreadNotifications;

    	return response()->json(compact('notifications'));
    }

    public function markAsReadAll(Request $request){
    	$notification =  $request->user()->unreadNotifications->markAsRead();
    }

}
