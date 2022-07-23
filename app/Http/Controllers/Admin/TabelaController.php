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
        $verificar = Tabela
                ::where("operadora_id",$request->operadora)
                ->where("administradora_id",$request->administradora)
                ->where("plano_id",$request->planos)
                ->where("cidade_id",$request->cidades)
                ->where("coparticipacao",$request->coparticipacao)
                ->where("odonto",$request->odonto)
                ->get();        
        if(count($verificar)>=1) {
            $tabelas = DB::select("SELECT faixas,apartamento,id_apartamento,enfermaria,id_enfermaria,ambulatorial,id_ambulatorial FROM (
                select 
                    (SELECT nome FROM faixas_etarias WHERE faixas_etarias.id = fora.faixa_etaria) AS faixas,
                    (SELECT valor FROM tabelas AS dentro where administradora_id = ".$request->administradora." AND plano_id = ".$request->planos." AND coparticipacao = ".($request->coparticipacao == 'sim' ? 1 : 0)." AND odonto = ".($request->odonto == 'sim' ? 1 : 0)." AND cidade_id = ".$request->cidades." AND modelo = 'Apartamento' AND dentro.faixa_etaria = fora.faixa_etaria) AS apartamento, 
                    (SELECT id FROM tabelas AS dentro where administradora_id = ".$request->administradora." AND plano_id = ".$request->planos." AND coparticipacao = ".($request->coparticipacao == 'sim' ? 1 : 0)." AND odonto = ".($request->odonto == 'sim' ? 1 : 0)." AND cidade_id = ".$request->cidades." AND modelo = 'Apartamento' AND dentro.faixa_etaria = fora.faixa_etaria) AS id_apartamento,
                    (SELECT valor FROM tabelas as dentro where administradora_id = ".$request->administradora." AND plano_id = ".$request->planos." AND coparticipacao = ".($request->coparticipacao == 'sim' ? 1 : 0)." AND odonto = ".($request->odonto == 'sim' ? 1 : 0)." AND cidade_id = ".$request->cidades." AND modelo = 'Enfermaria' AND dentro.faixa_etaria = fora.faixa_etaria) AS enfermaria,
                    (SELECT id FROM tabelas AS dentro where administradora_id = ".$request->administradora." AND plano_id = ".$request->planos." AND coparticipacao = ".($request->coparticipacao == 'sim' ? 1 : 0)." AND odonto = ".($request->odonto == 'sim' ? 1 : 0)." AND cidade_id = ".$request->cidades." AND modelo = 'Enfermaria' AND dentro.faixa_etaria = fora.faixa_etaria) AS id_enfermaria,
                    (SELECT valor FROM tabelas as dentro where administradora_id = ".$request->administradora." AND plano_id = ".$request->planos." AND coparticipacao = ".($request->coparticipacao == 'sim' ? 1 : 0)." AND odonto = ".($request->odonto == 'sim' ? 1 : 0)." AND cidade_id = ".$request->cidades." AND modelo = 'Ambulatorial' AND dentro.faixa_etaria = fora.faixa_etaria) AS ambulatorial, 
                    (SELECT id FROM tabelas as dentro where administradora_id = ".$request->administradora." AND plano_id = ".$request->planos." AND coparticipacao = ".($request->coparticipacao == 'sim' ? 1 : 0)." AND odonto = ".($request->odonto == 'sim' ? 1 : 0)." AND cidade_id = ".$request->cidades." AND modelo = 'Ambulatorial' AND dentro.faixa_etaria = fora.faixa_etaria) AS id_ambulatorial 
                    from tabelas AS fora 
                    where administradora_id = ".$request->administradora." AND plano_id = ".$request->planos." AND coparticipacao = ".($request->coparticipacao == 'sim' ? 1 : 0)." AND odonto = ".($request->odonto == 'sim' ? 1 : 0)." AND cidade_id = ".$request->cidades." GROUP BY faixa_etaria ORDER BY id) AS full_tabela");


            $operadoras = Operadora::all();
            $administradoras = Administradora::all();
            $tipos = Planos::all();    
            $modelos = Acomodacao::all();


            return view("admin.pages.tabela.search",[
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
                    "coparticipacao" => ($request->coparticipacao == "sim" ? 1 : 0),
                    "odonto" => ($request->odonto == "sim" ? 1 : 0),
                    "coparticipacao_texto" => ($request->coparticipacao == "sim" ? "Com Coparticipacao" : "Sem Coparticipacao"),
                    "odonto_texto" => ($request->odonto == "sim" ? "Com Odonto" : "Sem Odonto"),
                    "administradora_texto" => Administradora::where("id",$request->administradora)->selectRaw("nome")->first()->nome,
                    "mensagem" => "Já temos esse registro cadastrado, caso queira modificar segue abaixo"
                ]);    





        } else {
            $corretora_id = auth()->user()->corretora_id;
            $validator = Validator::make($request->all(), [
                'operadora' => ['required'],
                'administradora' => ['required'],
                'planos' => ['required'],
                'cidades' => ['required'],
                'coparticipacao' => ['required'],
                'odonto' => ['required'],
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
                "valor_apartamento.*.required" => "O campo valor e campo obrigatorio",
                "valor_enfermaria.*.required" => "O campo valor e campo obrigatorio",
                "valor_ambulatorial.*.required" => "O campo valor e campo obrigatorio"
            ]);
            if ($validator->fails()) {
                return redirect()->route('tabela.index')->withErrors($validator)->withInput();
            } 
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


        return view("admin.pages.tabela.search",[
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


    public function edit(Request $request)
    {
        $id = $request->id;
        $alt = Tabela::where("id",$id)->first();
        $alt->valor = str_replace([".",","],["","."],$request->valor);
        if($alt->save()) {
            return "alterado";
        } else {
            return "error";
        }
    }


    







}
