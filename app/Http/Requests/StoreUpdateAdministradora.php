<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateAdministradora extends FormRequest
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
            "nome" => "required|min:3|max:255|unique:administradoras",
            "logo" => "required",
            "premiacao_corretora" => "required",
            "parcelas"    => "required|array|min:1",
            "parcelas.*.parcelas" => "required|numeric"
        ];
    }

    public function messages()
    {
        return [
            "nome.required" => "O campo nome e campo obrigatório",
            "nome.unique" => "Já termos cadastrado uma administradora, com esse nome",
            "nome.min" => "O campo nome deve ter no minimo 3 caracteres",
            "nome.max" => "O campo nome deve ter no maximo 255 caracteres",
            "logo.required" => "O campo logo e campo obrigatório",
            "premiacao_corretora.required" => "O campo premiação corretora e campo obrigatório",
            "parcelas.*.parcelas.required" => "Preencha pelo menos 1 valor de comissão",
            "parcelas.*.parcelas.numeric" => "Preencha pelo menos 1 valor de comissão"
        ];
    }


}
