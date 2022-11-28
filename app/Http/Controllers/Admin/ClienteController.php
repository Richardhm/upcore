<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\{
    Cidade,
    Cliente,
    Etiquetas,
    User,
    Administradora,
    AdministradoraCidade,
    ComissoesCorretoresConfiguracoes,
    Cotacao,
    EstagioClientes,
    Operadora,
    Origem,
    Planos,
    Tarefa,
    TarefaMotivoPerda,
    TarefasTitulo
};
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    private $repository;

    public function __construct(Cliente $cliente)
    {
        $this->repository = $cliente;     
    }

    public function index()
    {
        $id = auth()->user()->id;
        $user = User::where("id",$id)->first();
        $admin = ($user->admin == 1 ? 'sim' : 'nao');

        if($user->hasPermission('configuracoes') || $user->isAdmin()) {  
            
            $clientes = Cliente::selectRaw("(SELECT name FROM users WHERE users.id = clientes.user_id) as user")
                ->selectRaw("nome,etiqueta_id,email,created_at,ultimo_contato,telefone,pessoa_fisica,pessoa_juridica,id")
                ->selectRaw("(SELECT nome FROM cidades WHERE cidades.id = clientes.cidade_id) AS cidade")
                ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE tarefas.cliente_id = clientes.id) AS tarefas_quantidade")
                ->selectRaw("(SELECT if(SUM(quantidade) >= 1,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id = (SELECT id FROM cotacoes WHERE cotacoes.cliente_id = clientes.id)) AS quantidade")
                ->selectRaw("(SELECT cor FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS cor")
                ->selectRaw("(SELECT nome FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS nome_etiqueta")        
                ->orderByRaw("id DESC")
                ->paginate();

            $clientesAll = Cliente::selectRaw("nome,etiqueta_id,email,created_at,ultimo_contato,telefone,pessoa_fisica,pessoa_juridica,id")
                ->selectRaw("(SELECT nome FROM cidades WHERE cidades.id = clientes.cidade_id) AS cidade")
                ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE tarefas.cliente_id = clientes.id) AS tarefas_quantidade")
                ->selectRaw("(SELECT if(SUM(quantidade) >= 1,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id = (SELECT id FROM cotacoes WHERE cotacoes.cliente_id = clientes.id)) AS quantidade")
                ->selectRaw("(SELECT cor FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS cor")
                ->selectRaw("(SELECT nome FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS nome_etiqueta")
                ->orderByRaw("id DESC")
                ->get();    
                
            $etiquetas = Etiquetas::all();
            return view('admin.pages.clientes.index',[
                'clientes' => $clientes,
                'etiquetas' => $etiquetas,
                'clientesAll' => $clientesAll,
                "administrador" => $admin
            ]);
        } else {
                $clientes = 
                 Cliente::where("user_id",$id)
                 ->where("etiqueta_id","!=",3)
                ->selectRaw("nome,etiqueta_id,email,created_at,ultimo_contato,telefone,pessoa_fisica,pessoa_juridica,id")
                ->selectRaw("(SELECT nome FROM cidades WHERE cidades.id = clientes.cidade_id) AS cidade")
                ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE tarefas.cliente_id = clientes.id) AS tarefas_quantidade")
                ->selectRaw("(SELECT if(SUM(quantidade) >= 1,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id = (SELECT id FROM cotacoes WHERE cotacoes.cliente_id = clientes.id)) AS quantidade")
                ->selectRaw("(SELECT cor FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS cor")
                ->selectRaw("(SELECT nome FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS nome_etiqueta")
                ->orderByRaw("id DESC")
                ->paginate();

                $clientesAll = 
                Cliente::where("user_id",$id)
                ->where("etiqueta_id","!=",3)
                ->selectRaw("nome,etiqueta_id,email,created_at,ultimo_contato,telefone,pessoa_fisica,pessoa_juridica,id")
                ->selectRaw("(SELECT nome FROM cidades WHERE cidades.id = clientes.cidade_id) AS cidade")
                ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE tarefas.cliente_id = clientes.id) AS tarefas_quantidade")
                ->selectRaw("(SELECT if(SUM(quantidade) >= 1,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id = (SELECT id FROM cotacoes WHERE cotacoes.cliente_id = clientes.id)) AS quantidade")
                ->selectRaw("(SELECT cor FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS cor")
                ->selectRaw("(SELECT nome FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS nome_etiqueta")
                ->orderByRaw("id DESC")
                ->get();

            $etiquetas = Etiquetas::all();
            return view('admin.pages.clientes.index',[
                'clientes' => $clientes,
                'etiquetas' => $etiquetas,
                'clientesAll' => $clientesAll,
                "administrador" => $admin
            ]);

        }
    }

    // public function pegarTodosOsClientesPF(Request $request)
    // {
    //     $visivel = 1;
    //     $clientes = Cliente::
    //             where("user_id",auth()->user()->id)
    //             ->where("visivel",1)
    //             ->where("lead",0)
    //             ->where("pessoa_fisica",1)
    //             ->whereHas('cotacao',function($query){
    //                 $query->whereRaw('financeiro_id IS NULL');
    //             })
                
    //             ->whereHas('tarefas',function($query) use($visivel){
    //                 $query->where("user_id",auth()->user()->id);
    //                 $query->whereRaw("motivo_id IS NULL");
    //                 $query->where("visivel",$visivel);
    //             })
    //             ->with('tarefas',function($query) use($visivel){
    //                 $query->where("status",0);
    //                 $query->where("visivel",$visivel)
    //                 ->with('titulo');
    //             })
    //             ->with(['cidade','origem','etiqueta','cotacao.somarCotacaoFaixaEtaria'])
    //             ->get();
    //     return $clientes;        
    // }




    public function listarPessoaFisica()
    {
        
        $titulos = TarefasTitulo::where("id","!=",1)->get();
        $clientes_total = Cliente::where("user_id",auth()->user()->id)
                                ->where('pessoa_fisica',1)
                                ->whereHas('cotacao',function($query){
                                    $query->whereRaw("financeiro_id IS NULL");
                                })->where('visivel',1)->where('lead',0)->count();
       $motivos = TarefaMotivoPerda::all();
        $tarefas = Tarefa
            ::selectRaw("(SELECT COUNT(id) FROM tarefas WHERE DATA < DATE(NOW()) AND user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_fisica = 1 AND visivel = 1 AND lead = 0 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS atrasada")    
            ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE DATA = DATE(NOW()) AND user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_fisica = 1 AND visivel = 1 AND lead = 0 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS hoje")
            ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND data > now() AND user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_fisica = 1 AND lead = 0 AND visivel = 1 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS semana")
            ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE MONTH(DATA) = MONTH(NOW()) AND user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_fisica = 1 AND visivel = 1 AND lead = 0 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS mes")
            ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_fisica = 1 AND visivel = 1 AND lead = 0 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS todas")
            ->whereRaw("user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL")
            ->first();
        $estagios = EstagioClientes::
            selectRaw('id,nome')
            ->selectRaw('(SELECT COUNT(*) FROM clientes WHERE clientes.estagio_id = estagio_clientes.id AND lead = 0 AND pessoa_fisica = 1 AND id IN(SELECT cliente_id FROM cotacoes WHERE cotacoes.cliente_id = clientes.id AND financeiro_id IS NULL)) AS quantidade')
            ->get();
        return view('admin.pages.tarefas.page',[           
            'clientes_total' => $clientes_total,
            'tarefas' => $tarefas,
            'estagios' => $estagios,
            'titulos' => $titulos,
            'motivos' => $motivos,
           
        ]);
    }

    public function searchContratosPF(Request $request)
    {
        $id = $request->id;
        return Cotacao
            ::where("financeiro_id",$id)
            ->where("user_id",auth()->user()->id)
            ->get();
    }




    public function listarPessoaJuridica()
    {
        
        $titulos = TarefasTitulo::where("id","!=",1)->get();
        $clientes_total = Cliente::where("user_id",auth()->user()->id)
                                ->where('pessoa_juridica',1)
                                ->whereHas('cotacao',function($query){
                                    $query->whereRaw("financeiro_id IS NULL");
                                })->where('visivel',1)->where('lead',0)->count();
                                
       $motivos = TarefaMotivoPerda::all();
        $tarefas = Tarefa
            ::selectRaw("(SELECT COUNT(id) FROM tarefas WHERE DATA < DATE(NOW()) AND user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_juridica = 1 AND visivel = 1 AND lead = 0 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS atrasada")    
            ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE DATA = DATE(NOW()) AND user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_juridica = 1 AND visivel = 1 AND lead = 0 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS hoje")
            ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND data > now() AND user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_juridica = 1 AND lead = 0 AND visivel = 1 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS semana")
            ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE MONTH(DATA) = MONTH(NOW()) AND user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_juridica = 1 AND visivel = 1 AND lead = 0 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS mes")
            ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_juridica = 1 AND visivel = 1 AND lead = 0 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS todas")
            ->whereRaw("user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL")
            ->first();
            
        $estagios = EstagioClientes::
            selectRaw('id,nome')
            ->selectRaw('(SELECT COUNT(*) FROM clientes WHERE clientes.estagio_id = estagio_clientes.id AND lead = 0 AND pessoa_juridica = 1 AND id IN(SELECT cliente_id FROM cotacoes WHERE cotacoes.cliente_id = clientes.id AND financeiro_id IS NULL)) AS quantidade')
            ->get();
            
        return view('admin.pages.tarefas.juridico',[           
            'clientes_total' => $clientes_total,
            'tarefas' => $tarefas,
            'estagios' => $estagios,
            'titulos' => $titulos,
            'motivos' => $motivos,
           
        ]);




    }

   

    public function listarClientesAjaxPF(Request $request)
    {
        $id_user = auth()->user()->id;
        $visivel = 1;
        $clientes = Cliente
            ::where("user_id",$id_user)
            ->where('pessoa_fisica',1)
            ->where('lead',0)
            ->where("visivel",$visivel)
            ->whereHas('cotacao',function($query){
                $query->whereRaw('financeiro_id IS NULL');
            })
        ->whereHas('tarefas',function($query) use($visivel){
            $query->where("user_id",auth()->user()->id);
            $query->whereRaw("motivo_id IS NULL");
            $query->where("visivel",$visivel);
        })
        ->with('tarefas',function($query) use($visivel){
            $query->where("status",0);
            $query->where("visivel",$visivel)
            ->with('titulo');
        })
        ->with(['cidade','origem','etiqueta','cotacao.somarCotacaoFaixaEtaria'])
        ->orderBy('clientes.updated_at','DESC')
        ->get();
        return $clientes;
    }

    public function listarClientesAjaxPJ(Request $request)
    {
        $id_user = auth()->user()->id;
        $visivel = 1;
        $clientes = Cliente
            ::where("user_id",$id_user)
            ->where('pessoa_juridica',1)
            ->where('lead',0)
            ->where("visivel",$visivel)
            ->whereHas('cotacao',function($query){
                $query->whereRaw('financeiro_id IS NULL');
            })
            ->whereHas('tarefas',function($query) use($visivel){
                $query->where("user_id",auth()->user()->id);
                $query->whereRaw("motivo_id IS NULL");
                $query->where("visivel",$visivel);
            })
            ->with('tarefas',function($query) use($visivel){
                $query->where("status",0);
                $query->where("visivel",$visivel)
                ->with('titulo');
            })
            ->with(['cidade','etiqueta','cotacao.somarCotacaoFaixaEtaria'])
            ->orderBy('clientes.updated_at','DESC')
            ->get();
            return $clientes;
    }

    public function pegarClientesAjaxId(Request $request)
    {
        $id = $request->id;
        $visivel = 1;
        $clientes = Cliente
            ::where("user_id",auth()->user()->id)
            ->where("lead",0)
            ->where("visivel",1)
            ->where("estagio_id",$id)
            ->where("pessoa_fisica",1)
            ->whereHas('cotacao',function($query){
                $query->whereRaw('financeiro_id IS NULL');
            })
            ->whereHas('tarefas',function($query) use($visivel){
                        $query->where("visivel",$visivel);
                    })
                    ->with('tarefas',function($query) use($visivel){
                        $query->where("visivel",$visivel)->with('titulo');
                    })
                    ->with(['cidade','origem','etiqueta','cotacao.somarCotacaoFaixaEtaria'])
            ->get();
        return $clientes;    

    }

    public function pegarClientesAjaxIdPJ(Request $request)
    {
        $id = $request->id;
        $visivel = 1;
        $clientes = Cliente
            ::where("user_id",auth()->user()->id)
            ->where("lead",0)
            ->where("visivel",1)
            ->where("estagio_id",$id)
            ->where("pessoa_juridica",1)
            ->whereHas('cotacao',function($query){
                $query->whereRaw('financeiro_id IS NULL');
            })
            ->whereHas('tarefas',function($query) use($visivel){
                        $query->where("visivel",$visivel);
                    })
                    ->with('tarefas',function($query) use($visivel){
                        $query->where("visivel",$visivel)->with('titulo');
                    })
                    ->with(['cidade','etiqueta','cotacao.somarCotacaoFaixaEtaria'])
            ->get();
        return $clientes;    

    }

    public function pegarClientesAjaxIdPost(Request $request)
    {
        $id = $request->id;
        $clientes = Cliente::where("user_id",auth()->user()->id)
                    ->where("id",$id)
                    // ->with(['cidade','origem'])
            ->first();
        return $clientes;    
    }

    public function editarClienteAjax(Request $request) 
    {
        $id = $request->editar_cliente_id;
        $cliente = Cliente::where("id",$id)->first();
        $cliente->nome = $request->editar_nome;
        $cliente->email = $request->editar_email;
        $cliente->cidade_id = $request->editar_cidade_id;
        $cliente->telefone = $request->editar_telefone;
        $cliente->origem_id = $request->editar_origem_id;
        $cliente->save();
        return $cliente;
    }

    public function editarClienteAjaxJuridico(Request $request) 
    {
        $id = $request->editar_cliente_id;
        $cliente = Cliente::where("id",$id)->first();
        $cliente->cnpj = $request->editar_cnpj;
        $cliente->nome_empresa = $request->editar_nome_empresa;
        $cliente->telefone_empresa = $request->editar_telefone_empresa;
        $cliente->email = $request->email;
        $cliente->telefone = $request->telefone;
        $cliente->cidade_id = $request->editar_cidade_id;
        $cliente->save();    
        return $cliente;
    }



    public function mudarEstagioCliente(Request $request)
    {
        $id = $request->id;
        $ci = $request->cliente;
        $cliente = Cliente::where("id",$ci)->first();
        
        if($id == 7) {
            $cliente->lead = 1;
            $cliente->estagio_id = null;
            $cliente->lead_id = 4;

            DB::table('cotacoes')->where('cliente_id', $ci)->delete();
            DB::table('tarefas')->where('cliente_id', $ci)->delete();


        } else {
            $cliente->estagio_id = $id;
        } 

        $cliente->save();

        $qtd_frio = Cliente::where("user_id",auth()->user()->id)->where("visivel",1)->where("estagio_id",1)->where('pessoa_fisica',1)->where('lead',0)->count();
        $qtd_morno = Cliente::where("user_id",auth()->user()->id)->where("visivel",1)->where("estagio_id",2)->where('pessoa_fisica',1)->where('lead',0)->count();
        $qtd_quente = Cliente::where("user_id",auth()->user()->id)->where("visivel",1)->where("estagio_id",3)->where('pessoa_fisica',1)->where('lead',0)->count();
        $qtd_aguardando_doc = Cliente::where("user_id",auth()->user()->id)->where("visivel",1)->where("estagio_id",4)->where('pessoa_fisica',1)->where('lead',0)->count();
        $qtd_aguardando_inte_futuro = Cliente::where("user_id",auth()->user()->id)->where("visivel",1)->where("estagio_id",5)->where('pessoa_fisica',1)->where('lead',0)->count();
        $qtd_aguardando_sem_interesse = Cliente::where("user_id",auth()->user()->id)->where("visivel",1)->where("estagio_id",6)->where('pessoa_fisica',1)->where('lead',0)->whereMonth("created_at",date('m'))->count();
        $qtd_total_geral = DB::table("clientes")
                ->whereRaw("clientes.pessoa_fisica = 1")
                ->whereRaw("clientes.lead = 0")
                ->whereRaw("clientes.visivel = 1")
                ->whereRaw("clientes.id NOT IN(SELECT cliente_id FROM cotacoes WHERE cotacoes.cliente_id = clientes.id AND cotacoes.financeiro_id IS NOT NULL AND cotacoes.user_id = ?)",[auth()->user()->id])
                ->count();

        $tarefas = Tarefa
            ::selectRaw("(SELECT COUNT(id) FROM tarefas WHERE DATA < DATE(NOW()) AND user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_fisica = 1 AND visivel = 1 AND lead = 0 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS atrasada")    
            ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE DATA = DATE(NOW()) AND user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_fisica = 1 AND visivel = 1 AND lead = 0 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS hoje")
            ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND data > now() AND user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_fisica = 1 AND lead = 0 AND visivel = 1 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS semana")
            ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE MONTH(DATA) = MONTH(NOW()) AND user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_fisica = 1 AND visivel = 1 AND lead = 0 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS mes")
            ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_fisica = 1 AND visivel = 1 AND lead = 0 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS todas")
            ->whereRaw("user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL")
            ->first();




        return [
            "qtd_frio" => $qtd_frio,
            "qtd_morno" => $qtd_morno,
            "qtd_quente" => $qtd_quente,
            "qtd_aguardando_doc" => $qtd_aguardando_doc,
            "qtd_aguardando_inte_futuro" => $qtd_aguardando_inte_futuro,
            "qtd_aguardando_sem_interesse" => $qtd_aguardando_sem_interesse,
            "qtd_total_geral" => $qtd_total_geral,
            "tarefas" => $tarefas
        ];
    }

    public function mudarEstagioClientePJ(Request $request)
    {
        $id = $request->id;
        $ci = $request->cliente;
        $cliente = Cliente::where("id",$ci)->first();
        
        if($id == 7) {
            $cliente->lead = 1;
            $cliente->estagio_id = null;
            $cliente->lead_id = 4;
        } else {
            $cliente->estagio_id = $id;
        } 
        $cliente->save();

        $qtd_frio = Cliente::where("user_id",auth()->user()->id)->where("visivel",1)->where("estagio_id",1)->where('pessoa_juridica',1)->where('lead',0)->count();
        $qtd_morno = Cliente::where("user_id",auth()->user()->id)->where("visivel",1)->where("estagio_id",2)->where('pessoa_juridica',1)->where('lead',0)->count();
        $qtd_quente = Cliente::where("user_id",auth()->user()->id)->where("visivel",1)->where("estagio_id",3)->where('pessoa_juridica',1)->where('lead',0)->count();
        $qtd_aguardando_doc = Cliente::where("user_id",auth()->user()->id)->where("visivel",1)->where("estagio_id",4)->where('pessoa_juridica',1)->where('lead',0)->count();
        $qtd_aguardando_inte_futuro = Cliente::where("user_id",auth()->user()->id)->where("visivel",1)->where("estagio_id",5)->where('pessoa_juridica',1)->where('lead',0)->count();
        $qtd_aguardando_sem_interesse = Cliente::where("user_id",auth()->user()->id)->where("visivel",1)->where("estagio_id",6)->where('pessoa_juridica',1)->where('lead',0)->whereMonth("created_at",date('m'))->count();
        $qtd_total_geral = DB::table("clientes")
                ->whereRaw("clientes.pessoa_juridica = 1")
                ->whereRaw("clientes.lead = 0")
                ->whereRaw("clientes.visivel = 1")
                ->whereRaw("clientes.id NOT IN(SELECT cliente_id FROM cotacoes WHERE cotacoes.cliente_id = clientes.id AND cotacoes.financeiro_id IS NOT NULL AND cotacoes.user_id = ?)",[auth()->user()->id])
                ->count();



        $tarefas = Tarefa
        ::selectRaw("(SELECT COUNT(id) FROM tarefas WHERE DATA < DATE(NOW()) AND user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_juridica = 1 AND visivel = 1 AND lead = 0 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS atrasada")    
        ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE DATA = DATE(NOW()) AND user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_juridica = 1 AND visivel = 1 AND lead = 0 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS hoje")
        ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND data > now() AND user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_juridica = 1 AND lead = 0 AND visivel = 1 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS semana")
        ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE MONTH(DATA) = MONTH(NOW()) AND user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_juridica = 1 AND visivel = 1 AND lead = 0 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS mes")
        ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL AND cliente_id IN(SELECT id FROM clientes WHERE clientes.id = tarefas.cliente_id AND clientes.pessoa_juridica = 1 AND visivel = 1 AND lead = 0 AND cliente_id IN(SELECT cliente_id FROM cotacoes WHERE financeiro_id IS NULL AND user_id = ".auth()->user()->id."))) AS todas")
        ->whereRaw("user_id = ".auth()->user()->id." AND visivel = 1 AND motivo_id IS NULL")
        ->first();



        return [
            "qtd_frio" => $qtd_frio,
            "qtd_morno" => $qtd_morno,
            "qtd_quente" => $qtd_quente,
            "qtd_aguardando_doc" => $qtd_aguardando_doc,
            "qtd_aguardando_inte_futuro" => $qtd_aguardando_inte_futuro,
            "qtd_aguardando_sem_interesse" => $qtd_aguardando_sem_interesse,
            "tarefas" => $tarefas,
            "qtd_total_geral" => $qtd_total_geral
        ];
    }



    // public function listarClientesAjaxInterreseFrio(Request $request)
    // {
    //     $id_user = auth()->user()->id;
    //     $visivel = 1;
    //     $clientes = Cliente::where("user_id",$id_user)->where('star',1)->where('pessoa_fisica',1)->where('lead',0)->where("etiqueta_id","!=",3)->where("visivel",$visivel)
    //     ->whereHas('tarefas',function($query) use($visivel){
    //         $query->where("visivel",$visivel);
    //     })
    //     ->with('tarefas',function($query) use($visivel){
    //         $query->where("visivel",$visivel)->with('titulo');
    //     })
    //     ->with(['cidade','origem','etiqueta','cotacao.somarCotacaoFaixaEtaria'])
    //     ->get();
    //     return $clientes;
    // }

    // public function listarClientesAjaxInterreseMorno(Request $request)
    // {
    //     $id_user = auth()->user()->id;
    //     $visivel = 1;
    //     $clientes = Cliente::where("user_id",$id_user)->where('star',2)->where('pessoa_fisica',1)->where('lead',0)->where("etiqueta_id","!=",3)->where("visivel",$visivel)
    //     ->whereHas('tarefas',function($query) use($visivel){
    //         $query->where("visivel",$visivel);
    //     })
    //     ->with('tarefas',function($query) use($visivel){
    //         $query->where("visivel",$visivel)->with('titulo');
    //     })
    //     ->with(['cidade','origem','etiqueta','cotacao.somarCotacaoFaixaEtaria'])
    //     ->get();
    //     return $clientes;
    // }

    // public function listarClientesAjaxInterreseQuente(Request $request)
    // {
    //     $id_user = auth()->user()->id;
    //     $visivel = 1;
    //     $clientes = Cliente::where("user_id",$id_user)->where('star',3)->where('pessoa_fisica',1)->where('lead',0)->where("etiqueta_id","!=",3)->where("visivel",$visivel)
    //     ->whereHas('tarefas',function($query) use($visivel){
    //         $query->where("visivel",$visivel);
    //     })
    //     ->with('tarefas',function($query) use($visivel){
    //         $query->where("visivel",$visivel)->with('titulo');
    //     })
    //     ->with(['cidade','origem','etiqueta','cotacao.somarCotacaoFaixaEtaria'])
    //     ->get();
    //     return $clientes;
    // }


    // public function listarClientesAjaxInterreseFrioPJ(Request $request)
    // {
    //     $id_user = auth()->user()->id;
    //     $visivel = 1;
    //     $clientes = Cliente::where("user_id",$id_user)->where('star',1)->where('pessoa_juridica',1)->where('lead',0)->where("etiqueta_id","!=",3)->where("visivel",$visivel)
    //     ->whereHas('tarefas',function($query) use($visivel){
    //         $query->where("visivel",$visivel);
    //     })
    //     ->with('tarefas',function($query) use($visivel){
    //         $query->where("visivel",$visivel)->with('titulo');
    //     })
    //     ->with(['cidade','origem','etiqueta','cotacao.somarCotacaoFaixaEtaria'])
    //     ->get();
    //     return $clientes;
    // }

    // public function listarClientesAjaxInterreseMornoPJ(Request $request)
    // {
    //     $id_user = auth()->user()->id;
    //     $visivel = 1;
    //     $clientes = Cliente::where("user_id",$id_user)->where('star',2)->where('pessoa_juridica',1)->where('lead',0)->where("etiqueta_id","!=",3)->where("visivel",$visivel)
    //     ->whereHas('tarefas',function($query) use($visivel){
    //         $query->where("visivel",$visivel);
    //     })
    //     ->with('tarefas',function($query) use($visivel){
    //         $query->where("visivel",$visivel)->with('titulo');
    //     })
    //     ->with(['cidade','origem','etiqueta','cotacao.somarCotacaoFaixaEtaria'])
    //     ->get();
    //     return $clientes;
    // }

    // public function listarClientesAjaxInterreseQuentePJ(Request $request)
    // {
    //     $id_user = auth()->user()->id;
    //     $visivel = 1;
    //     $clientes = Cliente::where("user_id",$id_user)->where('star',3)->where('pessoa_juridica',1)->where('lead',0)->where("etiqueta_id","!=",3)->where("visivel",$visivel)
    //     ->whereHas('tarefas',function($query) use($visivel){
    //         $query->where("visivel",$visivel);
    //     })
    //     ->with('tarefas',function($query) use($visivel){
    //         $query->where("visivel",$visivel)->with('titulo');
    //     })
    //     ->with(['cidade','origem','etiqueta','cotacao.somarCotacaoFaixaEtaria'])
    //     ->get();
    //     return $clientes;
    // }




    public function prospeccao()
    {
        
        $cidades = Cidade::all();
        $origens = Origem::all();
        $qtdTotal = Cliente::where("lead",1)->where("visivel",1)->where('pessoa_fisica',1)->count();
        
        $qtdAtrasado = Cliente::where("user_id",auth()->user()->id)->where('lead',1)->where("etiqueta_id","!=",3)->where("pessoa_fisica",1)->where("visivel",1)->whereDate('created_at','<',date('Y-m-d'))->count();
        $qtdHoje = Cliente::where("user_id",auth()->user()->id)->where('lead',1)->where("etiqueta_id","!=",3)->where("pessoa_fisica",1)->where("visivel",1)->whereDate('created_at','=',date('Y-m-d'))->count();    
        $qtdSemana = Cliente::where("user_id",auth()->user()->id)->where('lead',1)->where("etiqueta_id","!=",3)->where("pessoa_fisica",1)->where("visivel",1)->whereRaw("YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1) AND created_at > now()")->count();        
        $qtdMes = Cliente::where("user_id",auth()->user()->id)->where('lead',1)->where("etiqueta_id","!=",3)->where("pessoa_fisica",1)->where("visivel",1)->whereRaw("MONTH(created_at) = MONTH(NOW())")->count();        

        $qtdProps = Cliente::where("lead_id",2)->where('lead',1)->where("pessoa_fisica",1)->count();
        $qtdVendas = Cliente::where("lead_id",1)->where('lead',1)->where("pessoa_fisica",1)->count();
        $qtdAtendimento = Cliente::where("lead_id",3)->where('lead',1)->where("pessoa_fisica",1)->count();
        $qtdSemContato = Cliente::where("lead_id",4)->where('lead',1)->where("pessoa_fisica",1)->count();
       
        return view('admin.pages.clientes.prospeccao',[
            "cidades" => $cidades,
            "origem" => $origens,
            "qtdAtrasado" => $qtdAtrasado,
            "qtdHoje" => $qtdHoje,
            "qtdSemana" => $qtdSemana,
            "qtdMes" => $qtdMes,
            "qtdTotal" => $qtdTotal,
            "qtdProps" => $qtdProps,
            "qtdVendas" => $qtdVendas,
            "qtdAtendimento" => $qtdAtendimento,
            "qtdSemContato" => $qtdSemContato
        ]);   
    }

    public function leadsPJ()
    {
        
        $cidades            = Cidade::all();
        $origens            = Origem::all();
        $qtdTotal           = Cliente::where("lead",1)->where("visivel",1)->where('pessoa_juridica',1)->count();
        
        $qtdAtrasado        = Cliente::where("user_id",auth()->user()->id)->where('lead',1)->where("etiqueta_id","!=",3)->where("visivel",1)->where("pessoa_juridica",1)->whereDate('created_at','<',date('Y-m-d'))->count();
        $qtdHoje            = Cliente::where("user_id",auth()->user()->id)->where('lead',1)->where("etiqueta_id","!=",3)->where("visivel",1)->where("pessoa_juridica",1)->whereDate('created_at','=',date('Y-m-d'))->count();    
        $qtdSemana          = Cliente::where("user_id",auth()->user()->id)->where('lead',1)->where("etiqueta_id","!=",3)->where("visivel",1)->where("pessoa_juridica",1)->whereRaw("YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1) AND created_at > now()")->count();        
        $qtdMes             = Cliente::where("user_id",auth()->user()->id)->where('lead',1)->where("etiqueta_id","!=",3)->where("visivel",1)->where("pessoa_juridica",1)->whereRaw("MONTH(created_at) = MONTH(NOW())")->count();        

        $qtdProps           = Cliente::where("lead_id",2)->where('lead',1)->where("pessoa_juridica",1)->count();
        $qtdVendas          = Cliente::where("lead_id",1)->where('lead',1)->where("pessoa_juridica",1)->count();
        $qtdAtendimento     = Cliente::where("lead_id",3)->where('lead',1)->where("pessoa_juridica",1)->count();
        $qtdSemContato     = Cliente::where("lead_id",4)->where('lead',1)->where("pessoa_juridica",1)->count();

        



        return view('admin.pages.clientes.juridico',[
            "cidades"        => $cidades,
            "origem"         => $origens,
            "qtdAtrasado"    => $qtdAtrasado,
            "qtdHoje"        => $qtdHoje,
            "qtdSemana"      => $qtdSemana,
            "qtdMes"         => $qtdMes,
            "qtdTotal"       => $qtdTotal,
            "qtdProps"       => $qtdProps,
            "qtdVendas"      => $qtdVendas,
            "qtdAtendimento" => $qtdAtendimento,
            "qtdSemContato"  => $qtdSemContato
        ]);   
    }



                                                                                                                          

    public function prospeccaoExportar(Request $request)
    {
        $ids = explode(",",$request->ids);

        $clientes = Cliente::whereIn("id",$ids)->with('origem')->get();
        $pdf = PDF::loadView('admin.pages.clientes.exportar-pdf',[
            'clientes' => $clientes  
        ]);
        $nome_pdf = "exportar-clientes-"."-".date('d')."-".date('m')."-".date('Y')."-".date("H").date("i").date("s").".pdf";
        return $pdf->download($nome_pdf);
        //return $clientes;
    }

    private function verificarEmail($email) 
    {
        $email = Cliente::where("email",$email)->count();
        if($email >= 1) {
            return false;
        } else {
            return true;
        }
    }

    private function verificarFone($telefone)
    {
        $telefone = Cliente::where("telefone",$telefone)->count();
        if($telefone >= 1) {
            return false;
        } else {
            return true;
        }
    }

    private function verificarNome($nome)
    {
        $nome = Cliente::where("nome",$nome)->count();
        if($nome >= 1) {
            return false;
        } else {
            return true;
        }
    }

    


    public function prospeccaoStorePF(Request $request)
    {
        $cliente = new Cliente();
        $cliente->user_id = auth()->user()->id;
        $cliente->cidade_id = $request->cidade_id;
        $cliente->etiqueta_id = 1;
        $cliente->origem_id = $request->origem_id;
        $cliente->telefone = $request->telefone;
        $cliente->nome = $request->nome;
        $cliente->pessoa_fisica = 1;
        $cliente->pessoa_juridica = 0;
        $cliente->lead_id = 2;
        $cliente->ultimo_contato = date("Y-m-d");
        $cliente->email = $request->email;
        
        if(!$this->verificarEmail($request->email) || !$this->verificarFone($request->telefone) || !$this->verificarNome($request->nome)) {
            return "ja_existe";
        } 
        
        
        if($cliente->save()) {
            $qtd_plantao_vendas = Cliente::where("lead",1)->where("user_id",auth()->user()->id)->where("pessoa_fisica",1)->where('visivel',1)->where("etiqueta_id","!=",3)->where("lead_id",1)->count();
            $qtd_prospeccao = Cliente::where("lead",1)->where("user_id",auth()->user()->id)->where("pessoa_fisica",1)->where('visivel',1)->where("etiqueta_id","!=",3)->where("lead_id",2)->count();
            $qtd_atendimento_iniciado = Cliente::where("lead",1)->where("user_id",auth()->user()->id)->where("pessoa_fisica",1)->where('visivel',1)->where("etiqueta_id","!=",3)->where("lead_id",3)->count();
            $atrasado = Cliente::where("user_id",auth()->user()->id)->where("lead",1)->where('pessoa_fisica',1)->where('visivel',1)->where("etiqueta_id","!=",3)->whereDate("created_at","<",date('Y-m-d'))->count();
            $hoje = Cliente::where("user_id",auth()->user()->id)->where("lead",1)->where("visivel",1)->where('pessoa_fisica',1)->where("etiqueta_id","!=",3)->whereDate('created_at',"=",date('Y-m-d'))->count();
            $semana = Cliente::where("user_id",auth()->user()->id)->where('pessoa_fisica',1)->where("etiqueta_id","!=",3)->where("lead",1)->where('visivel',1)->whereRaw("YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1) AND created_at > now()")->count();
            $mes = Cliente::where("user_id",auth()->user()->id)->where('pessoa_fisica',1)->where("etiqueta_id","!=",3)->where("lead",1)->where('visivel',1)->whereRaw("MONTH(created_at) = MONTH(NOW())")->count();
            $total = Cliente::where("user_id",auth()->user()->id)->where('pessoa_fisica',1)->where("etiqueta_id","!=",3)->where("lead",1)->where('visivel',1)->count();
            
            return [
                "quantidade_plantao_vendas" => $qtd_plantao_vendas,
                "quantidade_prospeccao" => $qtd_prospeccao,
                "quantidade_atendimento_iniciado" => $qtd_atendimento_iniciado,
                "nome" => $cliente->nome,
                "atrasado" => $atrasado,
                "hoje" => $hoje,
                "semana" => $semana,
                "mes" => $mes,
                "total" => $mes,
                "id" => $cliente->id,
                "nome" => $cliente->nome

            ];
        } else {
            return "error";
        }
    }

    public function prospeccaoStorePJ(Request $request)
    {
        
        $cliente = new Cliente();
        $cliente->user_id = auth()->user()->id;
        $cliente->cidade_id = $request->cidade_id;
        $cliente->nome = $request->nome;
        $cliente->cnpj = $request->cnpj;
        $cliente->origem_id = 1;
        $cliente->etiqueta_id = 1;
        $cliente->lead_id = 2;
        $cliente->telefone = $request->telefone;
        $cliente->telefone_empresa = (!empty($request->telefone_empresa) ? $request->telefone_empresa : null);
        $cliente->nome_empresa = $request->nome_empresa;
        $cliente->pessoa_fisica = 0;
        $cliente->pessoa_juridica = 1;
        $cliente->ultimo_contato = date("Y-m-d");
        $cliente->email = $request->email;
        if($cliente->save()) {

            $qtdAtrasado = Cliente::where("user_id",auth()
                ->user()->id)
                ->where('lead',1)
                ->where("etiqueta_id","!=",3)
                ->where("visivel",1)
                ->where("pessoa_juridica",1)
                ->whereHas('cotacao',function($query){
                    $query->where("financeiro_id","!=",7);
                })
                ->whereDate('created_at','<',date('Y-m-d'))
                ->count();

            $qtdHoje = Cliente::where("user_id",auth()->user()->id)->where('lead',1)->where("etiqueta_id","!=",3)->where("visivel",1)->where("pessoa_juridica",1)->whereDate('created_at','=',date('Y-m-d'))->count();    
            $qtdSemana = Cliente::where("user_id",auth()->user()->id)->where('lead',1)->where("etiqueta_id","!=",3)->where("visivel",1)->where("pessoa_juridica",1)->whereRaw("YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1) AND created_at > now()")->count();        
            $qtdMes = Cliente::where("user_id",auth()->user()->id)->where('lead',1)->where("etiqueta_id","!=",3)->where("visivel",1)->where("pessoa_juridica",1)->whereRaw("MONTH(created_at) = MONTH(NOW())")->count();        

            $qtdProps = Cliente::where("lead_id",2)->where('lead',1)->where("pessoa_juridica",1)->count();
            $qtdVendas = Cliente::where("lead_id",1)->where('lead',1)->where("pessoa_juridica",1)->count();
            $qtdAtendimento = Cliente::where("lead_id",3)->where('lead',1)->where("pessoa_juridica",1)->count();

            $total = Cliente::where("user_id",auth()->user()->id)->where('pessoa_juridica',1)->where("etiqueta_id","!=",3)->where("lead",1)->where('visivel',1)->count();

            return [
                "quantidade_atrasado" => $qtdAtrasado,
                "quantidade_hoje" => $qtdHoje,
                "quantidade_semana" => $qtdSemana,
                "quantidade_mes" => $qtdMes,
                "quantidade_total" => $total,
                "quantidade_prospeccao" => $qtdProps,
                "quantidade_vendas" => $qtdVendas,
                "quantidade_atendimento" => $qtdAtendimento,
                "id" => $cliente->id,
                "nome" => $cliente->nome

            ];





            return $cliente->id;
        } else {
            return "error";
        }
    }

    public function pegarPlanosPorAdministradora(Request $request)
    {
        $administradora = Administradora::where("id",$request->administradora)->with("planos")->first();
        return $administradora;
        
    }

  

    // public function leadPF()
    // {
    //     $clientes = Cliente::
    //         where("user_id",auth()->user()->id)
    //         ->where('pessoa_fisica',1)
    //         ->where("lead",1)
    //         ->with('origem')
    //         ->orderBy("id","DESC")
    //         ->get();
    //     return $clientes;
    // }

    public function leadPlantaoVendasPF()
    {
        $clientes = Cliente
            ::where("user_id",auth()->user()->id)
            ->where('pessoa_fisica',1)
            ->where("lead",1)
            ->where("lead_id",1)
            ->with('origem')
            ->orderBy("created_at","ASC")
            ->get();

            

        return $clientes;
    }

    public function leadPlantaoVendasPJ()
    {
        $clientes = Cliente
            ::where("user_id",auth()->user()->id)
            ->where('pessoa_fisica',1)
            ->where("lead",1)
            ->where("lead_id",1)
            ->with('origem')
            ->orderBy("created_at","ASC")
            ->get();

            

        return $clientes;
    }

    public function leadProspeccaoPF()
    {
        $clientes = Cliente
            ::where("user_id",auth()->user()->id)
            ->where('pessoa_fisica',1)
            ->where("lead",1)
            ->where("lead_id",2)
            ->orderBy("id","DESC")
            ->selectRaw("id,nome,telefone,email,created_at,origem_id")
            ->selectRaw("if(DATEDIFF(NOW(), created_at)>0,concat(DATEDIFF(NOW(), created_at),' dias'),TIMEDIFF(now(), created_at)) AS tempo")
            ->with('origem')
            ->get();
        return $clientes;
    }

    public function leadProspeccaoPJ()
    {
        $clientes = Cliente
            ::where("user_id",auth()->user()->id)
            ->where('pessoa_juridica',1)
            ->where("lead",1)
            ->where("lead_id",2)
            ->orderBy("id","DESC")
            ->selectRaw("id,nome,telefone,email,created_at,origem_id")
            ->selectRaw("if(DATEDIFF(NOW(), created_at)>0,concat(DATEDIFF(NOW(), created_at),' dias'),TIMEDIFF(now(), created_at)) AS tempo")
            ->with('origem')
            ->get();

       
        return $clientes;
    }

    public function leadAtendimentoPF()
    {
        $clientes = Cliente
            ::where("user_id",auth()->user()->id)
            ->where('pessoa_fisica',1)
            ->where("lead",1)
            ->where("lead_id",3)
            ->with('origem')
            ->orderBy("created_at","ASC")
            ->selectRaw("id,nome,telefone,email,created_at,origem_id")
            ->selectRaw("if(DATEDIFF(NOW(), updated_at)>0,concat(DATEDIFF(NOW(), updated_at),' dias'),TIMEDIFF(now(), updated_at)) AS tempo")
            ->with('origem')
            ->get();
        return $clientes;
    }

    public function leadSemContatoPF()
    {
        $clientes = Cliente
            ::where("user_id",auth()->user()->id)
            ->where('pessoa_fisica',1)
            ->where("lead",1)
            ->where("lead_id",4)
            ->with('origem')
            ->orderBy("created_at","ASC")
            ->selectRaw("id,nome,telefone,email,created_at,origem_id")
            ->selectRaw("if(DATEDIFF(NOW(), updated_at)>0,concat(DATEDIFF(NOW(), updated_at),' dias'),TIMEDIFF(now(), updated_at)) AS tempo")
            ->with('origem')
            ->get();
        return $clientes;
    }

    public function leadSemContatoPJ()
    {
        $clientes = Cliente
            ::where("user_id",auth()->user()->id)
            ->where('pessoa_juridica',1)
            ->where("lead",1)
            ->where("lead_id",4)
            ->with('origem')
            ->orderBy("created_at","ASC")
            ->selectRaw("id,nome,telefone,email,created_at,origem_id")
            ->selectRaw("if(DATEDIFF(NOW(), updated_at)>0,concat(DATEDIFF(NOW(), updated_at),' dias'),TIMEDIFF(now(), updated_at)) AS tempo")
            ->with('origem')
            ->get();
        return $clientes;
    }    



    public function leadAtendimentoPJ()
    {
        $clientes = Cliente
            ::where("user_id",auth()->user()->id)
            ->where('pessoa_juridica',1)
            ->where("lead",1)
            ->where("lead_id",3)
            ->with('origem')
            ->orderBy("created_at","ASC")
            ->selectRaw("id,nome,telefone,email,created_at,origem_id")
            ->selectRaw("if(DATEDIFF(NOW(), updated_at)>0,concat(DATEDIFF(NOW(), updated_at),' dias'),TIMEDIFF(now(), updated_at)) AS tempo")
            ->with('origem')
            ->get();
        return $clientes;
    }



    public function getClientesParaHoje(Request $request)
    {
        $visivel = 1;
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("lead",0)
            ->where("visivel",1)
            ->where('pessoa_fisica',1)
            // ->where("etiqueta_id","!=",3)
            ->whereHas('cotacao',function($query){
                //$query->where('financeiro_id',"!=",7);
                $query->whereRaw('financeiro_id IS NULL');
            })
            ->whereHas('tarefas',function($query){
                $query->where("visivel",1);
                $query->whereRaw("motivo_id IS NULL");
                $query->where("user_id",auth()->user()->id);
                $query->whereDate('data','=',date('Y-m-d'));
            })
            ->with('tarefas',function($query){
                $query->where("status",0);
                $query->whereDate('data','=',date('Y-m-d'))->with('titulo');
            })
            
        ->with(['cidade','etiqueta','cotacao.somarCotacaoFaixaEtaria','origem'])
        ->orderBy("clientes.updated_at",'desc')
        ->get();
        return $clientes;                
    } 

    public function getClientesParaHojePJ(Request $request)
    {
        $visivel = 1;
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("lead",0)
            ->where("visivel",1)
            ->where('pessoa_juridica',1)
            //->where("etiqueta_id","!=",3)
            ->whereHas('cotacao',function($query){
                //$query->where('financeiro_id',"!=",7);
                $query->whereRaw('financeiro_id IS NULL');
            })
            ->whereHas('tarefas',function($query){
                $query->where("status",0);
                $query->whereDate('data','=',date('Y-m-d'));
            })
            ->with('tarefas',function($query){
                $query->where("status",0);
                $query->whereDate('data','=',date('Y-m-d'))->with('titulo');
            })
        ->with(['cidade','etiqueta','cotacao.somarCotacaoFaixaEtaria'])
        ->orderBy('updated_at',"DESC")
        ->get();
        return $clientes;                
    } 




    public function getClientesParaHojeProspeccao(Request $request)
    {
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("lead",1)
            ->where("visivel",1)
            ->where('pessoa_fisica',1)
            ->where("etiqueta_id","!=",3)
            ->whereDate('created_at',"=",date('Y-m-d'))
            ->orderBy("created_at","ASC")
            
            ->selectRaw("id,nome,telefone,email,created_at,origem_id")
            ->selectRaw("if(DATEDIFF(NOW(), created_at)>0,concat(DATEDIFF(NOW(), created_at),' dias'),TIMEDIFF(now(), created_at)) AS tempo")
            
        ->with('origem')->get();
        return $clientes;                
    } 

    public function getClientesParaHojeProspeccaoPJ(Request $request)
    {
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("lead",1)
            ->where("visivel",1)
            ->where('pessoa_juridica',1)
            ->where("etiqueta_id","!=",3)
            ->whereDate('created_at',"=",date('Y-m-d'))
            ->orderBy("created_at","ASC")
            
            ->selectRaw("id,nome,telefone,email,created_at,origem_id")
            ->selectRaw("if(DATEDIFF(NOW(), created_at)>0,concat(DATEDIFF(NOW(), created_at),' dias'),TIMEDIFF(now(), created_at)) AS tempo")
            
        ->with('origem')->get();
        return $clientes;                
    } 


    public function mudarStatusLeads(Request $request) 
    {
        $cliente = Cliente::where("id",$request->id)->first();
        $cliente->lead_id = 3;
        $cliente->save();
        $atendimento = Cliente::where("lead_id",3)->where('pessoa_fisica',1)->where('lead',1)->count();
        $planta_vendas = Cliente::where("lead_id",1)->where('pessoa_fisica',1)->where('lead',1)->count();
        $prospeccao = Cliente::where("lead_id",2)->where('pessoa_fisica',1)->where('lead',1)->count();
        return ["atedimento"=>$atendimento,"plantao_vendas"=>$planta_vendas,"prospeccao"=>$prospeccao];
    }

    public function mudarStatusLeadsPJ(Request $request) 
    {
        $cliente = Cliente::where("id",$request->id)->first();
        $cliente->lead_id = 3;
        $cliente->save();
        $atendimento = Cliente::where("lead_id",3)->where('pessoa_juridica',1)->where('lead',1)->count();
        $planta_vendas = Cliente::where("lead_id",1)->where('pessoa_juridica',1)->where('lead',1)->count();
        $prospeccao = Cliente::where("lead_id",2)->where('pessoa_juridica',1)->where('lead',1)->count();
        return ["atedimento"=>$atendimento,"plantao_vendas"=>$planta_vendas,"prospeccao"=>$prospeccao];
    }



    
    public function getClienteAtrasadasAjax(Request $request)
    {
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("lead",0)
            ->where('pessoa_fisica',1)
            ->where('visivel',1)
            ->whereHas('cotacao',function($query){
                //$query->where("financeiro_id","!=",7);
                $query->whereRaw("financeiro_id IS NULL");
            })

            // ->where("etiqueta_id","!=",3)
            ->whereHas('tarefas',function($query){
                $query->where("user_id",auth()->user()->id);
                $query->where("visivel",1);
                $query->whereRaw("motivo_id IS NULL");
                $query->whereDate("data","<",date('Y-m-d'));
                $query->orderByRaw("DATA");
            })
            ->with('tarefas',function($query){
                $query->where("status",0);
                $query->whereDate("data","<",date('Y-m-d'))->with('titulo');
            })
            

        ->with(['cidade','etiqueta','cotacao.somarCotacaoFaixaEtaria','origem'])
        ->orderBy('clientes.updated_at','DESC')
        ->get();
        return $clientes;                

            // $tarefas = Tarefa::where("user_id",auth()->user()->id)
            //             ->where("visivel",1)
            //             ->whereRaw("motivo_id IS NULL")
            //             ->whereRaw("DATA < DATE(NOW())")
            //             ->with(['cliente','cliente.cidade','cliente.etiqueta','cliente.cotacao.somarCotacaoFaixaEtaria','cliente.origem'])
            //             ->get();

            // return $tarefas;            




    }

    public function getClienteAtrasadasAjaxPJ(Request $request)
    {
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("lead",0)
            ->where('pessoa_juridica',1)
            ->where('visivel',1)
            ->whereHas('cotacao',function($query){
                //$query->where("financeiro_id","!=",7);
                $query->whereRaw("financeiro_id IS NULL");
            })
            //->where("etiqueta_id","!=",3)
            ->whereHas('tarefas',function($query){
                $query->where("user_id",auth()->user()->id);
                $query->where("visivel",1);
                $query->whereRaw("motivo_id IS NULL");
                $query->whereDate("data","<",date('Y-m-d'));
                $query->orderByRaw("DATA");
            })
            ->with('tarefas',function($query){
                $query->where("status",0);
                $query->whereDate("data","<",date('Y-m-d'))->with('titulo');
            })


        ->with(['cidade','etiqueta','cotacao.somarCotacaoFaixaEtaria'])
        ->orderBy('updated_at',"DESC")
        ->get();
        return $clientes;                
    }



    public function getClienteAtrasadasAjaxProspeccao(Request $request)
    {
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("lead",1)
            ->where('pessoa_fisica',1)
            ->where('visivel',1)
            ->where("etiqueta_id","!=",3)
            ->whereDate("created_at","<",date('Y-m-d'))
            ->orderBy("created_at","ASC")
            ->selectRaw("id,nome,telefone,email,created_at,origem_id")
            ->selectRaw("if(DATEDIFF(NOW(), created_at)>0,concat(DATEDIFF(NOW(), created_at),' dias'),TIMEDIFF(now(), created_at)) AS tempo")
            ->with('origem')
            ->get();
        return $clientes;            
    }

    public function getClienteAtrasadasAjaxProspeccaoPJ(Request $request)
    {
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("lead",1)
            ->where('visivel',1)
            ->where('pessoa_juridica',1)
            //->where("etiqueta_id","!=",3)
            ->whereDate("created_at","<",date('Y-m-d'))
            ->orderBy("created_at","ASC")
            ->selectRaw("id,nome,telefone,email,created_at,origem_id")
            ->selectRaw("if(DATEDIFF(NOW(), created_at)>0,concat(DATEDIFF(NOW(), created_at),' dias'),TIMEDIFF(now(), created_at)) AS tempo")
            ->with('origem')
            ->get();
        return $clientes;            
    }

    public function listarClientesSemanaAjax(Request $request)
    {
        $visivel = 1;
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("pessoa_fisica",1)
            // ->where("etiqueta_id","!=",3)
            ->where("lead",0)
            ->where('visivel',1)
            ->whereHas('cotacao',function($query){
                //$query->where("financeiro_id","!=",7);
                $query->orWhereRaw("financeiro_id IS NULL");
            })
            ->whereHas('tarefas',function($query) use($visivel){
                $query->where("visivel",1);
                $query->where("user_id",auth()->user()->id);
                $query->whereRaw("motivo_id IS NULL");
                $query->whereRaw("YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND data > now()");
            })
            ->with('tarefas',function($query) use($visivel){
                $query->where("status",0);
                $query->whereRaw("YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND data > now()")->with('titulo');
            })
            ->with(['cidade','etiqueta','cotacao.somarCotacaoFaixaEtaria','origem'])
            ->orderBy('clientes.updated_at','DESC')
            ->get();
        return $clientes;      
    }

    public function listarClientesSemanaAjaxPJ(Request $request)
    {
        $visivel = 1;
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("pessoa_juridica",1)
            ->where("etiqueta_id","!=",3)
            ->where("lead",0)
            ->where('visivel',1)
            ->whereHas('cotacao',function($query){
                //$query->where('financeiro_id',"!=",7);
                $query->whereRaw('financeiro_id IS NULL');
            })
            ->whereHas('tarefas',function($query) use($visivel){
                $query->where("status",0);
                $query->whereRaw("YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND data > now()");
            })
            ->with('tarefas',function($query) use($visivel){
                $query->where("status",0);
                $query->whereRaw("YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND data > now()")->with('titulo');
            })
            ->with(['cidade','etiqueta','cotacao.somarCotacaoFaixaEtaria','origem'])
            ->orderBy('updated_at',"DESC")
            ->get();
        return $clientes;      
    }




    public function listarClientesSemanaAjaxProspeccao(Request $request)
    {
        $clientes = Cliente::
        where("user_id",auth()->user()->id)
        ->where('pessoa_fisica',1)
        ->where("etiqueta_id","!=",3)
        ->where("lead",1)
        ->where('visivel',1)
        ->whereRaw("YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1) AND created_at > now()")
        ->orderBy("created_at","ASC")
        ->selectRaw("id,nome,telefone,email,created_at,origem_id")
        ->selectRaw("if(DATEDIFF(NOW(), created_at)>0,concat(DATEDIFF(NOW(), created_at),' dias'),TIMEDIFF(now(), created_at)) AS tempo")
        
        ->with('origem')
        ->get();
        return $clientes;      
    }

    public function listarClientesSemanaAjaxProspeccaoPJ(Request $request)
    {
        $clientes = Cliente::
        where("user_id",auth()->user()->id)
        ->where('pessoa_fisica',1)
        //->where("etiqueta_id","!=",3)
        ->where("lead",1)
        ->where('visivel',1)
        ->whereRaw("YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1) AND created_at > now()")
        ->orderBy("created_at","ASC")
        ->selectRaw("id,nome,telefone,email,created_at,origem_id")
        ->selectRaw("if(DATEDIFF(NOW(), created_at)>0,concat(DATEDIFF(NOW(), created_at),' dias'),TIMEDIFF(now(), created_at)) AS tempo")
        
        //->with('origem')
        ->get();
        return $clientes;      
    }

    public function listarClienteMesAjax(Request $request)
    {
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("pessoa_fisica",1)
            // ->where("etiqueta_id","!=",3)
            ->where("lead",0)
            ->where('visivel',1)
            ->whereHas('cotacao',function($query){
                //$query->where("financeiro_id","!=",7);
                $query->whereRaw("financeiro_id IS NULL");
            })
            ->whereHas('tarefas',function($query){
                $query->where("visivel",1);
                $query->where("user_id",auth()->user()->id);
                $query->whereRaw("motivo_id IS NULL");
                $query->whereRaw("MONTH(data) = MONTH(NOW())");
            })
            ->with('tarefas',function($query){
                $query->where("status",0);
                $query->whereRaw("MONTH(data) = MONTH(NOW())")->with('titulo');
            })
            ->with(['cidade','etiqueta','cotacao.somarCotacaoFaixaEtaria','origem'])
            ->orderBy('clientes.updated_at','DESC')
            ->get();
            // ->with(['cidade','etiqueta','origem'])->get();
        return $clientes; 
    }

    public function listarClienteMesAjaxPJ(Request $request)
    {
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("pessoa_juridica",1)
            //->where("etiqueta_id","!=",3)
            ->where("lead",0)
            ->where('visivel',1)
            ->whereHas('tarefas',function($query){
                $query->where("status",0);
                $query->whereRaw("MONTH(created_at) = MONTH(NOW())");
            })
            ->whereHas('cotacao',function($query){
                //$query->where('financeiro_id',"!=",7);
                $query->whereRaw('financeiro_id IS NULL');
            })
            ->with('tarefas',function($query){
                $query->where("status",0);
                $query->whereRaw("MONTH(created_at) = MONTH(NOW())")->with('titulo');
            })
            
            ->with(['cidade','etiqueta','origem'])
            ->orderBy('clientes.updated_at','DESC')
            ->get();
        return $clientes; 
    }

    public function listarClienteMesAjaxProspeccao(Request $request)
    {
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where('pessoa_fisica',1)
            ->where("etiqueta_id","!=",3)
            ->where("lead",1)
            ->where('visivel',1)
            ->whereRaw("MONTH(created_at) = MONTH(NOW())")
            ->orderBy("created_at","ASC")
            ->selectRaw("id,nome,telefone,email,created_at,origem_id")
            ->selectRaw("if(DATEDIFF(NOW(), created_at)>0,concat(DATEDIFF(NOW(), created_at),' dias'),TIMEDIFF(now(), created_at)) AS tempo")
            ->with('origem')
            ->get();
        return $clientes; 
    }

    public function listarClienteMesAjaxProspeccaoPJ(Request $request)
    {
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where('pessoa_juridica',1)
            //->where("etiqueta_id","!=",3)
            ->where("lead",1)
            ->where('visivel',1)
            ->whereRaw("MONTH(created_at) = MONTH(NOW())")
            ->orderBy("id","DESC")
            ->selectRaw("id,nome,telefone,email,created_at,origem_id")
            ->selectRaw("if(DATEDIFF(NOW(), created_at)>0,concat(DATEDIFF(NOW(), created_at),' dias'),TIMEDIFF(now(), created_at)) AS tempo")
            ->with('origem')
            ->get();
        return $clientes; 
    }


    public function listarClientesPorUser()
    {
        $clientes  = Cliente::where("user_id",auth()->user()->id)->get();
        if(count($clientes) >= 1) {
            return $clientes;
        } else {
            return "nada";
        }
    }

   


    public function listarClienteEspecifico($id)
    {
        $id_user = auth()->user()->id;
        $clientes = Cliente::where("user_id",$id_user)->get();
        $motivos = TarefaMotivoPerda::all();
        return view('admin.pages.tarefas.cliente-especifico',[
            "clientes" => $clientes,
            "motivos" => $motivos,
            "cliente" => $id
        ]);
        
    }





    public function editarClientes(Request $request)
    {
        $id = $request->id;
        $cliente = Cliente::where("id",$id)->first();
        return view('admin.pages.clientes.clientes-editar-anotacoes',[
            'cliente' => $cliente
        ]);
    }

    public function formEditarClientes(Request $request)
    {
        $id = $request->cliente_id;
        $cliente = Cliente::find($id);
        $cliente->nome = $request->nome;
        $cliente->telefone = $request->telefone;
        $cliente->email = $request->email;
        $cliente->data_nascimento = $request->data_nascimento;
        $cliente->anotacoes = nl2br($request->anotacoes);
        $cliente->save();
        return $cliente;
    }




    public function create()
    {
        $cidades = Cidade::all();
        return view('admin.pages.clientes.cadastrar',[
            "cidades" => $cidades
        ]);
    }

    public function verificartelefone(Request $request)
    {
        if($request->ajax()) {
            $telefone = $request->telefone;
            $cliente = Cliente::where("telefone",$telefone)
                ->selectRaw('id,nome,email,pessoa_fisica,pessoa_juridica,telefone,cidade_id,etiqueta_id')
                ->with(['cidade','etiqueta'])
                ->selectRaw("DATE_FORMAT(created_at,'%d/%m/%Y') as data_criacao")
                ->first();
            if($cliente && $cliente->etiqueta_id != 3) {
                $cliente->user_id = auth()->user()->id;
                $cliente->save();
                return $cliente;
            } else if($cliente && $cliente->etiqueta_id == 3) {
                return "indisponivel";
            } else {
                return "nada";
            }
        }
    }



    public function store(Request $request) 
    {
        if(empty($request->nome)) {
            return "errornome";
        }

        if(empty($request->cidade_id)) {
            return "errorcidade";
        }

        if(empty($request->email)) {
            return "erroremail";
        }

        $clienteEmail = Cliente::where("email",$request->email)->first();
        if($clienteEmail) {
            return "erroremailjacadastrado";
        }

        if(empty($request->telefone)) {
            return "errortelefone";
        }    

        $clienteTelefone = Cliente::where("telefone",$request->telefone)->first();
        if($clienteTelefone) {
            return "errortelefonejacadastrado";
        }

        $clientes = Cliente::where("nome",$request->nome)->where("email",$request->email)->where("telefone",$request->telefone)->first();
        if($clientes) {
            return "clienteexiste";
        }

        $dados = $request->all();
        $dados['pessoa_fisica'] = 1;
        $dados['pessoa_juridica'] = 0;
        $dados['etiqueta_id'] = 1;
        $dados['ultimo_contato'] = date("Y-m-d");
        $cliente = User::find(auth()->user()->id)->cliente()->create($dados);

        $tarefa = new Tarefa();
        $tarefa->cliente_id = $cliente->id;
        $tarefa->user_id = auth()->user()->id;
        $tarefa->titulo_id = 1;
        $tarefa->data = date('Y-m-d');
        
        $tarefa->descricao = "Cadastro do Cliente";
        $tarefa->save();
        return $cliente;
    }

    
    public function clienteExisteAjax(Request $request)
    {
        $cliente = Cliente::where("nome",$request->nome)->where("email",$request->email)->where("telefone",$request->telefone)
            ->selectRaw("nome,email,telefone,id")
            ->selectRaw("(SELECT nome FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS etiqueta")
            ->selectRaw("(SELECT name FROM users WHERE users.id = clientes.user_id) AS user")
            ->selectRaw("DATE_FORMAT(created_at,'%d/%m/%Y') as cadastrado")
            ->first();
        return $cliente;
    }

    public function clienteOrcamento($id)
    {
        $cliente = Cliente::where("id",$id)->first();
        if(!$cliente) {
            return redirect()->back();
        }
        
        return view('admin.pages.clientes.orcamentos',[
            "cliente" => $cliente,
            "cidades" => Cidade::all()
        ]);
    }

    public function clienteContrato($id)
    {
        $cliente = Cliente::where("id",$id)->first();
        if(!$cliente) {
            return redirect()->back();
        }
        
        $cidades = Cidade::all();
        $administradoras = Administradora::all();
        $operadoras = Operadora::all();
        $planos = Planos::all();
        
        return view('admin.pages.clientes.contrato',[
            "cliente" => $cliente,
            "cidades" => $cidades,
            "administradoras" => $administradoras,
            "operadoras" => $operadoras,
            "planos" => $planos        
        ]);
    }

    public function definirStatus(Request $request)
    {
        $cliente = $this->repository->find($request->cliente);
        $cliente->status = $request->etiqueta;
        $cliente->save();
        return true;
    }

    public function listarContratos(Request $request)
    {
        if($request->ac == "negociados") {
            // dd("Negociados");
            return view("admin.pages.contrato.negociados");
        } else if($request->ac == "negociacao") {
            return view("admin.pages.contrato.negociacao");
        } else {
            // dd("Geral");
            return view("admin.pages.contrato.index");
        }
                   
    }

    public function listarContratosAjax(Request $request) 
    {
        if($request->ajax()) {
            $id = auth()->user()->id;
            $user = User::where("id",auth()->user()->id)->first();
            if($user->hasPermission('configuracoes') || $user->isAdmin()) {
                $contratos = Cliente::where("etiqueta_id","=",3)->where('pessoa_juridica',"!=",1)->with(['comissoes','cotacao','cotacao.cotacaoFaixaEtaria','user','cotacao.administradora','cidade','cotacao.acomodacao'])->get();
                return $contratos;
            } else {
                $contratos = Cliente::where("user_id",$id)->where("etiqueta_id","=",3)->where('pessoa_juridica',"!=",1)->with(['comissoes','cotacao','cotacao.cotacaoFaixaEtaria','user','cotacao.administradora','cidade','cotacao.acomodacao'])->get();
                return $contratos;
            }
        }
    }

    public function listarContratosAjaxNegociados(Request $request) 
    {
        if($request->ajax()) {
            $id = auth()->user()->id;
            $user = User::where("id",auth()->user()->id)->first();
            if($user->hasPermission('configuracoes') || $user->isAdmin()) {
                $contratos = Cliente::where("etiqueta_id","=",3)
                ->whereHas('cotacao',function($query){
                    $query->where('financeiro_id',6);
                })
                ->where('pessoa_juridica',"!=",1)
                ->with(['comissoes','cotacao','cotacao.cotacaoFaixaEtaria','user','cotacao.administradora','cidade','cotacao.acomodacao'])
                ->get();
                return $contratos;
            } else {
                $contratos = Cliente::where("user_id",$id)->where("etiqueta_id","=",3)
                    ->whereHas('cotacao',function($query){
                        $query->where('financeiro_id',6);
                    })
                    ->where('pessoa_juridica',"!=",1)
                    ->with(['comissoes','cotacao','cotacao.cotacaoFaixaEtaria','user','cotacao.administradora','cidade','cotacao.acomodacao'])
                    ->get();
                return $contratos;
            }
        }
    }

    public function listarContratosAjaxNegociacao(Request $request) 
    {
        if($request->ajax()) {
            $id = auth()->user()->id;
            $user = User::where("id",auth()->user()->id)->first();
            if($user->hasPermission('configuracoes') || $user->isAdmin()) {
                $contratos = Cliente::where("etiqueta_id","=",3)
                ->whereHas('cotacao',function($query){
                    $query->where('financeiro_id',"!=",6);
                })
                ->where('pessoa_juridica',"!=",1)
                ->with(['comissoes','cotacao','cotacao.cotacaoFaixaEtaria','user','cotacao.administradora','cidade','cotacao.acomodacao'])
                ->get();
                return $contratos;
            } else {
                $contratos = Cliente::where("user_id",$id)->where("etiqueta_id","=",3)
                    ->whereHas('cotacao',function($query){
                        $query->where('financeiro_id',"!=",6);
                    })
                    ->where('pessoa_juridica',"!=",1)
                    ->with(['comissoes','cotacao','cotacao.cotacaoFaixaEtaria','user','cotacao.administradora','cidade','cotacao.acomodacao'])
                    ->get();
                return $contratos;
            }
        }
    }



    public function clientesCorretores()
    {
        $etiquetas = Etiquetas::all();
        return view('admin.pages.clientes.corretores',[
           
            'etiquetas' => $etiquetas
        ]);
    }

    public function pegarClientesCorretores()
    {
        $idAdmin = auth()->user()->id;
        $clientes = DB::table('clientes')
            ->selectRaw("DATE_FORMAT(`created_at`,'%d/%m/%Y') as data")
            ->selectRaw("nome")
            
            ->selectRaw("(SELECT nome FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS etiqueta")
            ->selectRaw("(SELECT cor FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id)  AS cor")
            ->selectRaw("(SELECT nome FROM cidades WHERE cidades.id = clientes.cidade_id) AS cidade")
            ->selectRaw("(SELECT NAME FROM users WHERE clientes.user_id = users.id) AS corretor")
            ->where("user_id","!=",$idAdmin)
            ->get();
        return response()->json($clientes);
    }

    public function contratoSemOrcamento(Request $request)
    {
        $cidade = $request->cidade;
        $operadora = $request->operadora;
        $administradora = $request->administradora;
        $coparticipacao = $request->coparticipacao;
        $odonto = $request->odonto;
        $acomodacao = $request->acomodacao;
        $dados = [];
        foreach($request->faixas as $k => $v) {
            if($v != null) {
                $dados[$k] = $v;
            }
        }
        $keys = array_values(array_keys($dados));
        $dados = DB::table("tabelas")
            ->whereRaw("cidade_id = ".$cidade." AND operadora_id = ".$operadora." AND administradora_id = ".$administradora." AND odonto = ".($odonto == "sim" ? 1 : 0)." AND coparticipacao = ".($coparticipacao == "sim" ? 1 : 0)." AND plano_id = 3")
            ->whereIn('faixa_etaria',$keys)
            ->get();
        dd($dados);    
        
    }

    public function mudarStatus(Request $request)
    {
        $cliente = $request->cliente;
        $newStatus = $request->status;
        $etiquetaId = $request->id;
        $cliente = $this->repository->find($request->cliente);
        $cliente->etiqueta_id = $newStatus;
        $cliente->save();
        return true;
    }

    public function listarPorEtiqueta(Request $request)
    {
        if($request->ajax()) {
            $user = User::where("id",auth()->user()->id)->first();
            if($user->hasPermission('configuracoes') || $user->isAdmin()) { 
                $id_etiqueta = $request->id;
                $id = auth()->user()->id;
                $clientes = $this->repository->where("etiqueta_id",$id_etiqueta)
                    ->selectRaw("nome,etiqueta_id,email,created_at,ultimo_contato,telefone,pessoa_fisica,pessoa_juridica,id")
                    ->selectRaw("(SELECT nome FROM cidades WHERE cidades.id = clientes.cidade_id) AS cidade")
                    ->selectRaw("(SELECT name FROM users WHERE users.id = clientes.user_id) AS user")
                    ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE tarefas.cliente_id = clientes.id) AS tarefas_quantidade")
                    ->selectRaw("(SELECT if(SUM(quantidade) >= 1,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id = (SELECT id FROM cotacoes WHERE cotacoes.cliente_id = clientes.id)) AS quantidade")
                    ->selectRaw("(SELECT cor FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS cor")
                    ->selectRaw("(SELECT nome FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS nome_etiqueta")
                ->get();
                if(count($clientes) >= 1) {
                    return view('admin.pages.clientes.listar-por-etiqueta-administrador',[
                        'clientes' => $clientes
                    ]);    
                } else {
                    return "<h3 class='text-center'>Sem Clientes Para Listar Com esse status</h3>";
                }
            } else {
                $id_etiqueta = $request->id;
                $id = auth()->user()->id;
                $clientes = $this->repository->where("user_id",$id)->where("etiqueta_id",$id_etiqueta)
                    ->selectRaw("nome,etiqueta_id,email,created_at,ultimo_contato,telefone,pessoa_fisica,pessoa_juridica,id")
                    
                    ->selectRaw("(SELECT nome FROM cidades WHERE cidades.id = clientes.cidade_id) AS cidade")
                    ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE tarefas.cliente_id = clientes.id) AS tarefas_quantidade")
                    ->selectRaw("(SELECT if(SUM(quantidade) >= 1,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id = (SELECT id FROM cotacoes WHERE cotacoes.cliente_id = clientes.id)) AS quantidade")
                    ->selectRaw("(SELECT cor FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS cor")
                    ->selectRaw("(SELECT nome FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS nome_etiqueta")
                ->get();
                if(count($clientes) >= 1) {
                        return view('admin.pages.clientes.listar-por-etiqueta',[
                            'clientes' => $clientes
                            
                        ]);    
                } else {
                        return "<h3 class='text-center'>Sem Clientes Para Listar Com esse status</h3>";
                }
            } 
              
        }
    }    


    public function listarPorEtiquetaAll(Request $request)
    {
       if($request->ajax()) {
            $user = User::where("id",auth()->user()->id)->first();
            if($user->hasPermission('configuracoes') || $user->isAdmin()) { 
                
                $clientes = $this->repository->where("etiqueta_id","!=",3)
                    ->selectRaw("nome,etiqueta_id,email,created_at,ultimo_contato,telefone,pessoa_fisica,pessoa_juridica,id")
                    ->selectRaw("(SELECT nome FROM cidades WHERE cidades.id = clientes.cidade_id) AS cidade")
                    ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE tarefas.cliente_id = clientes.id) AS tarefas_quantidade")
                    ->selectRaw("(SELECT if(SUM(quantidade) >= 1,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id = (SELECT id FROM cotacoes WHERE cotacoes.cliente_id = clientes.id)) AS quantidade")
                    ->selectRaw("(SELECT cor FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS cor")
                    ->selectRaw("(SELECT name FROM users WHERE users.id = clientes.user_id) AS user")
                    ->selectRaw("(SELECT nome FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS nome_etiqueta")
                ->get();

                if(count($clientes) >= 1) {
                    return view('admin.pages.clientes.listar-por-etiqueta',[
                        'clientes' => $clientes
                    ]);    
                    } else {
                        return "Sem Clientes Para Listar Com esse status";
                    }





            } else {

                $id = auth()->user()->id;
                $clientes = $this->repository->where("user_id",$id)->where("etiqueta_id","!=",3)
                    ->selectRaw("nome,etiqueta_id,email,created_at,ultimo_contato,telefone,pessoa_fisica,pessoa_juridica,id")
                    ->selectRaw("(SELECT nome FROM cidades WHERE cidades.id = clientes.cidade_id) AS cidade")
                    ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE tarefas.cliente_id = clientes.id) AS tarefas_quantidade")
                    ->selectRaw("(SELECT if(SUM(quantidade) >= 1,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id = (SELECT id FROM cotacoes WHERE cotacoes.cliente_id = clientes.id)) AS quantidade")
                    ->selectRaw("(SELECT cor FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS cor")
                    ->selectRaw("(SELECT nome FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS nome_etiqueta")
                ->get();
                if(count($clientes) >= 1) {
                    return view('admin.pages.clientes.listar-por-etiqueta',[
                        'clientes' => $clientes
                    ]);    
                    } else {
                        return "Sem Clientes Para Listar Com esse status";
                    }





            }

       } 
       
    }

    public function searchclienteAjax(Request $request)
    {
        if(!auth()->user()->admin) {
            $id = $request->id;
            $cliente = Cliente::where("id",$id)->where("user_id",auth()->user()->id)->first();
            if($cliente) {
                $clientes = Cliente::where("user_id",auth()->user()->id)->where("id",$id)
                ->selectRaw("nome,etiqueta_id,email,created_at,ultimo_contato,telefone,pessoa_fisica,pessoa_juridica,id")
                ->selectRaw("(SELECT nome FROM cidades WHERE cidades.id = clientes.cidade_id) AS cidade")
                ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE tarefas.cliente_id = clientes.id) AS tarefas_quantidade")
                ->selectRaw("(SELECT if(SUM(quantidade) >= 1,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id = (SELECT id FROM cotacoes WHERE cotacoes.cliente_id = clientes.id)) AS quantidade")
                ->selectRaw("(SELECT cor FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS cor")
                ->selectRaw("(SELECT nome FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS nome_etiqueta")
                ->first();
                return view('admin.pages.clientes.ajax.cliente-ajax',[
                    'c' => $clientes
                ]);    
            } else {
                return "nada";
            }
        } else {
            $id = $request->id;
            $cliente = Cliente::where("id",$id)->first();
            if($cliente) {
                $clientes = Cliente::where("id",$id)
                ->selectRaw("nome,etiqueta_id,email,created_at,ultimo_contato,telefone,pessoa_fisica,pessoa_juridica,id")
                ->selectRaw("(SELECT nome FROM cidades WHERE cidades.id = clientes.cidade_id) AS cidade")
                ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE tarefas.cliente_id = clientes.id) AS tarefas_quantidade")
                ->selectRaw("(SELECT if(SUM(quantidade) >= 1,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id = (SELECT id FROM cotacoes WHERE cotacoes.cliente_id = clientes.id)) AS quantidade")
                ->selectRaw("(SELECT cor FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS cor")
                ->selectRaw("(SELECT nome FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS nome_etiqueta")
                ->first();
                return view('admin.pages.clientes.ajax.cliente-ajax',[
                    'c' => $clientes
                ]);    
            } else {
                return "nada";
            }
        }
        
    }


    /********* Contratos ************/
    public function listarContratosPF(Request $request)
    {   
        $fisica = 1;
        $qtdAguardandoBoletoColetivo = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id","=",1)->whereHas('clientes',function($query) use($fisica){$query->where('pessoa_fisica',$fisica);})->count();
        $qtdAguardandoPagAdesaoColetivo = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id","=",2)->whereHas('clientes',function($query) use($fisica){$query->where('pessoa_fisica',$fisica);})->count();
        $qtdAguardandoPagPlanoIndividual = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id","=",3)->whereHas('clientes',function($query) use($fisica){$query->where('pessoa_fisica',$fisica);})->count();
        $qtdPagVigencia = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id","=",4)->whereHas('clientes',function($query) use($fisica){$query->where('pessoa_fisica',$fisica);})->count();
        $qtdAguardandoPagEmpresarial = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id","=",5)->whereHas('clientes',function($query) use($fisica){$query->where('pessoa_fisica',$fisica);})->count();
        $qtdComissoes = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id","=",6)->whereHas('clientes',function($query) use($fisica){$query->where('pessoa_fisica',$fisica);})->count();
        $qtdFinalizado = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id","=",7)->whereHas('clientes',function($query) use($fisica){$query->where('pessoa_fisica',$fisica);})->count();
        
        return view("admin.pages.contrato.pessoa_fisica.pendentes",[
            "qtdAguardandoBoletoColetivo" => $qtdAguardandoBoletoColetivo,
            "qtdAguardandoPagAdesaoColetivo" => $qtdAguardandoPagAdesaoColetivo,
            "qtdAguardandoPagPlanoIndividual" => $qtdAguardandoPagPlanoIndividual,
            "qtdPagVigencia" => $qtdPagVigencia,
            "qtdAguardandoPagEmpresarial" => $qtdAguardandoPagEmpresarial,
            "qtdComissoes" => $qtdComissoes,
            "qtdFinalizado" => $qtdFinalizado
        ]);
    }

    public function listarContratosPFPendentes()
    {
        $fisica = 1;
        $contratos = Cotacao::where("user_id",auth()->user()->id)
            //->where("financeiro_id","!=",7)
            ->whereRaw("financeiro_id IS NOT NULL")
            ->whereHas('clientes',function($query) use($fisica){
                $query->where('pessoa_fisica',$fisica);
            })
            ->with('clientes',function($query) use($fisica){
                $query->where('pessoa_fisica',$fisica);
            })
            ->with(['administradora','financeiro','cidade','acomodacao','comissao','comissao.comissaoLancadas','comissao.premiacaoLancadas','somarCotacaoFaixaEtaria','plano'])
            ->orderBy('updated_at','DESC')
            ->get();
        return $contratos;       
    }

    public function aguardandoBoletoColetivo()
    {
        $fisica = 1;
        $contratos = Cotacao::where("user_id",auth()->user()->id)
            //->where("financeiro_id","!=",7)
            ->where("financeiro_id","=",1)
            ->whereHas('clientes',function($query) use($fisica){
                $query->where('pessoa_fisica',$fisica);
            })
            ->with('clientes',function($query) use($fisica){
                $query->where('pessoa_fisica',$fisica);
            })
            ->with(['administradora','financeiro','cidade','acomodacao','comissao','comissao.comissaoLancadas','comissao.premiacaoLancadas','somarCotacaoFaixaEtaria','plano'])
            ->get();
        return $contratos;       
    }

    public function aguardandoPagamentoAdesaoColetivo()
    {
        $fisica = 1;
        $contratos = Cotacao::where("user_id",auth()->user()->id)
            //->where("financeiro_id","!=",7)
            ->where("financeiro_id","=",2)
            ->whereHas('clientes',function($query) use($fisica){
                $query->where('pessoa_fisica',$fisica);
            })
            ->with('clientes',function($query) use($fisica){
                $query->where('pessoa_fisica',$fisica);
            })
            ->with(['administradora','financeiro','cidade','acomodacao','comissao','comissao.comissaoLancadas','comissao.premiacaoLancadas','somarCotacaoFaixaEtaria','plano'])
            ->get();
        return $contratos;       
    }

    public function aguardandoPagamentoPlanoIndividual()
    {
        $fisica = 1;
        $contratos = Cotacao::where("user_id",auth()->user()->id)
            //->where("financeiro_id","!=",7)
            ->where("financeiro_id","=",3)
            ->whereHas('clientes',function($query) use($fisica){
                $query->where('pessoa_fisica',$fisica);
            })
            ->with('clientes',function($query) use($fisica){
                $query->where('pessoa_fisica',$fisica);
            })
            ->with(['administradora','financeiro','cidade','acomodacao','comissao','comissao.comissaoLancadas','comissao.premiacaoLancadas','somarCotacaoFaixaEtaria','plano'])
            ->get();
        return $contratos;       
    }

    public function aguardandoPagamentoVigencia()
    {
        $fisica = 1;
        $contratos = Cotacao::where("user_id",auth()->user()->id)
            //->where("financeiro_id","!=",7)
            ->where("financeiro_id","=",4)
            ->whereHas('clientes',function($query) use($fisica){
                $query->where('pessoa_fisica',$fisica);
            })
            ->with('clientes',function($query) use($fisica){
                $query->where('pessoa_fisica',$fisica);
            })
            ->with(['administradora','financeiro','cidade','acomodacao','comissao','comissao.comissaoLancadas','comissao.premiacaoLancadas','somarCotacaoFaixaEtaria','plano'])
            ->get();
        return $contratos;       
    }

    public function aguardandoPagamentoEmpresarial()
    {
        $fisica = 1;
        $contratos = Cotacao::where("user_id",auth()->user()->id)
            //->where("financeiro_id","!=",7)
            ->where("financeiro_id","=",5)
            ->whereHas('clientes',function($query) use($fisica){
                $query->where('pessoa_fisica',$fisica);
            })
            ->with('clientes',function($query) use($fisica){
                $query->where('pessoa_fisica',$fisica);
            })
            ->with(['administradora','financeiro','cidade','acomodacao','comissao','comissao.comissaoLancadas','comissao.premiacaoLancadas','somarCotacaoFaixaEtaria','plano'])
            ->get();
        return $contratos;       
    }

    public function listarComissoes()
    {
        $fisica = 1;
        $contratos = Cotacao::where("user_id",auth()->user()->id)
            //->where("financeiro_id","!=",7)
            ->where("financeiro_id","=",6)
            ->whereHas('clientes',function($query) use($fisica){
                $query->where('pessoa_fisica',$fisica);
            })
            ->with('clientes',function($query) use($fisica){
                $query->where('pessoa_fisica',$fisica);
            })
            ->with(['administradora','financeiro','cidade','acomodacao','comissao','comissao.comissaoLancadas','comissao.premiacaoLancadas','somarCotacaoFaixaEtaria','plano'])
            ->get();
        return $contratos;       
    }

    public function listarFinalizado()
    {
        $fisica = 1;
        $contratos = Cotacao::where("user_id",auth()->user()->id)
            //->where("financeiro_id","!=",7)
            ->where("financeiro_id","=",7)
            ->whereHas('clientes',function($query) use($fisica){
                $query->where('pessoa_fisica',$fisica);
            })
            ->with('clientes',function($query) use($fisica){
                $query->where('pessoa_fisica',$fisica);
            })
            ->with(['administradora','financeiro','cidade','acomodacao','comissao','comissao.comissaoLancadas','comissao.premiacaoLancadas','somarCotacaoFaixaEtaria','plano'])
            ->get();
        return $contratos;       
    }

    /*************************************************** */
    public function aguardandoBoletoColetivoPJ()
    {
        $fisica = 1;
        $contratos = Cotacao::where("user_id",auth()->user()->id)
            //->where("financeiro_id","!=",7)
            ->where("financeiro_id","=",1)
            ->whereHas('clientes',function($query) use($fisica){
                $query->where('pessoa_juridica',$fisica);
            })
            ->with('clientes',function($query) use($fisica){
                $query->where('pessoa_juridica',$fisica);
            })
            ->with(['administradora','financeiro','cidade','acomodacao','comissao','comissao.comissaoLancadas','comissao.premiacaoLancadas','somarCotacaoFaixaEtaria','plano'])
            ->get();
        return $contratos;       
    }

    public function aguardandoPagamentoAdesaoColetivoPJ()
    {
        $fisica = 1;
        $contratos = Cotacao::where("user_id",auth()->user()->id)
            //->where("financeiro_id","!=",7)
            ->where("financeiro_id","=",2)
            ->whereHas('clientes',function($query) use($fisica){
                $query->where('pessoa_juridica',$fisica);
            })
            ->with('clientes',function($query) use($fisica){
                $query->where('pessoa_juridica',$fisica);
            })
            ->with(['administradora','financeiro','cidade','acomodacao','comissao','comissao.comissaoLancadas','comissao.premiacaoLancadas','somarCotacaoFaixaEtaria','plano'])
            ->get();
        return $contratos;       
    }

    public function aguardandoPagamentoPlanoIndividualPJ()
    {
        $fisica = 1;
        $contratos = Cotacao::where("user_id",auth()->user()->id)
            //->where("financeiro_id","!=",7)
            ->where("financeiro_id","=",3)
            ->whereHas('clientes',function($query) use($fisica){
                $query->where('pessoa_juridica',$fisica);
            })
            ->with('clientes',function($query) use($fisica){
                $query->where('pessoa_juridica',$fisica);
            })
            ->with(['administradora','financeiro','cidade','acomodacao','comissao','comissao.comissaoLancadas','comissao.premiacaoLancadas','somarCotacaoFaixaEtaria','plano'])
            ->get();
        return $contratos;       
    }

    public function aguardandoPagamentoVigenciaPJ()
    {
        $fisica = 1;
        $contratos = Cotacao::where("user_id",auth()->user()->id)
            //->where("financeiro_id","!=",7)
            ->where("financeiro_id","=",4)
            ->whereHas('clientes',function($query) use($fisica){
                $query->where('pessoa_juridica',$fisica);
            })
            ->with('clientes',function($query) use($fisica){
                $query->where('pessoa_juridica',$fisica);
            })
            ->with(['administradora','financeiro','cidade','acomodacao','comissao','comissao.comissaoLancadas','comissao.premiacaoLancadas','somarCotacaoFaixaEtaria','plano'])
            ->get();
        return $contratos;       
    }

    public function aguardandoPagamentoEmpresarialPJ()
    {
        $fisica = 1;
        $contratos = Cotacao::where("user_id",auth()->user()->id)
            //->where("financeiro_id","!=",7)
            ->where("financeiro_id","=",5)
            ->whereHas('clientes',function($query) use($fisica){
                $query->where('pessoa_juridica',$fisica);
            })
            ->with('clientes',function($query) use($fisica){
                $query->where('pessoa_juridica',$fisica);
            })
            ->with(['administradora','financeiro','cidade','acomodacao','comissao','comissao.comissaoLancadas','comissao.premiacaoLancadas','somarCotacaoFaixaEtaria','plano'])
            ->get();
        return $contratos;       
    }

    public function listarComissoesPJ()
    {
        $fisica = 1;
        $contratos = Cotacao::where("user_id",auth()->user()->id)
            //->where("financeiro_id","!=",7)
            ->where("financeiro_id","=",6)
            ->whereHas('clientes',function($query) use($fisica){
                $query->where('pessoa_juridica',$fisica);
            })
            ->with('clientes',function($query) use($fisica){
                $query->where('pessoa_juridica',$fisica);
            })
            ->with(['administradora','financeiro','cidade','acomodacao','comissao','comissao.comissaoLancadas','comissao.premiacaoLancadas','somarCotacaoFaixaEtaria','plano'])
            ->get();
        return $contratos;       
    }

    public function listarFinalizadoPJ()
    {
        $fisica = 1;
        $contratos = Cotacao::where("user_id",auth()->user()->id)
            //->where("financeiro_id","!=",7)
            ->where("financeiro_id","=",7)
            ->whereHas('clientes',function($query) use($fisica){
                $query->where('pessoa_juridica',$fisica);
            })
            ->with('clientes',function($query) use($fisica){
                $query->where('pessoa_juridica',$fisica);
            })
            ->with(['administradora','financeiro','cidade','acomodacao','comissao','comissao.comissaoLancadas','comissao.premiacaoLancadas','somarCotacaoFaixaEtaria','plano'])
            ->get();
        return $contratos;       
    }


    /*************************************************** */






    public function listarContratosPJ(Request $request)
    {
        $juridico = 1;
        $qtdAguardandoBoletoColetivo = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id","=",1)->whereHas('clientes',function($query) use($juridico){$query->where('pessoa_juridica',$juridico);})->count();
        $qtdAguardandoPagAdesaoColetivo = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id","=",2)->whereHas('clientes',function($query) use($juridico){$query->where('pessoa_juridica',$juridico);})->count();
        $qtdAguardandoPagPlanoIndividual = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id","=",3)->whereHas('clientes',function($query) use($juridico){$query->where('pessoa_juridica',$juridico);})->count();
        $qtdPagVigencia = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id","=",4)->whereHas('clientes',function($query) use($juridico){$query->where('pessoa_juridica',$juridico);})->count();
        $qtdAguardandoPagEmpresarial = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id","=",5)->whereHas('clientes',function($query) use($juridico){$query->where('pessoa_juridica',$juridico);})->count();
        $qtdComissoes = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id","=",6)->whereHas('clientes',function($query) use($juridico){$query->where('pessoa_juridica',$juridico);})->count();
        $qtdFinalizado = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id","=",7)->whereHas('clientes',function($query) use($juridico){$query->where('pessoa_juridica',$juridico);})->count();



        return view("admin.pages.contrato.pessoa_juridica.pendentes",[
            "qtdAguardandoBoletoColetivo" => $qtdAguardandoBoletoColetivo,
            "qtdAguardandoPagAdesaoColetivo" => $qtdAguardandoPagAdesaoColetivo,
            "qtdAguardandoPagPlanoIndividual" => $qtdAguardandoPagPlanoIndividual,
            "qtdPagVigencia" => $qtdPagVigencia,
            "qtdAguardandoPagEmpresarial" => $qtdAguardandoPagEmpresarial,
            "qtdComissoes" => $qtdComissoes,
            "qtdFinalizado" => $qtdFinalizado            




        ]);
    }

    public function listarContratosPJPendentes()
    {
        $juridica = 1;
        $contratos = Cotacao::where("user_id",auth()->user()->id)
            //->where("financeiro_id","!=",7)
            ->whereRaw("financeiro_id IS NOT NULL")
            ->whereHas('clientes',function($query) use($juridica){
                $query->where('pessoa_juridica',$juridica);
            })
            ->with('clientes',function($query) use($juridica){
                $query->where('pessoa_juridica',$juridica);
            })
            ->with(['administradora','financeiro','cidade','acomodacao','comissao','comissao.comissaoLancadas','comissao.premiacaoLancadas','somarCotacaoFaixaEtaria','plano'])
            ->orderBy('updated_at','DESC')
            ->get();
        return $contratos;              
    }

    public function listarDetalhesComissao(Request $request)
    {
        $cotacao = Cotacao::where("id",$request->cotacao)
            ->with(['comissao','comissao.comissaoLancadas','comissao.premiacaoCorretorLancados'])
        
            ->first();
        // return $cotacao->comissao->comissaoLancadas;
        return view('admin.pages.contrato.pessoa_fisica.comissoes_premiacoes',[
            "cotacao" => $cotacao
        ]);
    }

    /********* FIM Contratos ********/
   
}
