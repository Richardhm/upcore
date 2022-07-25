<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComissoesCorretoresConfiguracoes;
use App\Models\User;
use App\Models\Administradora;

use App\Models\Planos;

class ComissoesCorretoresConfiguracoesController extends Controller
{
    public function index($id)
    {
        $corretor = User::where("id",$id)->first();
        
        if(!$corretor) {
            return redirect()->back();
        }

        $comissoes = ComissoesCorretoresConfiguracoes::where("user_id",$id)
            ->selectRaw("user_id")
            ->selectRaw("(SELECT nome FROM planos WHERE planos.id = comissoes_corretores_configuracoes.plano_id) as plano")
            ->selectRaw("(SELECT id FROM planos WHERE planos.id = comissoes_corretores_configuracoes.plano_id) as id_plano")
            ->selectRaw("(SELECT nome FROM administradoras WHERE administradoras.id = comissoes_corretores_configuracoes.administradora_id) as administradora")
            ->selectRaw("(SELECT id FROM administradoras WHERE administradoras.id = comissoes_corretores_configuracoes.administradora_id) as id_administradora")
            ->groupByRaw("plano_id,administradora_id")
            ->get();

        return view('admin.pages.corretores.comissoes.index',[
            "comissoes" => $comissoes,
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

       

        return view('admin.pages.corretores.comissoes.create',[
            "corretor" => $corretor,
            "administradoras" => $administradoras,
            "planos" => $planos

        ]);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $rules = [
            "administradora_id" => "required",
            "plano_id" => "required",
            "parcelas"    => "required|array|min:1",
            "parcelas.*.parcelas" => "required|numeric"
        ];

        $message = [
            "administradora_id.required" => "Escolha uma administradora",
            "plano_id.required" => "Escolha um plano",
            "parcelas.*.parcelas.required" => "Marque pelo menos 1 comissão",
            "parcelas.*.parcelas.numeric" => "Marque pelo menos 1 comissão"
        ];

        $request->validate($rules,$message);
        $ii=1;
        foreach($request->parcelas as $k => $v):
            $cad = new ComissoesCorretoresConfiguracoes();
            $cad->user_id = $request->user_id;
            $cad->plano_id = $request->plano_id;
            $cad->administradora_id = $request->administradora_id;
            $cad->valor = $v['parcelas'];
            $cad->parcela = $ii++;
            $cad->save();
        endforeach;

        return redirect()->route('comissao.corretores.index',$request->user_id);


    }


    public function detalhes($user,$plano,$administradora) 
    {
        $comissao = ComissoesCorretoresConfiguracoes::
            selectRaw("parcela,valor")
            ->where("user_id",$user)
            ->where("plano_id",$plano)
            ->where("administradora_id",$administradora)
            ->get();
        if(count($comissao) == 0) {
            return redirect()->back();
        }
        
        $plano = Planos::where("id",$plano)->first();
        $admin = Administradora::where("id",$administradora)->first();
        $user = User::where("id",$user)->first();
        return view('admin.pages.corretores.comissoes.detalhes',[
            "comissao" => $comissao,
            "plano" => $plano->nome,
            "admin" => $admin->nome,
            "user" => $user->name,
            "id" => $user->id
        ]);
        
        
    }



}
