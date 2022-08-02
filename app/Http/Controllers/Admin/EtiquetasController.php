<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\Etiquetas;


class EtiquetasController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:configuracoes']);
    }


    public function index()
    {
        $etiquetas = Etiquetas::all();
        return view('admin.pages.etiquetas.index',[
            "etiquetas" => $etiquetas
        ]);
    }


    public function cadastrar()
    {
        return view('admin.pages.etiquetas.create');
    }

    public function store(Request $request) 
    {
        $rules = [
            "nome" => "required|unique:etiquetas,nome|min:3|max:255",
            "cor" => "required"
        ];
        $message = [
            "nome.required" => "O campo nome e campo obrigatorio",
            "nome.unique" => "Essa etiqueta já esta cadastrada",
            "nome.min" => "Nome Deve ter no minimo 3 caracteres",
            "nome.max" => "Nome deve ter no maximo 255 caracteres",
            "cor.required" => "Cor e campo obrigatorio"
        ];
        $request->validate($rules,$message);
        $cad = new Etiquetas();
        $cad->nome = $request->nome;
        $cad->cor = $request->cor;
        if($request->padrao == "on") {
            $etiquetas = Etiquetas::all();
            foreach($etiquetas as $et) {
                $et->padrao = null;
                $et->save();
            } 
            $cad->padrao = true;
        } 
        $cad->save();
        return redirect()->route('etiquetas.index');
    }

    public function edit($id) 
    {
        $etiqueta = Etiquetas::where("id",$id)->first();
        
        if(!$etiqueta) {
            return redirect()->route('etiquetas.index');
        }
        return view('admin.pages.etiquetas.edit',[
            "etiqueta" => $etiqueta 
        ]);
    }

    public function update(Request $request,$id)
    {
        $etiqueta = Etiquetas::where("id",$id)->first();
        if(!$etiqueta) {
            return redirect()->route('etiquetas.index');
        }
        $data = $request->all();
        
        $id = $request->segment(3);
        $rules = [
            "nome" => "required|unique:etiquetas,nome,{$id},id|min:3|max:255",
            "cor" => "required"
        ];
        $message = [
            "nome.required" => "O campo nome e campo obrigatorio",
            "nome.unique" => "Essa etiqueta já esta cadastrada",
            "nome.min" => "Nome Deve ter no minimo 3 caracteres",
            "nome.max" => "Nome deve ter no maximo 255 caracteres",
            "cor.required" => "Cor e campo obrigatorio"
        ];
        $request->validate($rules,$message);

        if($request->padrao == "on") {
            $etiquetas = Etiquetas::all();
            foreach($etiquetas as $et) {
                $et->padrao = null;
                $et->save();
            } 
            $data['padrao'] = true;
        } 
        $etiqueta->update($data);
        return redirect()->route("etiquetas.index");        
    }

    // public function listarPorEtiquetaEspefifica($id)
    // {
    //     $nome = Etiquetas::where("id",$id)->first()->nome;
    //     $clientes = Cliente::where("etiqueta_id",$id)->where("user_id",auth()->user()->id)->get();
    //     return view("admin.pages.etiquetas.clientes",[
    //         "clientes" => $clientes,
    //         "nome" => $nome
    //     ]);

    // }

    public function deletar($id)
    {
        $etiqueta = Etiquetas::where("id",$id)->first();
        if(!$etiqueta) {
            return redirect()->route('etiquetas.index');
        }
        $etiqueta->delete();
        return redirect()->route("etiquetas.index");    
    }


}
