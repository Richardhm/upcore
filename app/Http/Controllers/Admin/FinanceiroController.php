<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cotacao;

class FinanceiroController extends Controller
{
    public function getAguardandoBoletoColetivo()
    {
        $dados = Cotacao::where("financeiro_id",1)->with(['administradora','plano','clientes'])->get();
        return view('admin.pages.financeiros.aguardandoBoletoColetivo',[
            "dados" => $dados
        ]);
    }

    public function setAguardandoBoletoColetivo(Request $request)
    {
        if($request->ajax()) {
            $cotacao = Cotacao::where("id",$request->id)->first();
            $cotacao->financeiro_id = 2;
            $cotacao->save();
        }  
    }

    public function getAguardandoPagamentoBoletoColetivo()
    {
        $dados = Cotacao::where("financeiro_id",2)->with(['administradora','plano','clientes'])->get();
        return view('admin.pages.financeiros.aguardandoPagamentoBoletoColetivo',[
            "dados" => $dados
        ]);
    }

    public function setAguardandoPagamentoBoletoColetivo(Request $request)
    {
        if($request->ajax()) {
            $cotacao = Cotacao::where("id",$request->id)->first();
            $cotacao->financeiro_id = 4;
            $cotacao->save();
        }
    }

    public function getAguardandoPagamentoVigencia()
    {
        $dados = Cotacao::where("financeiro_id",4)->with(['administradora','plano','clientes'])->get();
        return view('admin.pages.financeiros.aguardandoPagamentoVigencia',[
            "dados" => $dados
        ]);
    }

    public function setAguardandoPagamentoVigencia(Request $request)
    {
        if($request->ajax()) {
            $cotacao = Cotacao::where("id",$request->id)->first();
            $cotacao->financeiro_id = 6;
            $cotacao->save();
        }
    }

}
