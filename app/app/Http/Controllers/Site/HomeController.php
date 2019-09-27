<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Liga;
use App\Models\Time;
use Illuminate\Cookie\CookieJar;
use Cookie;

class HomeController extends Controller
{
    public function index($id = null)
    {	
        if($id != null){
            //salva no navegador por 30 dias
            
           setcookie('afiliado_id',$id,time()+60*60*24*30,'/');
           
        }

    	return view('site.home.index',compact('id'));
    }

   
}
