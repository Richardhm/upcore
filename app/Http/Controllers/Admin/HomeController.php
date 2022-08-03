<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Acomodacao,
    Administradora,
    User,
    Cliente,
    ComissoesCorretoraLancadas,
    ComissoesCorretorLancados,
    Cotacao,
    CotacaoFaixaEtaria,
    Etiquetas,
    Operadora,
    Planos,
    PremiacaoCorretoraLancadas,
    PremiacaoCorretoresLancados,
    Tarefa
};

use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find(auth()->user()->id);       
        if($user->admin) {
            return $this->administrador();    
        } elseif($user->hasPermission('comissoes')) {
           return $this->financeiro();
        } else {
            return $this->corretor();            
        }
    }

    public function administrador()
    {
        $user = User::find(auth()->user()->id);
        if(!$user || !$user->admin) {
            return redirect()->back();
        }  
        $corretores = User::where("id","!=",$user->id)->where("corretora_id",$user->corretora_id)->get();
        $clientesTotal = count(Cliente::all());
        $clienteContratados = count(Cliente::where("etiqueta_id",3)->get());

        $tarefasProximas = Tarefa::where("status",0)
                ->whereDate('data','>',date('Y-m-d'))
                ->whereDate('data',"<=",date("Y-m-d",strtotime(now()."+3day")))
                ->count();
        
        $tarefasAtrasadas = Tarefa::where("status",0)
                ->whereDate('data','<',date('Y-m-d'))
                ->count();  
                
        $comissoesAReceber = ComissoesCorretoraLancadas::whereRaw("month(data) = month(now())")->where('status',1)->selectRaw('sum(valor) as totalComissaoAReceber')->first()->totalComissaoAReceber;
        $premiacaoAReceber = PremiacaoCorretoraLancadas::whereRaw("month(data) = month(now())")->where('status',1)->selectRaw('sum(total) as totalPremiacaoAReceber')->first()->totalPremiacaoAReceber;
        $totalComissao = ComissoesCorretorLancados::selectRaw("sum(valor) as total")->where("status",1)->whereRaw("MONTH(DATA) = MONTH(NOW())")->first()->total;
        $totalPremiacao = PremiacaoCorretoresLancados::where("status",1)->whereRaw("MONTH(DATA) = MONTH(NOW())")->selectRaw('sum(total) as total')->first()->total;            

        return view('admin.pages.home.administrador',[
            "corretores" => $corretores,
            "clientesTotal" => $clientesTotal,
            "clienteContratados" => $clienteContratados,
            "tarefasProximas" => $tarefasProximas,
            "tarefasAtrasadas" => $tarefasAtrasadas,
            "comissoesAReceber" => $comissoesAReceber,
            "premiacaoAReceber" => $premiacaoAReceber,
            "totalComissao" => $totalComissao,
            "totalPremiacao" => $totalPremiacao
            
        ]);
    }

    public function corretor()
    {
            $tarefasHoje = Tarefa::where("user_id",auth()->user()->id)
                ->where("status",0)
                ->whereDate('data',date('Y-m-d'))
                ->count();
            
            $tarefasAtrasadas = Tarefa::where("user_id",auth()->user()->id)
                ->where("status",0)
                ->whereDate('data','<',date('Y-m-d'))
                ->count();           
        
            $tarefasProximas = Tarefa::where("user_id",auth()->user()->id)
                ->where("status",0)
                ->whereDate('data','>',date('Y-m-d'))
                ->whereDate('data',"<=",date("Y-m-d",strtotime(now()."+3day")))
                ->count();

            $clientesSemTarefas = Cliente::where("user_id",auth()->user()->id)->whereNotIn('id',function($query){
                $query->select('tarefas.cliente_id');
                $query->from('tarefas');
                $query->whereRaw("user_id=".auth()->user()->id);
            })->count();


            $totalCliente    = Cliente::where("user_id",auth()->user()->id)->count();
            $totalVidasQuantidade = CotacaoFaixaEtaria::whereIn("cotacao_id",function($query){
                $query->select('cotacoes.id');
                $query->from('cotacoes');
                $query->whereRaw("cotacoes.user_id=".auth()->user()->id);
            })->selectRaw("sum(quantidade) as quantidade_total_vidas")->first()->quantidade_total_vidas;

            $totalClientesNegociados = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id",6)->whereHas('clientes',function($query){
                $query->where('etiqueta_id','=',3);
            })->count();

            $totalVidasClientesNegociados = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("user_id",auth()->user()->id);
                $query->where("financeiro_id",6);    
            })->selectRaw("SUM(quantidade) AS total_quantidade")->first()->total_quantidade;

            $totalClientesNegociacao = Cliente::where("user_id",auth()->user()->id)->where("etiqueta_id","=",3)->count();

            $vidasTotalClientesNegociacao = DB::select(DB::raw("SELECT SUM(quantidade) AS total_quantidade FROM cotacao_faixa_etarias WHERE cotacao_id IN(SELECT id FROM cotacoes WHERE cliente_id IN(SELECT id FROM clientes WHERE user_id = ".auth()->user()->id." AND etiqueta_id = 3))"));
    
            $clientesCadastradosEsseMes = DB::table('clientes')->whereRaw("user_id = ? AND MONTH(NOW()) = MONTH(created_at)",[auth()->user()->id])->count();
            
            
            $etiquetas = Etiquetas::selectRaw('id,nome,cor')->selectRaw('(SELECT count(id) FROM clientes WHERE clientes.etiqueta_id = etiquetas.id AND user_id = '.auth()->user()->id.') AS quantidade')->paginate(5);
            $totalComissao = ComissoesCorretorLancados::selectRaw("sum(valor) as total")->where("user_id",auth()->user()->id)->where("status",1)->whereRaw("MONTH(DATA) = MONTH(NOW())")->first()->total;
            $totalPremiacao = PremiacaoCorretoresLancados::where("user_id",auth()->user()->id)->where("status",1)->whereRaw("MONTH(DATA) = MONTH(NOW())")->selectRaw('sum(total) as total')->first()->total;
            
                $totalVidas = DB::table('cotacao_faixa_etarias')
                ->selectRaw("SUM(quantidade) as soma_vidas")
                ->whereRaw("cotacao_id IN 
                (SELECT cotacao_id FROM comissoes WHERE comissoes.user_id = ".auth()->user()->id." AND comissoes.status = 1 AND MONTH(DATA) = MONTH(NOW()))")->first()->soma_vidas;
            
            return view('admin.pages.home.colaborador',[
                "totalCliente" => $totalCliente,
                "totalVidasQuantidade" => $totalVidasQuantidade,
                "totalClientesNegociados" => $totalClientesNegociados,                
                "totalVidasClientesNegociados" => $totalVidasClientesNegociados,
                "totalClientesNegociacao" => $totalClientesNegociacao,
                "vidasTotalClientesNegociacao" => $vidasTotalClientesNegociacao[0]->total_quantidade,
                "clientesCadastradosEsseMes" => $clientesCadastradosEsseMes,
                "etiquetas" => $etiquetas,
                "totalComissao" => $totalComissao,
                "totalPremiacao" => $totalPremiacao,
                "totalMes" => $totalComissao + $totalPremiacao,
                "totalVidas" => $totalVidas,
                "tarefasProximas" => $tarefasProximas,
                "tarefasHoje" => $tarefasHoje,
                "tarefasAtrasadas" => $tarefasAtrasadas,
                "clientesSemTarefas" => $clientesSemTarefas
            ]);
    }

    public function financeiro()
    {
        $aguardando_boleto_coletivo = Cotacao::where("financeiro_id",1)->count();
        $aguardando_boleto_coletivo_total = Cotacao::where("financeiro_id",1)->selectRaw("sum(valor) as total")->first()->total;
        $aguardando_boleto_coletivo_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
            $query->where("financeiro_id",1);
        })->selectRaw("sum(quantidade) as total")->first()->total;
       

        $aguardando_pagamento_adesao_coletivo = Cotacao::where("financeiro_id",2)->count();
        $aguardando_pagamento_boleto_coletivo_total = Cotacao::where("financeiro_id",2)->selectRaw("sum(valor) as total")->first()->total;
        $aguardando_pagamento_boleto_coletivo_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
            $query->where("financeiro_id",2);
        })->selectRaw("sum(quantidade) as total")->first()->total;

        $aguardando_pagamento_vigencia = Cotacao::where("financeiro_id",4)->count();
        $aguardando_pagamento_vigencia_total = Cotacao::where("financeiro_id",4)->selectRaw("sum(valor) as total")->first()->total;
        $aguardando_pagamento_vigencia_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
            $query->where("financeiro_id",4);
        })->selectRaw("sum(quantidade) as total")->first()->total;



        $aguardando_pagamento_plano_individual = Cotacao::where("financeiro_id",3)->count();
       
        $aguardando_pagamento_empresarial = Cotacao::where("financeiro_id",5)->count();
        
        return view('admin.pages.home.financeiro',[
            "quantidade_aguardando_boleto_coletivo" => $aguardando_boleto_coletivo,
            "aguardando_boleto_coletivo_total" =>  $aguardando_boleto_coletivo_total,
            "aguardando_boleto_coletivo_vidas" => $aguardando_boleto_coletivo_vidas,

            "quantidade_aguardando_pagamento_adesao_coletivo" => $aguardando_pagamento_adesao_coletivo,
            "aguardando_pagamento_boleto_coletivo_total" => $aguardando_pagamento_boleto_coletivo_total,
            "aguardando_pagamento_boleto_coletivo_vidas" => $aguardando_pagamento_boleto_coletivo_vidas,

            "quantidade_aguardando_pagamento_plano_individual" => $aguardando_pagamento_plano_individual,
            
            "quantidade_pagamento_vigencia" =>  $aguardando_pagamento_vigencia,
            "aguardando_pagamento_vigencia_total" =>  $aguardando_pagamento_vigencia_total,
            "aguardando_pagamento_vigencia_vidas" =>  $aguardando_pagamento_vigencia_vidas,
            

            "quantidade_pagamento_empresarial" => $aguardando_pagamento_empresarial
        ]);
    }

    public function detalhesColaborador($id)
    {
        $user = User::find($id);
        $cargo = $user->hasPermission('comissoes') ? "Financeiro" : "Corretor";
        
        return view("admin.pages.home.detalhes",[
            "user" => $user,
            "cargo" => $cargo
        ]);
    }






    public function comissoes(Request $request)
    {
        if($request->ajax()) {
            $comissoes = ComissoesCorretorLancados::where("status",1)->where("user_id",auth()->user()->id)->whereRaw("MONTH(data) = MONTH(now())")->with("comissao","comissao.cliente","comissao.cotacao","comissao.cotacao.administradora")->get();    
            return response()->json($comissoes); 
        }    
    }

    public function premiacoes(Request $request)
    {
        if($request->ajax()) {
            
            $premiacoes = PremiacaoCorretoresLancados::where("status",1)->where("user_id",auth()->user()->id)->whereRaw("MONTH(data) = MONTH(now())")->with("comissao","comissao.cliente","comissao.cotacao","comissao.cotacao.administradora")->get();    
            return response()->json($premiacoes); 
        }    
    }

   

    public function listarTarefasHome(Request $request)
    {
        if($request->ajax()) {
            $tarefas = Tarefa::where("user_id",auth()->user()->id)->where("status",0)
            ->selectRaw('(SELECT nome FROM clientes WHERE clientes.id = tarefas.cliente_id) AS cliente')
            ->selectRaw("title")
            ->selectRaw("DATE_FORMAT(data, '%d/%m/%Y') as data")
            ->selectRaw("DATA - DATE(NOW()) AS falta")
            
            ->get();

            return $tarefas;

        } else {
            return redirect()->route("admin.home");
        }
    }

    public function listarClientesHome(Request $request)
    {
        if($request->ajax()) {
            $clientes =  Cliente::where("user_id",auth()->user()->id)->where('etiqueta_id',"!=",3)
            ->selectRaw("DATE_FORMAT(created_at, '%d/%m/%Y') as data")
            ->selectRaw("nome,telefone")    
            ->selectRaw("(SELECT cor FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS status")->get();
            return $clientes;
        } else {
            return redirect()->route("admin.home");
        }
    }


    public function searchHome()
    {
        

        $operadoras = Operadora::all();
        $administradoras = Administradora::all();
        $tipos = Planos::all();    
        $modelos = Acomodacao::all();
        return view("admin.pages.home.search",[
                "operadoras" => $operadoras,
                "administradoras" => $administradoras,
                "tipos" => $tipos,
                "modelos" => $modelos
            ]);  
    }

    public function storeSearch(Request $request)
    {
        $rules = [
            "operadora_search" => "required",
            "administradora_search" => "required",
            "planos_search" => "required",
            "coparticipacao_search" => "required",
            "odonto_search" => "required",
            "cidade_search" => "required"
        ];

        $message = [
            "operadora_search.required" => "Operadora e obrigatorio",
            "administradora_search.required" => "Administradora e obrigatorio",
            "planos_search.required" => "Plano e campo obrigatorio",
            "coparticipacao_search.required" => "Coparticipacao e obrigatorio",
            "odonto_search.required" => "Odonto e obrigatorio",
            "cidade_search.required" => "Cidade e obrigatorio"
        ];

        $request->validate($rules,$message);
        
        $operadora = $request->operadora_search;
        $administradora = $request->administradora_search;
        $planos = $request->planos_search;
        $coparticipacao = ($request->coparticipacao_search == "sim" ? 1 : 0);
        $odonto = ($request->odonto_search == "sim" ? 1 : 0);
        $cidade = $request->cidade_search;
       

        $tabelas = DB::select("SELECT faixas,apartamento,id_apartamento,enfermaria,id_enfermaria,ambulatorial,id_ambulatorial FROM (
                select 
                    (SELECT nome FROM faixas_etarias WHERE faixas_etarias.id = fora.faixa_etaria) AS faixas,
                    (SELECT valor FROM tabelas AS dentro where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND cidade_id = ".$cidade." AND modelo = 'Apartamento' AND dentro.faixa_etaria = fora.faixa_etaria) AS apartamento, 
                    (SELECT id FROM tabelas AS dentro where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND cidade_id = ".$cidade." AND modelo = 'Apartamento' AND dentro.faixa_etaria = fora.faixa_etaria) AS id_apartamento,
                    (SELECT valor FROM tabelas as dentro where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND cidade_id = ".$cidade." AND modelo = 'Enfermaria' AND dentro.faixa_etaria = fora.faixa_etaria) AS enfermaria,
                    (SELECT id FROM tabelas AS dentro where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND cidade_id = ".$cidade." AND modelo = 'Enfermaria' AND dentro.faixa_etaria = fora.faixa_etaria) AS id_enfermaria,
                    (SELECT valor FROM tabelas as dentro where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND cidade_id = ".$cidade." AND modelo = 'Ambulatorial' AND dentro.faixa_etaria = fora.faixa_etaria) AS ambulatorial, 
                    (SELECT id FROM tabelas as dentro where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND cidade_id = ".$cidade." AND modelo = 'Ambulatorial' AND dentro.faixa_etaria = fora.faixa_etaria) AS id_ambulatorial 
                    from tabelas AS fora 
                    where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND cidade_id = ".$cidade." GROUP BY faixa_etaria ORDER BY id) AS full_tabela");


        $operadoras = Operadora::all();
        $administradoras = Administradora::all();
        $tipos = Planos::all();    
        $modelos = Acomodacao::all();


        return view("admin.pages.home.search",[
                "header" => "",
                "tabelas" => $tabelas,
                "operadoras" => $operadoras,
                "administradoras" => $administradoras,
                "tipos" => $tipos,
                "modelos" => $modelos,
                "operadora_id" => $operadora ?? "",
                "administradora_id" => $administradora ?? "",
                "plano_id" => !empty($planos) ? $planos : "",
                "cidade_id" => !empty($cidade) ? $cidade : "",    
                "coparticipacao" => ($request->coparticipacao_search == "sim" ? 1 : 0),
                "odonto" => ($request->odonto_search == "sim" ? 1 : 0),
                "coparticipacao_texto" => ($request->coparticipacao_search == "sim" ? "Com Coparticipacao" : "Sem Coparticipacao"),
                "odonto_texto" => ($request->odonto_search == "sim" ? "Com Odonto" : "Sem Odonto"),
                "administradora_texto" => Administradora::where("id",$request->administradora_search)->selectRaw("nome")->first()->nome
            ]);    
    }


    public function relatorio()
    {
        $administradoras = Administradora::all();
        $planos = Planos::all();

        return view("admin.pages.home.relatorio",[
            "administradoras" => $administradoras,
            "planos" => $planos
        ]);
    }


    public function criarRelatorio(Request $request)
    {
        
        $rules = [
            "data_inicial" => "required",
            "data_final" => "required"
        ];
        $message = [
            "data_inicial.required" => "O campo data inicial e campo obrigatorio",
            "data_final.required" => "O campo data final e campo obrigatorio"
        ];
        $request->validate($rules,$message);
        $comissoes = ComissoesCorretorLancados::where("user_id",auth()->user()->id)
            ->whereHas("comissao.cotacao",function($q) use($request){
                    if(!empty($request->administradora)) {
                        $q->where("administradora_id",$request->administradora);
                    }
                    if(!empty($request->plano)) {
                        $q->where("plano_id",$request->plano);
                    }
            })
            ->whereDate("data",">=",$request->data_inicial)
            ->whereDate("data","<=",$request->data_final)

            ->where("status",1)    
            ->with(["comissao.cotacao","comissao.cliente"])
            ->get();
        
        if(count($comissoes) >= 1) {
            return view("admin.pages.home.modal",[
                "comissoes" => $comissoes,
                "data_inicial" => $request->data_inicial,
                "data_final" => $request->data_final
            ]);
        } else {
            $administradoras = Administradora::all();
            $planos = Planos::all();
            return view("admin.pages.home.relatorio",[
                "administradoras" => $administradoras,
                "planos" => $planos,
                
            ])->with("error","Não existe registro nesse periodo de tempo");
        }   
    
            
        
        
        
    }








}
