<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Administradora,
    User,
    Etiquetas,
    Cliente,
    Tabela,
    OrcamentoFaixaEtaria,
    ClienteOrcamento,
    Orcamento,
    Cidade,
    Operadora,
    Contrato,
    Comissao,
    AdministradoraParcelas,
    ComissoesVendedor,
    Planos
};

class ContratoController extends Controller
{
    public function index(Request $request)
    {
        
        $id = auth()->user()->id;
        $contratos = Cliente::where("user_id",$id)->where("etiqueta_id","=",3)->with(['cotacao','user','cotacao.administradora','cidade','cotacao.acomodacao'])->get();
        return view("admin.pages.contrato.index",[
            "contratos" => $contratos
        ]);    
          
    }





    
    public function cadastrarPF(Request $request)
    {
        $rules = [
            "nome" => "required",
            "cpf" => "required",
            "data_nascimento" => "required",
            "email" => "required",
            "cidade" => "required",
            "operadora" => "required",
            "administradora" => "required",
            "codigo_externo" => "required",
            "coparticipacao" => "required",
            "odonto" => "required",
            "acomodacao" => "required",
            "valor" => "required"
        ];     
        $message = [
            "required" => "O campo :attribute e campo obrigatorio" 
        ];
        $request->validate($rules,$message);
        $cliente = Cliente::where("id",$request->cliente_id)->first();
        if(!$cliente) {
            return redirect()->back();
        } 

        $cliente->cpf = $request->cpf;
        $cliente->data_nascimento = implode("-",array_reverse(explode("/",$request->data_nascimento)));
        $cliente->save();


        $contrato = new Contrato();
        $contrato->cliente_id = $request->cliente_id;
        $contrato->user_id = auth()->user()->id;
        $contrato->cidade_id = $request->cidade;
        $contrato->operadora_id = $request->operadora;
        $contrato->administradora_id = $request->administradora;
        $contrato->orcamento_id = $request->orcamento_id;
        $contrato->acomodacao_id = $request->acomodacao;
        $contrato->codigo_externo = $request->codigo_externo;
        $contrato->valor = str_replace("R$ ","",str_replace(["R$ ",".",","],["","","."],$request->valor));
        $contrato->status = "Aguardando Pagamento";
        $contrato->save();
        
        
        $administradora = Administradora::where("id",$request->administradora)->first();
        $adminParcelas = AdministradoraParcelas::where("administradora_id",$request->administradora)->get();

        $comissao = new Comissao();
        $comissao->contrato_id = $contrato->id;
        $comissao->cliente_id = $request->cliente_id;
        $comissao->user_id = auth()->user()->id;
        $comissao->save();
        
        $ii=1;
        foreach($adminParcelas as $k => $v) {
            $c = new ComissoesVendedor();
            $c->comissao_id = $contrato->id;
            $c->parcela = $ii;
            
            $c->data = date("Y-m-d",strtotime($administradora->created_at."+{$ii}month"));
            $c->valor = ($contrato->valor * $v->valor) / 100;
            $c->status = false;
            $c->save();
            $ii++;
        }

        return redirect()->route('clientes.index');
    }



    


    public function montarContratoSemOrcamento(Request $request)
    {
        $faixas = $request->faixas;
            foreach($faixas as $k => $v) {
                if($v != null) {
                    $orcamentoFaixaEtaria = new OrcamentoFaixaEtaria();
                    $orcamentoFaixaEtaria->faixa_etaria_id = $k;
                    $orcamentoFaixaEtaria->quantidade = $v;
                    $orcamentoFaixaEtaria->save();
                    $chaves[] = $k;
                } 
        }

        $acomodacao = 
            ($request->acomodacao == 1 ? "Apartamento" : 
            ($request->acomodacao == 2 ? "Enfermaria" : 
            ($request->acomodacao == 3 ? "Ambulatorial" : "")));
               
        $valores = DB::table("tabelas")
            ->selectRaw("SUM((valor * (SELECT quantidade FROM orcamento_faixa_etarias WHERE orcamento_faixa_etarias.faixa_etaria_id = tabelas.faixa_etaria LIMIT 1))) AS total")
            ->selectRaw("modelo")
            ->whereRaw("cidade_id = ".$request->cidade." AND operadora_id = ".$request->operadora." AND administradora_id = ".$request->administradora." AND odonto = ".($request->odonto == "sim" ? 1 : 0)." AND coparticipacao = ".($request->coparticipacao == "sim" ? 1 : 0)." AND plano_id = ".$request->plano." AND modelo = '".$acomodacao."'")
            ->whereIn("faixa_etaria",array_values($chaves))
            ->groupBy("modelo")
            ->first();
        if(!empty($valores) && isset($valores->total))  {
            return number_format($valores->total,2,",","."); 
        } else {
            return "nada";
        }    
        
        
        
    }


    public function cadastrarContratoSemOrcamento(Request $request) 
    {
       
        $cliente = Cliente::where("id",$request->cliente_id)->first();
        $cliente->etiqueta_id = 3;
        $cliente->ultimo_contato = date('Y-m-d');
        $cliente->save();

        $contrato = new Contrato();
        $contrato->cliente_id = $request->cliente_id;
        $contrato->user_id = auth()->user()->id;
        $contrato->cidade_id = $request->cidade;
        $contrato->operadora_id = $request->operadora;
        $contrato->administradora_id = $request->administradora;
        $contrato->orcamento_id = $request->orcamento_id;
        $contrato->acomodacao_id = $request->acomodacao;
        $contrato->codigo_externo = $request->codigo_externo;
        $contrato->valor = str_replace("R$ ","",str_replace(["R$ ",".",","],["","","."],$request->valor));
        $contrato->status = "Aguardando Pagamento";
        
        $contrato->save();

        $administradora = Administradora::where("id",$request->administradora)->first();
        $adminParcelas = AdministradoraParcelas::where("administradora_id",$request->administradora)->get();

        $comissao = new Comissao();
        $comissao->contrato_id = $contrato->id;
        $comissao->cliente_id = $request->cliente_id;
        $comissao->user_id = auth()->user()->id;
        $comissao->save();
        
        $ii=1;
        foreach($adminParcelas as $k => $v) {
            $c = new ComissoesVendedor();
            $c->comissao_id = $comissao->id;
            $c->parcela = $ii;
            
            $c->data = date("Y-m-d",strtotime($administradora->created_at."+{$ii}month"));
            $c->valor = ($contrato->valor * $v->valor) / 100;
            $c->status = false;
            $c->save();
            $ii++;
        }

        return redirect()->route('clientes.index');




        
    }

    






    



}
