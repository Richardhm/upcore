<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendas;
use Illuminate\Support\Facades\DB;


class RelatorioController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:relatorio']);
    }


    public function index(Request $request)
    {
        
        
        // $colaboradores = "";
        // $search = "";
        // if(auth()->user()->id) {
        //     $id = auth()->user()->id;
        //     $corretora = auth()->user()->corretora_id;
        //     $colaboradores = DB::select("SELECT * FROM users WHERE corretora_id = ? AND id != ?",[$corretora,$id]);
        // }
        
        // if(!empty($request->get("_token"))) {
        //     $inicial = $request->data_inicial;
        //     $final = $request->data_final;
            
            
        //     if($request->colaborador_id) {
        //         $colaborador = $request->colaborador_id;
        //     } else {
        //         $colaborador = auth()->user()->id;
        //     }
            
        //     $search = DB::select("SELECT vendas.id,vendas.valor,vendas.created_at,(SELECT NAME FROM users WHERE vendas.colaborador_id = users.id) AS nome, (SELECT nome FROM tipos WHERE vendas.tipo_id = tipos.id) AS tipo from vendas WHERE created_at BETWEEN ? AND ? AND colaborador_id = ?",[$inicial,$final,$colaborador]);    
            
        // }
        
        // return view('admin.pages.relatorio.index',[
        //     "colaboradores" => $colaboradores,
        //     "search" => $search
        // ]);

        return view('admin.pages.relatorio.index');    


    }

    public function pesquisar(Request $request)
    {
        
                
    }




}
