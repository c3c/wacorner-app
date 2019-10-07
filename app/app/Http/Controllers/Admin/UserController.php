<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Venda;
use App\Http\Requests\UpdatePerfilFormRequest;
use DB;
class UserController extends Controller
{
    public function show(){
    	$usuarios = User::where('admin','!=',1)->select('id','email','data_expiracao','created_at')->orderBy('id','desc')->paginate(30);
    	$total = User::count();
  
    	return view('admin.usuario.show',compact('usuarios','total'));
    }

    public function search(Request $r, User $usuario){
        $data = $r->except('_token');
        $email = isset($data['email']) ? trim($data['email']) : null;
        $cpf = isset($data['cpf']) ? trim($data['cpf']) : null;

        $usuarios = $usuario->when($email, function ($query, $email) {
                        return $query->where('email','like','%'.$email.'%');
                    })
                    ->when($cpf, function ($query, $cpf) {
                        return $query->where('cpf','like','%'.$cpf.'%');
                    })
                    ->paginate(30);

        $total = 4;

        return view('admin.usuario.show',compact('usuarios','total','data'));
    }

    public function plano_valor($plano){
        if($plano == 'profissional')
            return 30;

        return 30;
    }

    

    public function perfil($id = null){

        if($id == null)
            $usuario = auth()->user();
        else if(auth()->user()->admin == 1 && $id != null)
            $usuario = User::find($id);
        else 
            $usuario = auth()->user();

    	return view('admin.usuario.perfil',compact('usuario'));
    }

    public function perfilUpdate(UpdatePerfilFormRequest $request){    
        	
    	$data = $request->all();
    	if ($data['password'] != null)
    		$data['password'] = bcrypt($data['password']);
        else
            unset($data['password']);
        
    	$update = User::find($data['id'])->update($data);

		if ($update)
			return back()
				->with('success','Atualizado com sucesso!');
		else
			return back()
				->with('error','Algum erro ocorreu, por favor entre em contato pelo email!!!');

    }

    public function addDias(Request $r){
        echo $r->dias;
        $usuario = User::find($r->user_id);
        $usuario->renovacao(null, $r->dias);

        return $usuario;
    }

    public function buscaCadastro(Request $request){
        $usuario = User::where('email',$request->email)->where('telefone',$request->telefone)->first();
        if ($usuario != null) {
            return view('admin.usuario.novaSenha',compact('usuario'));
        }else{
            return back()->with('error','Dados inválidos!');
        }
    }

    public function novaSenha(Request $request){
        $usuario = User::find($request->id);
        $usuario->password = bcrypt($request->password);
        $usuario->save();

        return back()->with('success','Senha alterada com sucesso!');
    }

    public function excluir($id){
        $usuario = User::find($id);
        $usuario->delete();

        return back()->with('success','Conta excluida!');
    }
}
