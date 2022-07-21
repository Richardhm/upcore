<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Acomodacao,
    Administradora,
    User,
    Cidade,
    Cliente,
    ComissoesCorretorLancados,
    Orcamento,
    Contrato,
    ComissoesVendedor,
    Cotacao,
    Etiquetas,
    Operadora,
    Planos,
    PremiacaoCorretoraLancadas,
    PremiacaoCorretoresLancados,
    Tarefa
};

use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Operator;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user()->admin) {
           $user = User::find(auth()->user()->id);
            if(!$user || !$user->admin) {
                return redirect()->back();
            }  
            $corretores = User::where("id","!=",$user->id)->where("corretora_id",$user->corretora_id)->get();
            $cidades = count(Cidade::all());
                        
            return view('admin.pages.home.administrador',[
                "corretores" => $corretores,
                "cidades" => $cidades
                
            ]);
        } else {

            $tarefasProximas = Tarefa::where("user_id",auth()->user()->id)
                ->where("status",0)
                ->whereDate('data',"<=",date("Y-m-d",strtotime(now()."+3day")))
                
                ->get();
            
            
            
            $tarefasAtrasadas = Tarefa::where("user_id",auth()->user()->id)
            ->where("status",0)
            ->whereDate('data','<',date('Y-m-d'))
            ->get();

            
                
            
            
            $totalCliente    = Cliente::where("user_id",auth()->user()->id)->count();
            $clienteFechados = Cotacao::where("user_id",auth()->user()->id)->whereHas('clientes',function($query){
                $query->where('etiqueta_id','=',3);
            })->count();
            $etiquetas = Etiquetas::selectRaw('id,nome,cor')->selectRaw('(SELECT count(id) FROM clientes WHERE clientes.etiqueta_id = etiquetas.id AND user_id = '.auth()->user()->id.') AS quantidade')->paginate(5);
            
            $totalComissao = ComissoesCorretorLancados::selectRaw("sum(valor) as total")->where("user_id",auth()->user()->id)->where("status",1)->whereRaw("MONTH(DATA) = MONTH(NOW())")->first()->total;
            
            $totalPremiacao = PremiacaoCorretoresLancados::where("user_id",auth()->user()->id)->where("status",1)->whereRaw("MONTH(DATA) = MONTH(NOW())")->selectRaw('sum(total) as total')->first()->total;
            $totalVidas = DB::table('cotacao_faixa_etarias')
            ->selectRaw("SUM(quantidade) as soma_vidas")
            ->whereRaw("cotacao_id IN 
            (SELECT cotacao_id FROM comissoes WHERE comissoes.user_id = ".auth()->user()->id." AND comissoes.status = 1 AND MONTH(DATA) = MONTH(NOW()))")->first()->soma_vidas;
            
            

            return view('admin.pages.home.colaborador',[
                "totalCliente" => $totalCliente,
                "clienteFechados" => $clienteFechados,
                "etiquetas" => $etiquetas,
                "totalComissao" => $totalComissao,
                "totalPremiacao" => $totalPremiacao,
                "totalMes" => $totalComissao + $totalPremiacao,
                "totalVidas" => $totalVidas,
                "tarefasProximas" => $tarefasProximas,
                
                "tarefasAtrasadas" => $tarefasAtrasadas
            ]);    
        }
    }

    // public function orcamentosAdministrador(Request $request)
    // {
    //     if($request->ajax()) {
    //         $user = User::find(auth()->user()->id);
    //         if(!$user || !$user->admin) {
    //              return redirect()->back();
    //         }  
    //         $orcamentos = $user
    //             ->orcamentos()
    //             ->selectRaw("(SELECT nome FROM clientes WHERE clientes.id = orcamentos.cliente_id) AS cliente")
    //             //->selectRaw("(SELECT nome FROM administradoras WHERE administradoras.id = orcamentos.administradora_id) AS administradora")
    //             ->selectRaw("(SELECT COUNT(*) FROM cliente_orcamento WHERE cliente_orcamento.cliente_id = orcamentos.cliente_id) AS quantidade")
    //             ->groupByRaw("orcamentos.cliente_id")
    //             ->get();
    //         return response()->json($orcamentos);
    //     }
       
    // }

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
        // $rules = [
        //     "operadora_search" => "required",
        //     "administradora_search" => "required",
        //     "planos_search" => "required",
        //     "coparticipacao_search" => "required",
        //     "odonto_search" => "required",
        //     "cidade_search" => "required"
        // ];

        // $message = [
        //     "operadora_search.required" => "O campo operadora e campo obrigatorio",
        //     "administradora_search.required" => "O campo administradora e campo obrigatorio",
        //     "planos_search.required" => "O campo plano e campo obrigatorio",
        //     "coparticipacao_search.required" => "O campo coparticipacao e campo obrigatorio",
        //     "odonto_search.required" => "O campo odonto e campo obrigatorio",
        //     "cidade_search.required" => "O campo cidade e campo obrigatorio"
        // ];

        // $request->validate($rules,$message);

        // $operadora = $request->operadora_search;
        // $administradora = $request->administradora_search;
        // $planos = $request->planos_search;
        // $coparticipacao = ($request->coparticipacao_search == "sim" ? 1 : 0);
        // $odonto = ($request->odonto_search == "sim" ? 1 : 0);
        // $cidade = $request->cidade_search;
       

        // $tabelas = DB::select("SELECT faixas,apartamento,id_apartamento,enfermaria,id_enfermaria,ambulatorial,id_ambulatorial FROM (
        //         select 
        //             (SELECT nome FROM faixas_etarias WHERE faixas_etarias.id = fora.faixa_etaria) AS faixas,
        //             (SELECT valor FROM tabelas AS dentro where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND cidade_id = ".$cidade." AND modelo = 'Apartamento' AND dentro.faixa_etaria = fora.faixa_etaria) AS apartamento, 
        //             (SELECT id FROM tabelas AS dentro where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND cidade_id = ".$cidade." AND modelo = 'Apartamento' AND dentro.faixa_etaria = fora.faixa_etaria) AS id_apartamento,
        //             (SELECT valor FROM tabelas as dentro where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND cidade_id = ".$cidade." AND modelo = 'Enfermaria' AND dentro.faixa_etaria = fora.faixa_etaria) AS enfermaria,
        //             (SELECT id FROM tabelas AS dentro where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND cidade_id = ".$cidade." AND modelo = 'Enfermaria' AND dentro.faixa_etaria = fora.faixa_etaria) AS id_enfermaria,
        //             (SELECT valor FROM tabelas as dentro where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND cidade_id = ".$cidade." AND modelo = 'Ambulatorial' AND dentro.faixa_etaria = fora.faixa_etaria) AS ambulatorial, 
        //             (SELECT id FROM tabelas as dentro where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND cidade_id = ".$cidade." AND modelo = 'Ambulatorial' AND dentro.faixa_etaria = fora.faixa_etaria) AS id_ambulatorial 
        //             from tabelas AS fora 
        //             where administradora_id = ".$administradora." AND plano_id = ".$planos." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND cidade_id = ".$cidade." GROUP BY faixa_etaria ORDER BY id) AS full_tabela");


        $operadoras = Operadora::all();
        $administradoras = Administradora::all();
        $tipos = Planos::all();    
        $modelos = Acomodacao::all();
            

        // return view("admin.pages.home.search",[
        //         "header" => "",
        //         "tabelas" => $tabelas,
        //         "operadoras" => $operadoras,
        //         "administradoras" => $administradoras,
        //         "tipos" => $tipos,
        //         "modelos" => $modelos,
        //         "operadora_id" => $operadora ?? "",
        //         "administradora_id" => $administradora ?? "",
        //         "plano_id" => !empty($planos) ? $planos : "",
        //         "cidade_id" => !empty($cidade) ? $cidade : "",    
        //         "coparticipacao" => ($request->coparticipacao_search == "sim" ? 1 : 0),
        //         "odonto" => ($request->odonto_search == "sim" ? 1 : 0),
        //         "coparticipacao_texto" => ($request->coparticipacao_search == "sim" ? "Com Coparticipacao" : "Sem Coparticipacao"),
        //         "odonto_texto" => ($request->odonto_search == "sim" ? "Com Odonto" : "Sem Odonto"),
        //         "administradora_texto" => Administradora::where("id",$request->administradora_search)->selectRaw("nome")->first()->nome
        //     ]);    
        
        

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
            "operadora_search.required" => "O campo operadora e campo obrigatorio",
            "administradora_search.required" => "O campo administradora e campo obrigatorio",
            "planos_search.required" => "O campo plano e campo obrigatorio",
            "coparticipacao_search.required" => "O campo coparticipacao e campo obrigatorio",
            "odonto_search.required" => "O campo odonto e campo obrigatorio",
            "cidade_search.required" => "O campo cidade e campo obrigatorio"
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






}
