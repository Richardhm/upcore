<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateOperadora extends FormRequest
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
            "nome" => "required|unique:operadoras,nome,{$id},id",
            "logo" => "required"
        ];
        if($this->method() == 'PUT') {
            $rules['logo'] = "nullable";
        }
        return $rules;
    }

    public function messages()
    {
        return [
            "nome.required" => "O campo nome e campo obrigatorio",
            "nome.unique" => "Já temos cadastrado esse nome de operadora",
            "logo.required" => "O campo logo e campo obrigatorio"
        ];
    }
}
