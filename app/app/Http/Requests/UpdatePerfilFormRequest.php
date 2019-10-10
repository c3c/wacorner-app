<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\User;

class UpdatePerfilFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       
        return [
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->id),
            ],
            'codigo_area' =>'required|max:3',
            'telefone' =>'required|max:9',
            'cpf' =>[
                function ($attribute, $value, $fail) {
                    if($value != '' && $value != null){
                        if(User::where('cpf',$value)->where('id','!=',$this->id)->count()>0){
                            $fail('Esse cpf já existe.');
                        }else{
                            if(strlen($value)!=11)
                                $fail('CPF de conter 11 dígitos.');
                        }
                    }
                }
            ]
        ];
    }
}
