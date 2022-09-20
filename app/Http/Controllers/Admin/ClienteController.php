<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Cidade,
    Cliente,
    Etiquetas,
    User,
    Administradora,
    ComissoesCorretoresConfiguracoes,
    Operadora,
    Planos,
    Tarefa,
    TarefaMotivoPerda
};
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    private $repository;

    public function __construct(Cliente $cliente)
    {
        $this->repository = $cliente;     
        // $user = User::where("id",auth()->user()->id)->first();
        //dd("olaa");       
        
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
        // $tarefas = Tarefa::where("cliente_id",$id)
        //     ->where("user_id",auth()->user()->id)
        //     ->with('cliente')
        //     ->get();
        // $cliente = Cliente::where("id",$id)->first()->nome;
            
        // return view("admin.pages.clientes.especifico",[
        //     "tarefas" => $tarefas,
        //     "cliente" => $cliente
        // ]);
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
        if(empty($request->modelo)) {
            return "errormodelo";
        }

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
        $dados['pessoa_fisica'] = $request->modelo == "pf" ? 1 : 0;
        $dados['pessoa_juridica'] = $request->modelo == "pj" ? 1 : 0;
        $dados['etiqueta_id'] = 1;
        $dados['ultimo_contato'] = date("Y-m-d");
        
        $cliente = User::find(auth()->user()->id)->cliente()->create($dados);
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

    public function listarContratos()
    {
        
        return view("admin.pages.contrato.index");           
    }

    public function listarContratosAjax(Request $request) 
    {
        if($request->ajax()) {
            $id = auth()->user()->id;
            $user = User::where("id",auth()->user()->id)->first();
            if($user->hasPermission('configuracoes') || $user->isAdmin()) {
                $contratos = Cliente::where("etiqueta_id","=",3)->with(['comissoes','cotacao','cotacao.cotacaoFaixaEtaria','user','cotacao.administradora','cidade','cotacao.acomodacao'])->get();
                return $contratos;
            } else {
                $contratos = Cliente::where("user_id",$id)->where("etiqueta_id","=",3)->with(['comissoes','cotacao','cotacao.cotacaoFaixaEtaria','user','cotacao.administradora','cidade','cotacao.acomodacao'])->get();
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
                    return view('admin.pages.clientes.listar-por-etiqueta',[
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
    
}
