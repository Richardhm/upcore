<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComissoesCorretoresConfiguracoes;
use App\Models\User;
use App\Models\Administradora;
use App\Models\Cidade;
use App\Models\Planos;
use App\Models\PremiacaoCorretoresConfiguracoes;

class ComissoesCorretoresConfiguracoesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:configuracoes']);
    }


    public function index($id)
    {
        $administradoras = Administradora::all();
        $planos = Planos::all();
        $cidades = Cidade::all();
        $corretor = User::where("id",$id)->first();        
        if(!$corretor) {
            return redirect()->back();
        }

        $comissoes = ComissoesCorretoresConfiguracoes::where("user_id",$id)
            ->selectRaw("user_id")
            ->selectRaw("(SELECT nome FROM planos WHERE planos.id = comissoes_corretores_configuracoes.plano_id) as plano")
            ->selectRaw("(SELECT id FROM planos WHERE planos.id = comissoes_corretores_configuracoes.plano_id) as id_plano")
            ->selectRaw("(SELECT nome FROM administradoras WHERE administradoras.id = comissoes_corretores_configuracoes.administradora_id) as administradora")
            ->selectRaw("(SELECT id FROM administradoras WHERE administradoras.id = comissoes_corretores_configuracoes.administradora_id) as id_administradora")
            ->selectRaw("(SELECT nome FROM cidades WHERE cidades.id = comissoes_corretores_configuracoes.cidade_id) as cidade")
            ->selectRaw("(SELECT id FROM cidades WHERE cidades.id = comissoes_corretores_configuracoes.cidade_id) as id_cidade")
            ->selectRaw("(SELECT GROUP_CONCAT(valor) FROM comissoes_corretores_configuracoes AS dentro WHERE dentro.plano_id = comissoes_corretores_configuracoes.plano_id AND dentro.administradora_id = comissoes_corretores_configuracoes.administradora_id AND dentro.cidade_id = comissoes_corretores_configuracoes.cidade_id) AS parcela")
            ->groupByRaw("administradora_id,cidade_id,plano_id")
            ->get();
        
        // $premiacoes = PremiacaoCorretoresConfiguracoes::where("user_id",$id)
        //     ->selectRaw("id")
        //     ->selectRaw("valor")
        //     ->selectRaw("(SELECT nome FROM planos WHERE planos.id = premiacao_corretores_configuracoes.plano_id) as plano")
        //     ->selectRaw("(SELECT nome FROM administradoras WHERE administradoras.id = premiacao_corretores_configuracoes.administradora_id) as administradora")
        //     ->get();         
        
        $premiacoes = PremiacaoCorretoresConfiguracoes::where("user_id",$id)
            ->selectRaw("user_id")
            ->selectRaw("(SELECT nome FROM planos WHERE planos.id = premiacao_corretores_configuracoes.plano_id) as plano")
            ->selectRaw("(SELECT id FROM planos WHERE planos.id = premiacao_corretores_configuracoes.plano_id) as id_plano")
            ->selectRaw("(SELECT nome FROM administradoras WHERE administradoras.id = premiacao_corretores_configuracoes.administradora_id) as administradora")
            ->selectRaw("(SELECT id FROM administradoras WHERE administradoras.id = premiacao_corretores_configuracoes.administradora_id) as id_administradora")
            ->selectRaw("(SELECT GROUP_CONCAT(valor,'|') FROM premiacao_corretores_configuracoes AS dentro WHERE dentro.plano_id = premiacao_corretores_configuracoes.plano_id AND dentro.administradora_id = premiacao_corretores_configuracoes.administradora_id) AS parcela")
            ->groupByRaw("administradora_id,plano_id")
            ->get();
        


        return view('admin.pages.corretores.comissoes.index',[
            "comissoes" => $comissoes,
            "corretor" => $corretor,
            "administradoras" => $administradoras,
            "planos" => $planos,
            "cidades" => $cidades,
            "premiacoes" => $premiacoes
        ]);
    }

    public function pegarParcelas(Request $request) 
    {
        $administradora = $request->administradora;
        $plano = $request->plano;
        $cidade = $request->cidade;
        $user = $request->user;
        $parcelas = ComissoesCorretoresConfiguracoes::where("administradora_id",$administradora)->where("cidade_id",$cidade)->where("plano_id",$plano)->where("user_id",$user)->get();
        return view('admin.pages.corretores.comissoes.parcelas',[
            "parcelas" => $parcelas
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
        return view('admin.pages.corretores.comissoes.create',[
            "corretor" => $corretor,
            "administradoras" => $administradoras,
            "planos" => $planos
        ]);
    }

    public function store(Request $request)
    {
        $verificar = ComissoesCorretoresConfiguracoes::where("user_id",$request->user_id)->where("plano_id",$request->plano_id)->where("cidade_id",$request->cidade_id)->where("administradora_id",$request->administradora_id)->get();
        if(count($verificar)>=1) {
            return "error";
            //return redirect()->route('comissao.corretores.cadastrar',$request->user_id)->with("errorjatem","Esse usuario já tem comissões com o plano e administradora respectivamente")->withInput($request->all());
        } else {
            $ii=1;
            foreach($request->parcelas as $k => $v):
                $cad = new ComissoesCorretoresConfiguracoes();
                $cad->user_id = $request->user_id;
                $cad->plano_id = $request->plano_id;
                $cad->cidade_id = $request->cidade_id;
                $cad->administradora_id = $request->administradora_id;
                $cad->valor = $v;
                $cad->parcela = $ii++;
                $cad->save();
            endforeach;
            return "sucesso";
        }
    }

    public function editar(Request $request) 
    {
        $administradora = $request->administradora_id;
        $cidade = $request->cidade_id;
        $plano = $request->plano_id;
        $user = $request->user_id;
        ComissoesCorretoresConfiguracoes::where("user_id",$user)->where("plano_id",$plano)->where("cidade_id",$cidade)->where("administradora_id",$administradora)->delete();
        // $del->delete();
        $ii=1;
        foreach($request->parcelas as $k => $v):
            $cad = new ComissoesCorretoresConfiguracoes();
            $cad->user_id = $user;
            $cad->plano_id = $plano;
            $cad->cidade_id = $cidade;
            $cad->administradora_id = $administradora;
            $cad->valor = $v;
            $cad->parcela = $ii++;
            $cad->save();
        endforeach;
        return "sucesso";


    }





    public function editarParcelaIndividual(Request $request) 
    {
        $id = $request->id;
        $alt = ComissoesCorretoresConfiguracoes::where("id",$id)->first();
        $alt->valor = $request->valor;
        if($alt->save()) {
            return "alterado";
        } else {
            return "error";
        }
    }

    public function detalhes($user,$plano,$administradora) 
    {
        $comissao = ComissoesCorretoresConfiguracoes::
            selectRaw("parcela,valor,id")
            ->where("user_id",$user)
            ->where("plano_id",$plano)
            ->where("administradora_id",$administradora)
            ->get();
        if(count($comissao) == 0) {
            return redirect()->back();
        }
        
        $plano = Planos::where("id",$plano)->first();
        $admin = Administradora::where("id",$administradora)->first();
        $user = User::where("id",$user)->first();
        return view('admin.pages.corretores.comissoes.detalhes',[
            "comissao" => $comissao,
            "plano" => $plano->nome,
            "admin" => $admin->nome,
            "user" => $user->name,
            "id" => $user->id
        ]);
    }

    public function deletarComissaoIndividual($user,$plano,$administradora)
    {
        ComissoesCorretoresConfiguracoes::where("user_id",$user)
            ->where("plano_id",$plano)
            ->where("administradora_id",$administradora)
            ->delete();
        
        return redirect()->route('comissao.corretores.detalhes',[$user,$plano,$administradora]);
    }

    public function deletarParcelaIndividual($id_parcela)
    {
        $parcela = ComissoesCorretoresConfiguracoes::where("id",$id_parcela)->first();
        if(!$parcela) {
            return redirect()->back();
        }
        $parcela->delete();
        return redirect()->route('comissao.corretores.detalhes',[$parcela->user_id,$parcela->plano_id,$parcela->administradora_id]);
    }





}
