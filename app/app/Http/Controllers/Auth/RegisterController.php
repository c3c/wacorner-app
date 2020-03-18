<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/gestao';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'nome' => ['required', 'string', 'max:255'],
            'sobrenome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users',
            function ($attribute, $value, $fail) {
                
               if(in_array(explode('@',$value)[1], ['gmail.com','hotmail.com','uol.com.br','outlook.com','outlook.com.br','yahoo.com','yahoo.com.br','bol.com.br']) == false){
                $fail('Não aceitamos esse tipo de '.$attribute.'. Somente com as seguintes terminações: <ul><li>gmail.com</li><li>hotmail.com</li><li>outlook.com</li><li>outlook.com.br</li><li>uol.com.br</li><li>yahoo.com</li><li>bol.com.br</li></ul>');
               }
            }
        ],
            'password' => ['required', 'min:6', 'confirmed'],
            'codigo_area' =>['required','max:3','min:3'],
            'telefone' =>['required','max:9','min:8'],
            'cpf' =>[
                function ($attribute, $value, $fail) {
                    if($value != '' && $value != null){
                        if(User::where('cpf',$value)->count()>0){
                            $fail('Esse cpf já existe.');
                        }else{
                            if(strlen($value)!=11)
                                $fail('CPF de conter 11 dígitos.');
                        }
                    }
                }
            ]
        ]);
        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        // if(isset($_COOKIE['afiliado_id'])){
        //     $afiliado = $_COOKIE['afiliado_id'];

        // }else{
            $afiliado = null;
        // }
        
        return User::create([
        'nome' => $data['nome'],
        'sobrenome' => $data['sobrenome'],
        'codigo_area' => $data['codigo_area'],
        'telefone' => $data['telefone'],
        'cpf' => $data['cpf'],
        'email' => $data['email'],
        'user_id' => $afiliado,
        'data_expiracao' =>  null,
        'password' => Hash::make($data['password']),
        ]);  
    }
}
