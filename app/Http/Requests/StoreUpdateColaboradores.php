<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateColaboradores extends FormRequest
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
        $id = $this->segment(3);
        $rules = [
            "name" => "required|min:3|max:255",
            "email" => "required|email|unique:users,email,{$id},id",
            "password" => "required|string|min:8|max:16",
            "permission" => "required|array|min:1"
        ];
        
        if($this->method() == 'PUT') {
            $rules['password'] = ['nullable','string','min:8','max:16'];
        }
        return $rules;

    }

    public function messages()
    {
        return [
            "name.required" => "O campo nome e campo obrigatório",
            "name.min" => "O campo nome deve ter no minimo 3 caracteres",
            "name.max" => "O campo nome deve ter no maximo 255 caracteres",
            "password.required" => "O campo senha e campo obrigatório",
            "password.min" => "O campo senha deve ter no minimo 8 caracteres",
            "password.max" => "O campo senha deve ter no maximo 16 caracteres",
            "email.required" => "O campo email e campo obrigatório",
            "email.unique" => "Ja existe esse email",
            "permission.required" => "Marque pelo menos 1 permissão",
            "permission.min" => "Marque pelo menos 1 permissão"
        ];
        
    }



}
