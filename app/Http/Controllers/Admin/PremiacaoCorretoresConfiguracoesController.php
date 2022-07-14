<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PremiacaoCorretoresConfiguracoes;
use App\Models\User;
use App\Models\Administradora;
use App\Models\Planos;

class PremiacaoCorretoresConfiguracoesController extends Controller
{
    public function index($id)
    {
        $corretor = User::where("id",$id)->first();
        
        if(!$corretor) {
            return redirect()->back();
        }

        $premiacoes = PremiacaoCorretoresConfiguracoes::where("user_id",$id)
            ->selectRaw("valor")
            ->selectRaw("(SELECT nome FROM planos WHERE planos.id = premiacao_corretores_configuracoes.plano_id) as plano")
            
            ->selectRaw("(SELECT nome FROM administradoras WHERE administradoras.id = premiacao_corretores_configuracoes.administradora_id) as administradora")
            
            
            ->get();      

        return view('admin.pages.corretores.premiacoes.index',[
            "premiacoes" => $premiacoes,
            "corretor" => $corretor
        ]);
    }

    public function create($id)
    {
        $corretor = User::where("id",$id)->first();
        
        if(!$corretor) {
            return redirect()->back();
        }

        $administradoras = Administradora::all();
        $planos = Planos::all();

       

        return view('admin.pages.corretores.premiacoes.create',[
            "corretor" => $corretor,
            "administradoras" => $administradoras,
            "planos" => $planos

        ]);
    }

    public function store(Request $request)
    {
        
        $rules = [
            "administradora_id" => "required",
            "plano_id" => "required",
            "valor"    => "required"
            
        ];

        $message = [
            "administradora_id.required" => "Escolha uma administradora",
            "plano_id.required" => "Escolha um plano",
            "valor" => "Valor e campo obrigatorio"
            
        ];

        $request->validate($rules,$message);
        
        $p = new PremiacaoCorretoresConfiguracoes();
        $p->user_id = $request->user_id;
        $p->administradora_id = $request->administradora_id;
        $p->plano_id = $request->plano_id;
        $p->valor = $request->valor;
        $p->save();


        return redirect()->route('premiacao.corretores.index',$request->user_id);


    }




}
