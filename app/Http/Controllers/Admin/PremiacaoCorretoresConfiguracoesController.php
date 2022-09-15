<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PremiacaoCorretoresConfiguracoes;
use App\Models\User;
use App\Models\Administradora;
use App\Models\Planos;
use App\Models\PremiacaoCorretoresLancados;

class PremiacaoCorretoresConfiguracoesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:configuracoes']);
    }

    public function index($id)
    {
        $corretor = User::where("id",$id)->first();
        if(!$corretor) {
            return redirect()->back();
        }
        $premiacoes = PremiacaoCorretoresConfiguracoes::where("user_id",$id)
            ->selectRaw("id")
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
            "plano_id" => "required"
        ];
        $message = [
            "administradora_id.required" => "Escolha uma administradora",
            "plano_id.required" => "Escolha um plano"
        ];
        $request->validate($rules,$message);
        $verificar = PremiacaoCorretoresConfiguracoes::where("user_id",$request->user_id)->where("administradora_id",$request->administradora_id)->where("plano_id",$request->plano_id)->get();
        if(count($verificar) >= 1) {
            return redirect()->route('premiacao.corretores.cadastrar',$request->user_id)->withInput($request->all())->with("errorpremiacaexiste","Esse Corretor já possui plano e administrador respectivamente cadastrada");            
        } else {
            foreach($request->premiacoes as $k => $v) {
                $cad = new PremiacaoCorretoresConfiguracoes();
                $cad->plano_id = $request->plano_id;
                $cad->administradora_id = $request->administradora_id;
                $cad->valor = $v; 
                $cad->parcela = $k+1;
                $cad->user_id = $request->user_id;
                $cad->save();
            }
            return redirect()->route('comissao.corretores.index',[$request->user_id]);
        }
    }

    public function pegarParcelas(Request $request)
    {
        $administradora = $request->administradora;
        $plano = $request->plano;
        $user = $request->user;
        $parcelas = PremiacaoCorretoresConfiguracoes::where("administradora_id",$administradora)->where("plano_id",$plano)->where("user_id",$user)->get();
        
        return view('admin.pages.corretores.premiacoes.parcelas',[
            "parcelas" => $parcelas
        ]);        
    }

    public function editarPremiacao(Request $request)
    {
        //return $request->all();
        $administradora = $request->administradora_premiacao_id_select;
        $plano = $request->plano_premiacao_id_select;
        $user = $request->user_id;
        PremiacaoCorretoresConfiguracoes::where("user_id",$user)->where("plano_id",$plano)->where("administradora_id",$administradora)->delete();
        // $del->delete();
        $ii=1;
        foreach($request->premiacoes as $k => $v):
            $cad = new PremiacaoCorretoresConfiguracoes();
            $cad->user_id = $user;
            $cad->plano_id = $plano;
            
            $cad->administradora_id = $administradora;
            $cad->valor = $v;
            $cad->parcela = $ii++;
            $cad->save();
        endforeach;
        return "sucesso";
    }






    public function deletarPremiacaoIndividual($id)
    {
       $premiacao = PremiacaoCorretoresConfiguracoes::where("id",$id)->first();
       if(!$premiacao) {
            return redirect()->back();
       } 
       $premiacao->delete();
       return redirect()->route('premiacao.corretores.index',$premiacao->user_id);
    }

    // public function editarPremiacao(Request $request) 
    // {
    //     $id = $request->id;
    //     $alt = PremiacaoCorretoresConfiguracoes::where("id",$id)->first();
    //     $alt->valor = $request->valor;
    //     if($alt->save()) {
    //         return "alterado";
    //     } else {
    //         return "error";
    //     }
    // }


}
