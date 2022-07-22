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
    public function index()
    {
        $comissoes = DB::table('comissoes')
            ->selectRaw("id,created_at")
            ->selectRaw('(SELECT nome FROM planos WHERE planos.id = (SELECT plano_id FROM cotacoes WHERE comissoes.cotacao_id = cotacoes.id)) as plano')
            ->selectRaw('(SELECT nome FROM administradoras WHERE administradoras.id = (SELECT administradora_id FROM cotacoes WHERE comissoes.cotacao_id = cotacoes.id)) as administradora')
            ->selectRaw("(SELECT nome FROM clientes WHERE clientes.id = comissoes.cliente_id) AS cliente")
            ->selectRaw("(SELECT name FROM users WHERE users.id = comissoes.user_id) AS corretor")
            ->selectRaw("(SELECT COUNT(*) FROM comissoes_corretor_lancados WHERE comissoes.id = comissoes_corretor_lancados.comissao_id) AS quantidade_parcelas")
            ->selectRaw("(SELECT COUNT(*) FROM comissoes_corretor_lancados WHERE comissoes.id = comissoes_corretor_lancados.comissao_id AND status = 1) AS quantidade_pagas")
            ->get();
        
        return view('admin.pages.comissoes.index',[
            'comissoes' => $comissoes
        ]);
    }

    public function detalhes($id)
    {
        $comissoes = ComissoesCorretorLancados::where('comissao_id',$id)->get();
        $premiacao = PremiacaoCorretoresLancados::where('comissao_id',$id)->first();
        $comissoesCorretora = ComissoesCorretoraLancadas::where('comissao_id',$id)->get();
        $premiacoesCorretora = PremiacaoCorretoraLancadas::where('comissao_id',$id)->first();

        


        return view('admin.pages.comissoes.detalhes',[
            'comissoes' => $comissoes,
            "premiacao" => $premiacao,
            "comissoesCorretora" => $comissoesCorretora,
            "premiacoesCorretora" => $premiacoesCorretora
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

    



}
