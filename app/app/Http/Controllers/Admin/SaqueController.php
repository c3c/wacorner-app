<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Saque;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Mail\SendEmail;
use App\User;
use App\Notifications\SaquesPendentes;
use App\Notifications\ConfirmacaoSaque;


class SaqueController extends Controller
{
	private $saque;

	public function __construct(){
		$this->saque = new Saque();
	}

    public function index_cupon($user_id){
    $saques = $this->saque->where('user_id',$user_id)->paginate(30);

    $total = $this->saque->valorTotal($saques);
    $user = User::find($user_id);
    return view('admin.saques.index', compact('saques','total','user'));
    
    }

    public function store(Request $request){
        if($request->obs != '' && $request->obs != null){

        	$saque = $this->saque->create([
                'user_id' => $request->user_id,
                'valor' => str_replace(",", ".",$request->valor),
                'obs' => $request->obs,
                ]);

        	if ($saque)
            {
                $users = User::where('admin',1)->get();
                Notification::send($users, new SaquesPendentes($saque));

                User::find($request->user_id)->removerSaldo($request->valor);
        		return back()
        				->with('success','Saque realizado!');

            }else{
        		return back()
        				->with('error','Saque não realizado!');
            }

        }
        

        return back()->with('error','Saque não realizado, falta colocar uma forma de pagamento para que possamos te passar o valor do saque!');
    }

    public function delete($id){
    	$saque = Saque::find($id);
    	$saque->delete();
    }

    public function pendentes(){
        $saques = Saque::where('status','pendente')->paginate(5);
        $total = Saque::where('status','pendente')->get()->count();

        

        return view('admin.saques.saques_pendentes', compact('saques','total'));
    }

    public function confirmar_saque($id){
        $saque = Saque::find($id);
        $saque->status = 'confirmado';
        $saque->save();

        $saque->user->notify(new ConfirmacaoSaque($saque));

        return back()->with('success','Confirmado Pagamento de '.$saque->user->nome.', no valor de R$'.$saque->valor);
    }
}
