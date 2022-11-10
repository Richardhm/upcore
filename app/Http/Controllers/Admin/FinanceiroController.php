<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\{
    Acomodacao,
    Administradora,
    Cidade,
    User,
    Cliente,
    ComissoesCorretoraLancadas,
    ComissoesCorretorLancados,
    Cotacao,
    CotacaoFaixaEtaria,
    CotacaoJuridica,
    Etiquetas,
    Operadora,
    Planos,
    PremiacaoCorretoraLancadas,
    PremiacaoCorretoresLancados,
    Tarefa
};
use Illuminate\Support\Facades\DB;


class FinanceiroController extends Controller
{
    public function getAguardandoBoletoColetivo()
    {
        $dados = Cotacao::where("financeiro_id",1)->where("plano_id","!=",1)->with(['administradora','plano','clientes','user'])->get();
        return view('admin.pages.financeiros.aguardandoBoletoColetivo',[
            "dados" => $dados
        ]);
    }

    public function planoIndividual()
    {
        
        $dados = Cotacao::where("financeiro_id",3)->where("plano_id",1)->with(['administradora','plano','clientes','user'])->get();
        return view('admin.pages.financeiros.aguardandoIndividual',[
            "dados" => $dados
        ]);    
    }

    public function setPlanoIndividual(Request $request)
    {
        if($request->ajax()) {
            $cotacao = Cotacao::where("id",$request->id)->first();
            $cotacao->financeiro_id = 6;
            $cotacao->save();
            return Cotacao::where("financeiro_id",3)->count();
        }
    }


    public function setAguardandoBoletoColetivo(Request $request)
    {
        if($request->ajax()) {
            $cotacao = Cotacao::where("id",$request->id)->first();
            $cotacao->financeiro_id = 2;
            $cotacao->save();
            return Cotacao::where("financeiro_id",1)->count();
        }  
    }

    public function getAguardandoPagamentoBoletoColetivo()
    {
        $dados = Cotacao::where("financeiro_id",2)->with(['administradora','plano','clientes','user'])->get();
        return view('admin.pages.financeiros.aguardandoPagamentoBoletoColetivo',[
            "dados" => $dados
        ]);
    }

    public function cadastrarJuridico()
    {
        
        $administradoras = Administradora::all();
        $users = User::where("admin",null)->get();
        $cidades = Cidade::all();
        
        return view('admin.pages.financeiros.cadastrar-pessoa-juridica',[
            "administradoras" => $administradoras,
            "users" => $users,
            "cidades" => $cidades
        ]);
    }

    public function storeJuridico(Request $request)
    {
        
        $rules = [
            "administradora_id" => "required",
            "cnpj" => "required",
            "nome_empresa" => "required",
            "nome" => "required",
            "contato" => "required",
            "celular" => "required",
            "email" => "required",
            "quantidade_vidas" => "required",
            "valor" => "required",
            "user_id" => "required",
            "cidade_id" => "required"
        ]; 

        $message = [
            "administradora_id.required" => "Escolha uma operadora",
            "cnpj.required" => "CPNJ é campo obrigatório",
            "nome_empresa.required" => "Razão Social é campo obrigatório",
            "nome.required" => "Nome do Proprietario é campo obrigatório",
            "contato.required" => "Contato é campo obrigatório",
            "celular.required" => "Celular é campo obrigatório",
            "email.required" => "Email é campo obrigatório",
            "quantidade_vidas.required" => "Quantidade de vidas é campo obrigatório",
            "valor.required" => "Valor é campo obrigatório",
            "user_id.required" => "Escolha um vendedor",
            "cidade_id.required" => "Cidade e campo obrigatório"
        ];

        $request->validate($rules,$message);

        /** Cadastrar Tabela Clientes */
        $cliente = new Cliente();
        $cliente->user_id = $request->user_id;
        $cliente->cidade_id = $request->cidade_id;
        $cliente->etiqueta_id = 3;
        $cliente->nome = $request->nome;
        $cliente->telefone = $request->celular;
        // $cliente->contato = $request->contato;
        $cliente->email = $request->email;
        $cliente->cnpj = $request->cnpj;
        $cliente->nome_empresa = $request->nome_empresa;
        $cliente->pessoa_fisica = 0;
        $cliente->pessoa_juridica = 1;
        $cliente->ultimo_contato = date("Y-m-d");
        $cliente->save();
        /** Fim Cadastro Juridico */

        /** Cadastrar Cotacao Juridica */
        $cotacao = new CotacaoJuridica();
        $cotacao->cliente_id = $cliente->id;
        $cotacao->quantidade_vidas = $request->quantidade_vidas;
        $cotacao->valor = str_replace([".",","],["","."],$request->valor);
        $cotacao->save();

        return redirect()->route("admin.home")->with("message","{$cliente->nome} cadastrado com sucesso!");
        /** Fim Cadastrar Cotacao Juridica */


    }

    public function aguardandojuridico()
    {
        $dados = CotacaoJuridica::where("status",0)->with(['cliente','cliente.cidade','cliente.user'])->get();
        
        return view("admin.pages.financeiros.aguardandoPagamentoJuridico",[
            "dados" => $dados
        ]);
    }

    public function aguardandojuridicoColaborador($id)
    {
        $admin = "";
        if(auth()->user()->admin) {
            $dados = CotacaoJuridica::where("status",0)
            ->with(['cliente','cliente.cidade','cliente.user'])
            ->get();
            $admin = "sim";
        } else {
            $dados = CotacaoJuridica::where("status",0)->whereHas('cliente',function($query){
                $query->where("user_id",auth()->user()->id);
            })
            ->with(['cliente','cliente.cidade'])
            ->get();
        }
                
        
        
        return view("admin.pages.financeiros.aguardandoPagamentoJuridicoColaborador",[
            "dados" => $dados,
            "admin" => $admin
        ]);
    }


    public function setAguardandoPagamentoBoletoColetivo(Request $request)
    {
        if($request->ajax()) {
            $cotacao = Cotacao::where("id",$request->id)->first();
            $cotacao->financeiro_id = 4;
            $cotacao->save();
            return Cotacao::where("financeiro_id",2)->count();
        }
    }

    public function getAguardandoPagamentoVigencia()
    {
        
        $dados = Cotacao::where("financeiro_id",4)->with(['administradora','plano','clientes','comissao'])->get();
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
            return Cotacao::where("financeiro_id",4)->count();
        }
    }

    public function colaboradorAguardandoBoletocoletivo()
    {
        if(auth()->user()->admin) {
            $dados = Cotacao::where("financeiro_id",1)->where("plano_id","!=",1)->with(['administradora','plano','clientes','user'])->get();
        } else {
            $dados = Cotacao::where("financeiro_id",1)->where("plano_id","!=",1)->where("user_id",auth()->user()->id)->with(['administradora','plano','clientes','user'])->get();
        }
        
        return view('admin.pages.financeiros.colaboradores.aguardandoBoletoColetivo',[
            "dados" => $dados
        ]);
    }

    public function colaboradorAguardandoPagAdesaoColetivo()
    {
        if(auth()->user()->admin) {
            $dados = Cotacao::where("financeiro_id",2)->where("plano_id","!=",1)->with(['administradora','plano','clientes','user'])->get();
        } else {
            
            $dados = Cotacao::where("financeiro_id",2)->where("plano_id","!=",1)->where("user_id",auth()->user()->id)->with(['administradora','plano','clientes','user'])->get();
        }
        
        return view('admin.pages.financeiros.colaboradores.aguardandoPagamentoBoletoColetivo',[
            "dados" => $dados
        ]);
    }

    public function colaboradorAguardandoPagVigencia()
    {
        
        $admin = "";
        if(auth()->user()->admin) {
            $dados = Cotacao::where("financeiro_id",4)->where("plano_id","!=",1)->with(['administradora','plano','clientes','user'])->get();
            $admin = "sim";
        } else {
            
            $dados = Cotacao::where("financeiro_id",4)->where("plano_id","!=",1)->where("user_id",auth()->user()->id)->with(['administradora','plano','clientes','user'])->get();
        }
        
        return view('admin.pages.financeiros.colaboradores.aguardandoPagamentoVigencia',[
            "dados" => $dados,
            "admin" => $admin
        ]);
    }

    public function colaboradorPlanoIndividual()
    {
        $dados = Cotacao::where("financeiro_id",1)->where("plano_id",1)->where("user_id",auth()->user()->id)->with(['administradora','plano','clientes','user'])->get();
        return view('admin.pages.financeiros.colaboradores.aguardandoIndividual',[
            "dados" => $dados
        ]);    
    }

    public function backAguardandoPagamentoAdesaoColetivo(Request $request)
    {
        $cotacao = Cotacao::where("id",$request->id)->first();
        $cotacao->financeiro_id = 2;
        $cotacao->save();
        return Cotacao::where("financeiro_id",4)->count();
    }

    public function backAguardandoBoletoColetivo(Request $request)
    {
        $cotacao = Cotacao::where("id",$request->id)->first();
        $cotacao->financeiro_id = 1;
        $cotacao->save();
        return Cotacao::where("financeiro_id",2)->count();
    }

    public function mesChange(Request $request)
    {
            $ano = $request->ano;
            $mes = $request->mes;
            $meses = ['01'=>"Janeiro",'02'=>"Fevereiro",'03'=>"Março",'04'=>"Abril",'05'=>"Maio",'06'=>"Junho",'07'=>"Julho",'08'=>"Agosto",'09'=>"Setembro",'10'=>"Outubro",'11'=>"Novembro",'12'=>"Dezembro"];
           
           
            $aguardando_boleto_coletivo = Cotacao::where("financeiro_id",1)->where("plano_id","!=",1)->whereMonth('updated_at', $request->mes)->whereYear("updated_at",$request->ano)->count();
        
            $aguardando_boleto_coletivo_total = Cotacao::where("financeiro_id",1)->where("plano_id","!=",1)->whereYear("updated_at",$request->ano)->whereMonth('updated_at', $request->mes)->selectRaw("sum(valor) as total")->first()->total;
            $aguardando_boleto_coletivo_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query) use($request){
                $query->where("financeiro_id",1);
                $query->where("plano_id","!=",1);
                $query->whereYear("updated_at",$request->ano);
                $query->whereMonth("updated_at",$request->mes);
            })->selectRaw("sum(quantidade) as total")->first()->total;
    
            $aguardando_pagamento_adesao_coletivo = Cotacao::where("financeiro_id",2)->whereYear("updated_at",$request->ano)->whereMonth('updated_at',$request->mes)->where("plano_id","!=",1)->count();
            $aguardando_pagamento_boleto_coletivo_total = Cotacao::where("financeiro_id",2)->whereYear("updated_at",$request->ano)->whereMonth('updated_at',$request->mes)->where("plano_id","!=",1)->selectRaw("sum(valor) as total")->first()->total;
            $aguardando_pagamento_boleto_coletivo_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query) use($request){
                $query->where("financeiro_id",2);
                $query->where("plano_id","!=",1);
                $query->whereMonth('updated_at',$request->mes);
                $query->whereYear("updated_at",$request->ano);
            })->selectRaw("sum(quantidade) as total")->first()->total;

            $aguardando_individual_qtd = Cotacao::where("financeiro_id",1)->whereMonth('updated_at',$request->mes)->whereYear("updated_at",$request->ano)->where("plano_id",1)->count();
            $aguardando_individual_total = Cotacao::where("financeiro_id",1)->whereMonth('updated_at',$request->mes)->whereYear("updated_at",$request->ano)->where("plano_id",1)->selectRaw("sum(valor) as total")->first()->total;
            $aguardando_individual_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query) use($request){
                $query->where("financeiro_id",1);
                $query->where("plano_id",1);
                $query->whereMonth('updated_at',$request->mes);
                $query->whereYear('updated_at',$request->ano);
            })->selectRaw("sum(quantidade) as total")->first()->total;


            $aguardando_pagamento_vigencia = Cotacao::where("financeiro_id",4)->whereYear('updated_at',$request->ano)->whereMonth('updated_at',$request->mes)->where("plano_id","!=",1)->count();
            $aguardando_pagamento_vigencia_total = Cotacao::where("financeiro_id",4)->whereYear('updated_at',$request->ano)->whereMonth('updated_at',$request->mes)->where("plano_id","!=",1)->selectRaw("sum(valor) as total")->first()->total;
            $aguardando_pagamento_vigencia_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query) use($request){
                $query->where("financeiro_id",4);
                $query->where("plano_id","!=",1);
                $query->whereMonth('updated_at',$request->mes);
                $query->whereYear('updated_at',$request->ano);
            })->selectRaw("sum(quantidade) as total")->first()->total;

            $primeiros = DB::select("SELECT 
                user_id,
                (SELECT NAME FROM users WHERE users.id = cc.user_id) AS vendedor,
                (SELECT image FROM users WHERE users.id = cc.user_id) AS imagem, 
                (SELECT if(SUM(quantidade)>0,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id IN(SELECT id FROM cotacoes AS dentro WHERE dentro.user_id = cc.user_id AND dentro.plano_id = 1 AND dentro.financeiro_id = 6)) AS vidas_individual,
                (SELECT if(SUM(quantidade)>0,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id IN(SELECT id FROM cotacoes AS dentro WHERE dentro.user_id = cc.user_id AND dentro.plano_id = 3 AND dentro.financeiro_id = 6)) AS vidas_coletivo,
                SUM(quantidade) AS total_vidas,
                (SELECT sum(valor) FROM cotacoes AS dentro WHERE dentro.plano_id = 1 AND dentro.financeiro_id = 6 AND dentro.user_id = cc.user_id) AS valor_individual,
                (SELECT sum(valor) FROM cotacoes AS dentro WHERE dentro.plano_id = 3 AND dentro.financeiro_id = 6 AND dentro.user_id = cc.user_id) AS valor_coletivo,
                (SELECT SUM(valor) FROM cotacoes dentro WHERE dentro.financeiro_id = 6 AND dentro.user_id = cc.user_id) total_valor
                FROM cotacao_faixa_etarias AS cf
                INNER JOIN cotacoes AS cc ON cc.id = cf.cotacao_id
                WHERE financeiro_id = 6 AND YEAR(cc.updated_at) = ".$request->ano." AND MONTH(cc.updated_at) = ".$request->mes."
                GROUP BY user_id
                ORDER BY total_vidas DESC
                LIMIT 5
            ");
            

            $ranking = DB::select("SELECT 
                id_user,
                usuarios,quantidade_allcare,allcare,quantidade_alter,alters,quantidade_qualicorp,qualicorp,quantidade_hapvida,hapvida,total
                FROM 
                (
                    select 
                        (SELECT id FROM users WHERE users.id = fora.user_id) id_user,
                        (SELECT NAME FROM users WHERE users.id = fora.user_id) AS usuarios,
                        (SELECT if(SUM(valor)>0,SUM(valor),0) from cotacoes AS dentro WHERE dentro.user_id = users.id AND financeiro_id = 6 AND dentro.administradora_id = 1) AS 'allcare',
                        (SELECT if(SUM(quantidade)>0,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id IN(SELECT id FROM cotacoes as dentro WHERE dentro.user_id = users.id AND administradora_id = 1 AND financeiro_id = 6)) AS 'quantidade_allcare',
                        (SELECT if(SUM(valor)>0,SUM(valor),0) from cotacoes AS dentro WHERE dentro.user_id = users.id AND financeiro_id = 6 AND dentro.administradora_id = 2) AS 'alters',
                        (SELECT if(SUM(quantidade)>0,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id IN(SELECT id FROM cotacoes as dentro WHERE dentro.user_id = users.id AND administradora_id = 2 AND financeiro_id = 6)) AS 'quantidade_alter',
                        (SELECT if(SUM(valor)>0,SUM(valor),0) from cotacoes AS dentro WHERE dentro.user_id = users.id AND financeiro_id = 6 AND dentro.administradora_id = 3) AS 'qualicorp',
                        (SELECT if(SUM(quantidade)>0,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id IN(SELECT id FROM cotacoes as dentro WHERE dentro.user_id = users.id AND administradora_id = 3 AND financeiro_id = 6)) AS 'quantidade_qualicorp',
                        (SELECT if(SUM(valor)>0,SUM(valor),0) from cotacoes AS dentro WHERE dentro.user_id = users.id AND financeiro_id = 6 AND dentro.administradora_id = 4) AS 'hapvida',
                        (SELECT if(SUM(quantidade)>0,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id IN(SELECT id FROM cotacoes as dentro WHERE dentro.user_id = users.id AND administradora_id = 4 AND financeiro_id = 6)) AS 'quantidade_hapvida',
                        (SELECT SUM(valor) FROM cotacoes AS dentro WHERE dentro.user_id = users.id AND financeiro_id = 6) AS 'total'
                    from cotacoes AS fora
                    INNER JOIN cotacao_faixa_etarias ON cotacao_faixa_etarias.cotacao_id = fora.id
                    INNER JOIN administradoras ON fora.administradora_id = administradoras.id 
                    INNER JOIN users ON users.id = fora.user_id
                    where financeiro_id = 6 AND MONTH(fora.updated_at) = ".$request->mes." AND YEAR(fora.updated_at) = ".$request->ano." GROUP BY fora.user_id
                    ORDER BY total desc
                )
                AS full_tabela"
            );


            $totalIndividual = Cotacao::where("financeiro_id",6)
                ->where("plano_id",1)
                ->whereMonth("updated_at",$request->mes)
                ->whereYear("updated_at",$request->ano)
                ->selectRaw("sum(valor) as total")
                ->first()
                ->total;
        
            $totalGeralVidas = Cotacao::where("financeiro_id",6)->whereMonth("cotacoes.updated_at",$mes)->whereYear('cotacoes.updated_at',$ano)
                ->join("cotacao_faixa_etarias","cotacao_faixa_etarias.cotacao_id","cotacoes.id")
                ->selectRaw("sum(quantidade) as qtd")->first()->qtd;
                
    
            $totalVidasIndividual = CotacaoFaixaEtaria::whereHas('cotacao',function($query)use($request){
                $query->where("plano_id",1);
                $query->whereMonth("updated_at",$request->mes);
                $query->whereYear("updated_at",$request->ano);
                $query->where("financeiro_id",6);
            })->selectRaw("sum(quantidade) as total")->first()->total;
        
            $totalColetivo = Cotacao::where("financeiro_id",6)
            ->where("plano_id",3)
            ->whereMonth("updated_at",$request->mes)
            ->whereYear("updated_at",$request->ano)
            ->selectRaw("sum(valor) as total")
            ->first()
            ->total;

            $totalVidasColetivo = CotacaoFaixaEtaria::whereHas('cotacao',function($query)use($request){
                $query->where("plano_id",3);
                $query->whereMonth("updated_at",$request->mes);
                $query->whereYear("updated_at",$request->ano);
                $query->where("financeiro_id",6);
            })->selectRaw("sum(quantidade) as total")->first()->total;

            $administradorasVidaTotal = DB::select(
                "SELECT 
                id,nome,
                (SELECT SUM(valor) FROM cotacoes WHERE cotacoes.administradora_id = administradoras.id AND financeiro_id = 6 AND MONTH(cotacoes.updated_at) = ".$request->mes." AND YEAR(cotacoes.updated_at) = ".$request->ano.") AS valores,
                (SELECT if(SUM(quantidade)>0,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id IN(SELECT id FROM cotacoes as dentro WHERE MONTH(dentro.updated_at) = ".$request->mes." AND YEAR(dentro.updated_at) = ".$request->ano." AND administradora_id = (SELECT id FROM administradoras as aa WHERE aa.id = administradoras.id) AND financeiro_id = 6)) AS qte
            FROM administradoras WHERE id != (SELECT id FROM administradoras WHERE nome LIKE '%hap%')"
            );
            

            $atrasadoAguardandoPagAdesaoColetivo = Cotacao::where("financeiro_id",2)->whereHas('clientes',function($query){
                $query->where("data_boleto","<",date('Y-m-d'));            
            })->count();
        
            $atrasadoAguardandoPagVigenciaColetivo = Cotacao::where("financeiro_id",4)->whereHas('clientes',function($query){
                $query->where("data_vigente","<",date('Y-m-d'));            
            })->count();

            $atrasadoPlanoIndividual = Cotacao::where("plano_id",1)
                ->where("financeiro_id",1)
                ->whereMonth('updated_at',$request->mes)->whereYear('updated_at',$request->ano)->whereHas('clientes',function($query){
                $query->where("data_boleto","<",date('Y-m-d'));
                $query->orWhere("data_vigente","<",date("Y-m-d"));
            })->count();
        
            $aguardando_pagamento_plano_individual = Cotacao::where("financeiro_id",3)->count();
            $aguardando_pagamento_empresarial = Cotacao::where("financeiro_id",5)->count();
            return view('admin.pages.home.resultado-pesquisa',[
                "quantidade_aguardando_boleto_coletivo" => $aguardando_boleto_coletivo,
                "aguardando_boleto_coletivo_total" =>  $aguardando_boleto_coletivo_total,
                "aguardando_boleto_coletivo_vidas" => $aguardando_boleto_coletivo_vidas,
                "quantidade_aguardando_pagamento_adesao_coletivo" => $aguardando_pagamento_adesao_coletivo,
                "aguardando_pagamento_boleto_coletivo_total" => $aguardando_pagamento_boleto_coletivo_total,
                "aguardando_pagamento_boleto_coletivo_vidas" => $aguardando_pagamento_boleto_coletivo_vidas,
                
                "quantidade_aguardando_pagamento_plano_individual" => $aguardando_individual_qtd,
                "aguardando_individual_total" => $aguardando_individual_total,
                "aguardando_individual_vidas" => $aguardando_individual_vidas,

                "atrasadoAguardandoPagAdesaoColetivo" => $atrasadoAguardandoPagAdesaoColetivo,
                "atrasadoAguardandoPagVigenciaColetivo" => $atrasadoAguardandoPagVigenciaColetivo,
                "atrasadoPlanoIndividual" => $atrasadoPlanoIndividual,

                "quantidade_pagamento_vigencia" =>  $aguardando_pagamento_vigencia,
                "aguardando_pagamento_vigencia_total" =>  $aguardando_pagamento_vigencia_total,
                "aguardando_pagamento_vigencia_vidas" =>  $aguardando_pagamento_vigencia_vidas,
                "quantidade_pagamento_empresarial" => $aguardando_pagamento_empresarial,
                "primeiros" => $primeiros,
                "ranking" => $ranking,
                "totalIndividual" => $totalIndividual,
                "totalVidasIndividual" => $totalVidasIndividual,
                "totalColetivo" => $totalColetivo,
                "totalVidasColetivo" => $totalVidasColetivo,
                "administradorasVidaTotal" => $administradorasVidaTotal,
                "totalGeralVidas" => $totalGeralVidas,
                "aguardando_individual_qtd" => $aguardando_individual_qtd,
                "mes" => $meses[(\DateTime::createFromFormat('!m', $request->mes))->format('m')]
            ]);
    }


}
