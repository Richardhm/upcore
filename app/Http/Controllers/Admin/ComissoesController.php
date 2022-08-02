<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Comissao,
    ComissoesCorretoraLancadas,
    ComissoesCorretorLancados,
    PremiacaoCorretoresLancados,
    PremiacaoCorretoraLancadas
};
use Illuminate\Support\Facades\DB;

class ComissoesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:comissoes']);
    }


    public function index()
    {
        
        /** COmissao so apos para a vigencia */
        $comissoes = Comissao::with(['cotacao','cotacao.plano','cotacao.administradora','user','cotacao.clientes'])
            ->whereHas('cotacao',function($query){
                $query->where("financeiro_id",6);    
            })
            ->get();
            
        
        return view('admin.pages.comissoes.index',[
            'comissoes' => $comissoes
        ]);
    }

    public function detalhes($id)
    {
        $comissoes = ComissoesCorretorLancados::where('comissao_id',$id)->get();
        $premiacao = PremiacaoCorretoresLancados::where('comissao_id',$id)->first();
        //$comissoesCorretora = ComissoesCorretoraLancadas::where('comissao_id',$id)->get();
        //$premiacoesCorretora = PremiacaoCorretoraLancadas::where('comissao_id',$id)->first();

        


        return view('admin.pages.comissoes.detalhes',[
            'comissoes' => $comissoes,
            "premiacao" => $premiacao
            //"comissoesCorretora" => $comissoesCorretora,
            //"premiacoesCorretora" => $premiacoesCorretora
        ]);
    }

    public function mudarStatus(Request $request)
    {
        $id = $request->id;
        $comissao = ComissoesCorretorLancados::where("id",$id)->first();
        if(!$comissao) {
            return false;
        }
        $comissao->status = $comissao->status ? false : true;
        $comissao->save();

        return $comissao->status;
    }

    public function mudarStatusPremiacao(Request $request)
    {
        $id = $request->id;
        $comissao = PremiacaoCorretoresLancados::where("id",$id)->first();
        if(!$comissao) {
            return false;
        }
        $comissao->status = $comissao->status ? false : true;
        $comissao->data = date("Y-m-d");
        $comissao->save();

        return $comissao->status;
    }

    public function mudarStatusCorretora(Request $request)
    {
        $id = $request->id;
        
        $comissao = ComissoesCorretoraLancadas::where("id",$id)->first();
        if(!$comissao) {
            return false;
        }
        $comissao->status = $comissao->status ? false : true;
        $comissao->save();

        return $comissao->status;
    }

    public function mudarStatusCorretoraPremiacao(Request $request)
    {
        $id = $request->id;
        $comissao = PremiacaoCorretoraLancadas::where("id",$id)->first();
        if(!$comissao) {
            return false;
        }
        $comissao->status = $comissao->status ? false : true;
        $comissao->data = date("Y-m-d");
        $comissao->save();

        return $comissao->status;
    }

    



}
