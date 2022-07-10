<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Administradora;
use Illuminate\Http\Request;
use App\Models\Operadora;
use App\Models\FaixaEtaria;
use App\Models\Planos;
use App\Models\Acomodacao;
use App\Models\Tabela;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TabelaController extends Controller
{
    public function search()
    {
        $operadoras = Operadora::all();
        $administradoras = Administradora::all();
        $tipos = Planos::all();    
        $modelos = Acomodacao::all();
        return view('admin.pages.tabela.search',[
            "operadoras" => $operadoras,
            "administradoras" => $administradoras,
            "tipos" => $tipos,
            "modelos" => $modelos
        ]);
    }

    public function index(Request $request)
    {        
        $operadoras = Operadora::all();
        $administradoras = Administradora::all();
        $tipos = Planos::all();    
        $modelos = Acomodacao::all();
        $faixas = FaixaEtaria::all();       
        return view('admin.pages.tabela.index',[
            "operadoras" => $operadoras,
            "administradoras" => $administradoras,
            "tipos" => $tipos,
            "modelos" => $modelos,
            "faixas" => $faixas
        ]);
    }

    public function pegarCidadeAdministradora(Request $request)
    {
        $administradora = $request->administradora;
        /** Pegar Planos */
        $planos = DB::table('administradora_planos')
            ->selectRaw("administradora_id,plano_id")
            ->selectRaw("(SELECT nome FROM planos WHERE planos.id = administradora_planos.plano_id) AS nome_plano")
            ->whereRaw("administradora_id = ".$administradora)
            ->get();

        /** Pegar Cidade */
        $cidades = DB::table('administradora_cidade')
            ->selectRaw("administradora_id,cidade_id")
            ->selectRaw("(SELECT nome FROM cidades WHERE cidades.id = administradora_cidade.cidade_id) AS nome_cidade")
            ->whereRaw("administradora_id = ".$administradora)
            ->get();

        
        $citys = [];
        if(count($cidades) >= 1) {
            foreach($cidades as $c) {
                $citys[] = [
                    "id" => $c->cidade_id,
                    "nome" => $c->nome_cidade 

                ];
            }
        }
        return [
            "citys" => $citys,
            "planos" => $planos
        ];
        
    }









    public function store(Request $request)
    {
        
        
        $corretora_id = auth()->user()->corretora_id;
        $validator = Validator::make($request->all(), [
            'operadora' => ['required'],
            'administradora' => ['required'],
            'planos' => ['required'],
            'cidades' => ['required'],
            'coparticipacao' => ['required'],
            'odonto' => ['required'],
            //'modelo_id' => ['required'],
            'valor_apartamento.*' => ['required'],
            'valor_enfermaria.*' => ['required'],
            'valor_ambulatorial.*' => ['required']
        ],[
            "operadora.required" => "O campo titulo e campo obrigatorio",
            "administradora.required" => "O campo administradora e campo obrigatorio",
            "planos.required" => "O campo planos e campo obrigatorio",
            "cidades.required" => "O campo cidade e campo obrigatorio",
            "coparticipacao.required" => "O campo coparticipacao e campo obrigatorio",
            "odonto.required" => "O campo odonto e campo obrigatorio",
            //"modelo_id.required" => "O campo modelo_id e campo obrigatorio",
            "valor_apartamento.*.required" => "O campo valor e campo obrigatorio",
            "valor_enfermaria.*.required" => "O campo valor e campo obrigatorio",
            "valor_ambulatorial.*.required" => "O campo valor e campo obrigatorio"
        ]);
        if ($validator->fails()) {
            return redirect()->route('tabela.index')->withErrors($validator)->withInput();
        } 
        //dd($request->all());
        

        $corretora_id = auth()->user()->corretora_id;
        foreach($request->faixa_etaria_id_apartamento as $k => $v) {
            $tabela = new Tabela();
            $tabela->operadora_id = $request->operadora;
            $tabela->administradora_id = $request->administradora;
            $tabela->corretora_id = $corretora_id;
            $tabela->cidade_id = $request->cidades;
            $tabela->modelo = "Apartamento";
            $tabela->plano_id = $request->planos;
            $tabela->coparticipacao = ($request->coparticipacao == "sim" ? true : false);
            $tabela->odonto = ($request->odonto == "sim" ? true : false);
            $tabela->faixa_etaria = $request->faixa_etaria_id_apartamento[$k];
            $tabela->valor = str_replace([".",","],["","."],$request->valor_apartamento[$k]);
            $tabela->save();
        }

        foreach($request->faixa_etaria_id_enfermaria as $k => $v) {
            $tabela = new Tabela();
            $tabela->operadora_id = $request->operadora;
            $tabela->administradora_id = $request->administradora;
            $tabela->corretora_id = $corretora_id;
            $tabela->cidade_id = $request->cidades;
            $tabela->modelo = "Enfermaria";
            $tabela->plano_id = $request->planos;
            $tabela->coparticipacao = ($request->coparticipacao == "sim" ? true : false);
            $tabela->odonto = ($request->odonto == "sim" ? true : false);
            $tabela->faixa_etaria = $request->faixa_etaria_id_enfermaria[$k];
            $tabela->valor = str_replace([".",","],["","."],$request->valor_enfermaria[$k]);
            $tabela->save();
        }

        foreach($request->faixa_etaria_id_ambulatorial as $k => $v) {
            $tabela = new Tabela();
            $tabela->operadora_id = $request->operadora;
            $tabela->administradora_id = $request->administradora;
            $tabela->corretora_id = $corretora_id;
            $tabela->cidade_id = $request->cidades;
            $tabela->modelo = "Ambulatorial";
            $tabela->plano_id = $request->planos;
            $tabela->coparticipacao = ($request->coparticipacao == "sim" ? true : false);
            $tabela->odonto = ($request->odonto == "sim" ? true : false);
            $tabela->faixa_etaria = $request->faixa_etaria_id_ambulatorial[$k];
            $tabela->valor = str_replace([".",","],["","."],$request->valor_ambulatorial[$k]);
            $tabela->save();
        }
        return redirect()->route('tabela.index');
    }

    public function pesquisar(Request $request)
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
        $search = Tabela::where(function($query) use($request){
            if($request->operadora_search) {
                $query->whereRaw("operadora_id = ".$request->operadora_search);
            } 
            if($request->administradora_search) {
                $query->whereRaw("administradora_id = ".$request->administradora_search);
            }
            if($request->planos_search) {
                $query->whereRaw("plano_id = '".$request->planos_search."'");
            }
            if($request->coparticipacao_search) {
                $coparticipacao = ($request->coparticipacao_search == "sim" ? 1 : 0);
                $query->whereRaw("coparticipacao = ".$coparticipacao);
            }
            if($request->odonto_search) {
                $odonto = ($request->odonto_search == "sim" ? 1 : 0);
                $query->whereRaw("odonto = ".$odonto);
            }
            if($request->cidade_search) {
                $query->whereRaw("cidade_id = '".$request->cidade_search."'");
            }
            if($request->modelo_id_search) {
                $query->whereRaw("modelo = '".$request->modelo_id_search."'");
            }
        })->get();
        
               
        if($search->count() >= 1) {
            $header = DB::table('tabelas')
                ->selectRaw("(SELECT nome FROM administradoras WHERE tabelas.administradora_id = administradoras.id) AS administradora")
                ->selectRaw('IF(coparticipacao = 1, CONCAT(" Com Coparticipacao"), CONCAT(" Sem Coparticipacao")) AS "COPARTICIPACAO_TEXTO"')
                ->selectRaw('IF(odonto = 0,"Nosso Plano S/Odonto","Nosso Plano C/Odonto") AS ODONTO_TEXTO')
                ->whereRaw("administradora_id = ".$administradora." AND plano_id = '".$planos."' AND odonto = '".$odonto."' AND cidade_id = '".$cidade."' ")
                ->groupBy("COPARTICIPACAO_TEXTO")
                ->get();
             
            
            $tabelas = DB::table('tabelas as fora')
                ->selectRaw('faixa_etaria')
                ->selectRaw("(SELECT nome FROM faixas_etarias WHERE faixas_etarias.id = fora.faixa_etaria) AS etaria")
                ->selectRaw("(CASE WHEN(SELECT COUNT(*) FROM tabelas WHERE modelo = 'Apartamento') >= 1 THEN (SELECT valor FROM tabelas AS dentro_apartamento WHERE modelo = 'Apartamento' AND fora.faixa_etaria = dentro_apartamento.faixa_etaria AND administradora_id = ".$administradora." AND plano_id = '".$planos."' AND odonto = '".$odonto."' GROUP BY faixa_etaria) END) AS apartamento")
                ->selectRaw("(CASE WHEN(SELECT COUNT(*) FROM tabelas WHERE modelo = 'Apartamento') >= 1 THEN (SELECT id FROM tabelas AS dentro_apartamento WHERE modelo = 'Apartamento' AND fora.faixa_etaria = dentro_apartamento.faixa_etaria AND administradora_id = ".$administradora." AND plano_id = '".$planos."' AND odonto = '".$odonto."' GROUP BY faixa_etaria) END) AS apartamento_id")
                ->selectRaw("(CASE WHEN(SELECT COUNT(*) FROM tabelas WHERE modelo = 'Enfermaria') >= 1 THEN (SELECT valor FROM tabelas AS dentro_enfermaria WHERE modelo = 'Enfermaria' AND fora.faixa_etaria = dentro_enfermaria.faixa_etaria AND administradora_id = ".$administradora." AND plano_id = '".$planos."' AND odonto = '".$odonto."' GROUP BY faixa_etaria) END) AS enfermaria")
                ->selectRaw("(CASE WHEN(SELECT COUNT(*) FROM tabelas WHERE modelo = 'Enfermaria') >= 1 THEN (SELECT id FROM tabelas AS dentro_enfermaria WHERE modelo = 'Enfermaria' AND fora.faixa_etaria = dentro_enfermaria.faixa_etaria AND administradora_id = ".$administradora." AND plano_id = '".$planos."' AND odonto = '".$odonto."' GROUP BY faixa_etaria) END) AS enfermaria_id")
                ->selectRaw("(CASE WHEN(SELECT COUNT(*) FROM tabelas WHERE modelo = 'Ambulatorial') >= 1 THEN (SELECT valor FROM tabelas AS dentro_ambulatorial WHERE modelo = 'Ambulatorial' AND fora.faixa_etaria = dentro_ambulatorial.faixa_etaria AND administradora_id = ".$administradora." AND plano_id = '".$planos."' AND odonto = '".$odonto."' GROUP BY faixa_etaria) END) AS ambulatorial")
                ->selectRaw("(CASE WHEN(SELECT COUNT(*) FROM tabelas WHERE modelo = 'Ambulatorial') >= 1 THEN (SELECT id FROM tabelas AS dentro_ambulatorial WHERE modelo = 'Ambulatorial' AND fora.faixa_etaria = dentro_ambulatorial.faixa_etaria AND administradora_id = ".$administradora." AND plano_id = '".$planos."' AND odonto = '".$odonto."' GROUP BY faixa_etaria) END) AS ambulatorial_id")
                ->whereRaw("administradora_id = ".$administradora." AND plano_id = '".$planos."' AND coparticipacao = '".$coparticipacao."' AND odonto = '".$odonto."' AND cidade_id = '".$cidade."' ")
                ->groupBy("faixa_etaria")
                ->orderByRaw("fora.id")
                ->get();    
                $operadoras = Operadora::all();
                $administradoras = Administradora::all();
                $tipos = Planos::all();    
                $modelos = Acomodacao::all();
            return view("admin.pages.tabela.search",[
                "header" => $header,
                "tabelas" => $tabelas,
                "operadoras" => $operadoras,
                "administradoras" => $administradoras,
                "tipos" => $tipos,
                "modelos" => $modelos,
                "operadora_id" => $operadora ?? "",
                "administradora_id" => $administradora ?? "",
                "plano_id" => $planos ?? "",
                "cidade_id" => $cidade ?? "",
                "coparticipacao" => ($request->coparticipacao_search == "sim" ? 1 : 0),
                "odonto" => ($request->odonto_search == "sim" ? 1 : 0)
            ]);
        } else {
            $operadoras = Operadora::all();
            $administradoras = Administradora::all();
            $tipos = Planos::all();    
            $modelos = Acomodacao::all();
            $header = "";
            $tabelas = "";
            return view("admin.pages.tabela.search",[
                "header" => $header,
                "tabelas" => $tabelas,
                "operadoras" => $operadoras,
                "administradoras" => $administradoras,
                "tipos" => $tipos,
                "modelos" => $modelos,
                "operadora_id" => $operadora ?? "",
                "administradora_id" => $administradora ?? "",
                "coparticipacao" => ($request->coparticipacao_search == "sim" ? 1 : 0),
                "odonto" => ($request->odonto_search == "sim" ? 1 : 0)
            ]);


        }
        
            


    }







}
