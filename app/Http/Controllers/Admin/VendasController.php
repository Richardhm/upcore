<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operadora;
use App\Models\Tipo;
use App\Models\Participacao;
use App\Models\Modelo;
use App\Models\Vendas;
use App\Models\Administradora;
use Illuminate\Support\Facades\DB;
use App\Models\Coletivo;

class VendasController extends Controller
{
    public function operadora()
    {
        // $operadoras = Operadora::all();
        // $id = auth()->user()->id;
        // $corretora = auth()->user()->corretora_id;
        // $colaboradores = DB::select("SELECT * FROM users WHERE corretora_id = ? AND id != ?",[$corretora,$id]);
        // $tipos = Tipo::all();
        // $participacao = Participacao::all();
        // $modelo = Modelo::all();
        // return view('admin.pages.vendas.operadora',[
            // "operadoras" => $operadoras,
            // "colaboradores" => $colaboradores,
            // "tipos" => $tipos,
            // "participacao" => $participacao,
            // "modelo" => $modelo
        // ]);
    }

    public function storeoperadora(Request $request)
    {
        // $dados = $request->all();
        // if(!auth()->user()->admin) {
        //     $dados['colaborador_id'] = auth()->user()->id;
        // }
        // $dados['corretora_id'] = $corretora = auth()->user()->corretora_id;
        // $dados['valor'] = str_replace([".",","],["","."],$request->valor);
        // Vendas::create($dados);
        // return redirect()->route('admin.home');
    }

    public function administradora()
    {
        // $corretora = auth()->user()->corretora_id;
        // $id = auth()->user()->id;

        // $colaboradores = DB::select("SELECT * FROM users WHERE corretora_id = ? AND id != ?",[$corretora,$id]);
        // $coletivos = Coletivo::all();
        // $modelo = Modelo::all();    
        // // $participacao = Participacao::all();
        // $administradoras = Administradora::whereIn('administradoras.id', function($query) use($corretora) {
        //     $query->select('corretora_administradora.administradora_id');
        //     $query->from('corretora_administradora');
        //     $query->whereRaw("corretora_administradora.corretora_id={$corretora}");
        // })->get();
        
        // return view('admin.pages.vendas.administradora',[
        //     "administradoras" => $administradoras,
        //     "colaboradores" => $colaboradores,
        //     "coletivos" => $coletivos,
        //     "modelo" => $modelo,
        //     // "participacao" => $participacao
        // ]);
    }

    public function editar(int $id)
    {
        // $venda = Vendas::find($id);
        // if(!$venda) {
        //     return redirect()->back();
        // }

        // return view('admin.pages.vendas.lancamentos.lancamentos_administrador',[
        //     "venda" => $venda
        // ]);  
        


    }





}
