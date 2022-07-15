<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Cidade,
    Cliente,
    Etiquetas,
    Tarefa,
    User,
    Administradora,
    Operadora,
    Planos
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
        
        if(auth()->user()->admin) {
            $clientes = Cliente::where("etiqueta_id","!=",3)
                ->selectRaw("(SELECT name FROM users WHERE users.id = clientes.user_id) as user")
                ->selectRaw("nome,etiqueta_id,email,created_at,ultimo_contato,telefone,pessoa_fisica,pessoa_juridica,id")
                ->selectRaw("(SELECT nome FROM cidades WHERE cidades.id = clientes.cidade_id) AS cidade")
                ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE tarefas.cliente_id = clientes.id) AS tarefas_quantidade")
                ->selectRaw("(SELECT if(SUM(quantidade) >= 1,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id = (SELECT id FROM cotacoes WHERE cotacoes.cliente_id = clientes.id)) AS quantidade")
                ->selectRaw("(SELECT cor FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS cor")
                ->selectRaw("(SELECT nome FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS nome_etiqueta")
                
                ->get();
                    
            $etiquetas = Etiquetas::all();
            return view('admin.pages.clientes.index',[
                'clientes' => $clientes,
                'etiquetas' => $etiquetas
            ]);
        } else {
            $clientes = Cliente::where("user_id",$id)->where("etiqueta_id","!=",3)
                ->selectRaw("nome,etiqueta_id,email,created_at,ultimo_contato,telefone,pessoa_fisica,pessoa_juridica,id")
                ->selectRaw("(SELECT nome FROM cidades WHERE cidades.id = clientes.cidade_id) AS cidade")
                ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE tarefas.cliente_id = clientes.id) AS tarefas_quantidade")
                ->selectRaw("(SELECT if(SUM(quantidade) >= 1,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id = (SELECT id FROM cotacoes WHERE cotacoes.cliente_id = clientes.id)) AS quantidade")
                ->selectRaw("(SELECT cor FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS cor")
                ->selectRaw("(SELECT nome FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS nome_etiqueta")
                
                ->get();
                    
            $etiquetas = Etiquetas::all();
            return view('admin.pages.clientes.index',[
                'clientes' => $clientes,
                'etiquetas' => $etiquetas
            ]);
        }




        
    }

    public function create()
    {
        $cidades = Cidade::all();
        return view('admin.pages.clientes.cadastrar',[
            "cidades" => $cidades
        ]);
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

        if(empty($request->telefone)) {
            return "errortelefone";
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



    public function agendaTarefa($id)
    {
        
        $cliente = Cliente::where("id",$id)
            ->with('tarefas')
            ->first();
            
        
        if(!$cliente) {
            return redirect()->back();
        }

        return view('admin.pages.clientes.tarefas',[
            "cliente" => $cliente
        ]);

    }

    public function cadastrarTarefa(Request $request)
    {
        
        $rules = [
            "title" => "required",
            "data" => "required",
            "descricao" => "required"
        ];

        $message = [
            "title.required" => "O campo titulo e campo obrigatório",
            "data.required" => "O campo data e campo obrigatório",
            "descricao.required" => "Descrição e campo obrigatório"
        ];

        $request->validate($rules,$message);

        $cliente = Cliente::where("id",$request->cliente_id)->first();
        $cliente->ultimo_contato = date("Y-m-d");
        $cliente->save();

        Tarefa::create($request->all());
        return redirect()->route('clientes.agendarTarefa',[$request->cliente_id]);
        
    }

    public function clienteTarefaEspecifica(Request $request)
    {
        $tarefas = DB::table("tarefas")
            ->selectRaw("title")
            ->selectRaw("id")
            ->selectRaw("descricao")
            ->selectRaw("DATE_FORMAT(DATA, '%Y-%m-%d') as start")
            ->whereRaw("tarefas.cliente_id = ".$request->id)
            ->get();
           
        return response()->json($tarefas);
    }

    public function alterarClienteTarefaEspecifica(Request $request)
    {
        $id = $request->tarefa_id;
        $title = $request->title;
        $data = $request->data;
        $descricao = $request->descricao;
        $tarefa = Tarefa::where("id",$id)->first();
        $tarefa->update(["title"=>$title,"data"=>$data,"descricao"=>$descricao]);
        $tarefa->save();
        return redirect()->route('clientes.agendarTarefa',[$request->cliente_id]);
    }

    public function tarefaEventDropEdit(Request $request)
    {
        $id = $request->id;
        $start = $request->start;
        $tarefa = Tarefa::where("id",$id)->first();
        $tarefa->data = $start;
        $tarefa->save();
        

    }

    public function deletarCliente(Request $request)
    {
        $id = $request->id;
        $cliente = $request->cliente;
        $tarefa = Tarefa::where("id",$id)->first();
        $tarefa->delete();
        return redirect()->route('clientes.agendarTarefa',[$cliente]);
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
        $id = auth()->user()->id;
        $contratos = Cliente::where("user_id",$id)->where("etiqueta_id","=",3)->with(['cotacao','user','cotacao.administradora','cidade','cotacao.acomodacao'])->get();
        return view("admin.pages.contrato.index",[
            "contratos" => $contratos
        ]);    
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
            return "Sem Clientes Para Listar Com esse status";
       }       
    }


    public function listarPorEtiquetaAll()
    {
       $id = auth()->user()->id;
       $clientes = $this->repository->where("user_id",$id)
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
