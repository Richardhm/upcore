<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Models\{
    User,
    Etiquetas,
    Cliente,
    Tabela,
    OrcamentoFaixaEtaria,
    ClienteOrcamento,
    Orcamento,
    
};

class OrcamentoController extends Controller
{
     
    public function index()
    {
        $this->middleware(['can'=>'cadastrar_orcamentos']);
        $cidades = DB::table("cidades")->get();
        return view("admin.pages.orcamento.index",[
            "cidades" => $cidades
        ]);
    }

    public function criarPDF($id_orcamento,$id_cidade,$plano_id,$coparticipacao,$odonto,$operadora_id,$administradora_id)
    {
        $planos = DB::table('tabelas')
            ->join("orcamento_faixa_etarias",'tabelas.faixa_etaria', '=', 'orcamento_faixa_etarias.faixa_etaria_id')
            ->selectRaw("tabelas.id")
            ->selectRaw("tabelas.plano_id")
            ->selectRaw("tabelas.modelo")
            ->selectRaw("tabelas.valor")
            ->selectRaw("tabelas.cidade_id")
            ->selectRaw("tabelas.coparticipacao")
            ->selectRaw("tabelas.odonto")
            ->selectRaw("tabelas.operadora_id")
            ->selectRaw("tabelas.administradora_id")
            ->selectRaw("orcamento_faixa_etarias.quantidade")
            ->selectRaw("(tabelas.valor * orcamento_faixa_etarias.quantidade) AS Total")
            ->selectRaw("(SELECT nome FROM faixas_etarias WHERE faixas_etarias.id = tabelas.faixa_etaria) AS faixas")
            ->selectRaw("tabelas.faixa_etaria")
            ->selectRaw("(SELECT nome FROM administradoras WHERE administradoras.id = tabelas.administradora_id) admin_nome")
            ->selectRaw("(SELECT logo FROM administradoras WHERE administradoras.id = tabelas.administradora_id) admin_logo")
            ->selectRaw("if(coparticipacao,'Com Copartipacao','Sem Coparticipacao') AS copartipicao_texto")
            ->selectRaw("if(odonto,'Com Odonto','Sem Odonto') AS odonto_texto")
            ->selectRaw("(SELECT nome FROM planos WHERE tabelas.plano_id = planos.id) plano")
            ->whereRaw("orcamento_faixa_etarias.orcamento_id = ".$id_orcamento." AND cidade_id = ".$id_cidade." AND coparticipacao = ".$coparticipacao." AND odonto = ".$odonto." AND operadora_id = ".$operadora_id." AND plano_id = ".$plano_id." AND administradora_id = ".$administradora_id)    
            ->get();
      
        $faixas = OrcamentoFaixaEtaria::where("orcamento_id","=",$id_orcamento)
                ->selectRaw("(SELECT nome FROM faixas_etarias WHERE faixas_etarias.id = orcamento_faixa_etarias.faixa_etaria_id) AS faixa_nome")  
                ->get();
                   

                
        // @ts-ignore
        $pdf = PDF::loadView('admin.pages.orcamento.pdf',[
            'planos'=>$planos,
            'faixas'=>$faixas,
            'orcamento' => 2
        ]);
        return $pdf->download('lista-de-tarefa.pdf');
    }

    public function montarPlano(Request $request)
    {
        
        // $this->middleware(['can'=>'cadastrar_orcamentos']);
        if(empty($request->nome) || empty($request->telefone) || empty($request->email) || empty($request->cidade)) {
            return "error";
        }

        if(!preg_match('/^\([1-9]{2}\) [0-9]{1} [0-9]{4}-[0-9]{4}$/',$request->telefone)) {
            return "error";
        }

        if(!filter_var($request->email,FILTER_VALIDATE_EMAIL)) {
            return "error";
        }

        if(empty($request->faixas[0][1]) && empty($request->faixas[0][2]) && empty($request->faixas[0][3]) && empty($request->faixas[0][4]) && empty($request->faixas[0][5]) && empty($request->faixas[0][6]) && empty($request->faixas[0][7]) && empty($request->faixas[0][8]) && empty($request->faixas[0][9]) && empty($request->faixas[0][10])) {
            return "error";
        }

        // if(($request->pessoa_fisica == "false") && ($request->pessoa_juridica == "false")) {
        //     return "error";
        // }

        // if(($request->pessoa_fisica == "true") && ($request->pessoa_juridica == "true")) {
        //     return "error";
        // }

        if($request->modelo == "pf") {
            $where_planos_pegar = ' AND (plano_id = (SELECT id FROM planos WHERE NOME LIKE "%Coletivo Por Adesão%") OR plano_id = (SELECT id FROM planos WHERE NOME LIKE "%Individual%"))';
        } else {
            $where_planos_pegar = ' AND (plano_id = (SELECT id FROM planos WHERE nome LIKE "%PME Boletado%") OR plano_id = (SELECT id FROM planos WHERE NOME LIKE "%Super Simples%"))';
        }
        
        $verificarPlano = Tabela::where(function($query) use($request){
            $query->where("cidade_id",$request->cidade);
            ///$query->where("administradora_id",$request->operadora);
            //$query->where("coparticipacao",($request->coparticipacao == "sim" ? 1 : 0));
            //$query->where("odonto",($request->odonto == "sim" ? 1 : 0));
        })->get();        
        if(count($verificarPlano) >= 1) {           
            $cliente = Cliente::where(function($query) use($request){
                $query->where("nome",$request->nome);  
                $query->where("email",$request->email);
                //$query->where("cidade_id",$request->cidade);
                $query->where("telefone",$request->telefone);  
            })->first();
            if(!$cliente) {
                $cliente = User::find(auth()->user()->id)->cliente()->create([
                    "nome" => $request->nome,
                    "telefone" => $request->telefone,
                    "email" => $request->email,
                    "cidade_id" => $request->cidade,
                    "pessoa_fisica" => $request->modelo == "pf" ? 1 : 0,
                    "pessoa_juridica" => $request->modelo == "pj" ? 1 : 0
                    
                    
                ]);
            }
            $cliente->etiqueta_id = 2;
            $cliente->save();     
            


            $orcamento = new Orcamento();
            $orcamento->cliente_id = $cliente->id;
            $orcamento->user_id = auth()->user()->id;
            $orcamento->corretora_id = auth()->user()->corretora_id;
            $orcamento->pessoa_fisica = $request->modelo == "pf" ? 1 : 0;
            $orcamento->pessoa_juridica = $request->modelo == "pj" ? 1 : 0;
            $orcamento->desconto = ($request->desconto != null ? $request->desconto : 0);
            $orcamento->premiacao = ($request->premiacao != null ? $request->premiacao : 0);
            if($request->modelo == "pj") {
                $orcamento->cnpj = $request->cnpj;
                $orcamento->nome_empresa = $request->nome_empresa;
            }
                        
            $orcamento->save();        
            $faixas = $request->faixas[0];
            foreach($faixas as $k => $v) {
                if($v != 0) {
                    $orcamentoFaixaEtaria = new OrcamentoFaixaEtaria();
                    $orcamentoFaixaEtaria->orcamento_id = $orcamento->id;
                    $orcamentoFaixaEtaria->faixa_etaria_id = $k;
                    $orcamentoFaixaEtaria->quantidade = $v;
                    $orcamentoFaixaEtaria->save();
                } 
            }
            ClienteOrcamento::create([
                'cliente_id' => $cliente->id,
                'orcamento_id' => $orcamento->id,
                'cidade_id' => $request->cidade
            ]);
           

            $planos = DB::table('tabelas')
                ->join("orcamento_faixa_etarias",'tabelas.faixa_etaria', '=', 'orcamento_faixa_etarias.faixa_etaria_id')
                ->selectRaw("tabelas.id")
                ->selectRaw("tabelas.modelo")
                ->selectRaw("tabelas.plano_id")
                ->selectRaw("tabelas.valor")
                ->selectRaw("tabelas.operadora_id")
                ->selectRaw("tabelas.administradora_id")
                ->selectRaw("tabelas.cidade_id")
                ->selectRaw("tabelas.coparticipacao")
                ->selectRaw("tabelas.odonto")
                ->selectRaw("orcamento_faixa_etarias.quantidade")
                ->selectRaw("(tabelas.valor * orcamento_faixa_etarias.quantidade) AS Total")
                ->selectRaw("(SELECT nome FROM faixas_etarias WHERE faixas_etarias.id = tabelas.faixa_etaria) AS faixas")
                ->selectRaw("(SELECT nome FROM administradoras WHERE administradoras.id = tabelas.administradora_id) AS admin_nome")
                ->selectRaw("(SELECT logo FROM administradoras WHERE administradoras.id = tabelas.administradora_id) AS admin_logo")
                ->selectRaw("if(coparticipacao,'Com Copartipacao','Sem Coparticipacao') AS copartipicao_texto")
                ->selectRaw("(SELECT nome FROM planos WHERE tabelas.plano_id = planos.id) plano")
                ->selectRaw("if(odonto,'Com Odonto','Sem Odonto') AS odonto_texto")
                ->selectRaw("case 
                    when coparticipacao = 1 AND odonto = 1 AND plano_id = (SELECT id FROM planos WHERE planos.id = tabelas.plano_id) AND administradora_id = (SELECT id FROM administradoras WHERE administradoras.id = tabelas.administradora_id)
                        then CONCAT('Card_Coparticipaca_Odonto_',(SELECT nome FROM planos WHERE planos.id = tabelas.plano_id),'_',(SELECT nome FROM administradoras WHERE administradoras.id = tabelas.administradora_id))
                    
                    when coparticipacao = 1 AND odonto = 0 AND plano_id = (SELECT id FROM planos WHERE planos.id = tabelas.plano_id) AND administradora_id = (SELECT id FROM administradoras WHERE administradoras.id = tabelas.administradora_id)
                    then CONCAT('Card_Coparticipaca_Sem_Odonto_',(SELECT nome FROM planos WHERE planos.id = tabelas.plano_id),'_',(SELECT nome FROM administradoras WHERE administradoras.id = tabelas.administradora_id))
                    		
                
                    when coparticipacao = 0 AND odonto = 0 AND plano_id = (SELECT id FROM planos WHERE planos.id = tabelas.plano_id) AND administradora_id = (SELECT id FROM administradoras WHERE administradoras.id = tabelas.administradora_id)
                        then CONCAT('Card_Sem_Coparticipaca_Sem_Odonto_',(SELECT nome FROM planos WHERE planos.id = tabelas.plano_id),'_',(SELECT nome FROM administradoras WHERE administradoras.id = tabelas.administradora_id))
                    	
                    
                    when coparticipacao = 0 AND odonto = 1 AND plano_id = (SELECT id FROM planos WHERE planos.id = tabelas.plano_id) AND administradora_id = (SELECT id FROM administradoras WHERE administradoras.id = tabelas.administradora_id)
                    then CONCAT('Card_Sem_Coparticipaca_Com_Odonto_',(SELECT nome FROM planos WHERE planos.id = tabelas.plano_id),'_',(SELECT nome FROM administradoras WHERE administradoras.id = tabelas.administradora_id))
                    
                        	
                END AS card")
                ->whereRaw("cidade_id = ".$request->cidade." AND orcamento_faixa_etarias.orcamento_id = ".$orcamento->id.$where_planos_pegar)
                ->orderBy("tabelas.id")
                ->get();

            

              
                       
            $faixas = OrcamentoFaixaEtaria::where("orcamento_id","=",$orcamento->id)
                ->selectRaw("(SELECT nome FROM faixas_etarias WHERE faixas_etarias.id = orcamento_faixa_etarias.faixa_etaria_id) AS faixa_nome")  
                ->get();
               
                              
            return view('admin.pages.orcamento.mostarPlano',[
                'planos' => $planos,
                'orcamento' => $orcamento->id,
                'faixas' => $faixas->toArray(),
                'fisica' => $request->modelo == "pf" ? 1 : 0,
                'juridica' => $request->modelo == "pj" ? 1 : 0,
                'telefone' =>  str_replace(["-","(",")"," "],"",  $request->telefone),
                'cidade' => $request->cidade,
                'cliente' => $cliente->id
                    
            ]); 

        } else {
            $planos = [];
            return view('admin.pages.orcamento.mostarPlano',[
                'planos' => $planos,
                'orcamento' => ""
            ]);     
        }       
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

    public function listarAdministrador($id)
    {
        
        $admin = User::where("id",$id)->where("admin",1)->first();
        if(!$admin) {
            return redirect()->route('dashboard.index');
        }
        $clientes = DB::table('clientes')
            ->selectRaw("nome,id")
            ->selectRaw("(SELECT COUNT(*) FROM cliente_orcamento WHERE clientes.id = cliente_orcamento.cliente_id AND clientes.user_id = ".$id.") AS quantidade")
            ->whereRaw('user_id = '.$id)
            ->get();
        return view("admin.pages.orcamento.administrador.listar-orcamento-administrador",[
            "clientes" => $clientes
        ]);
    }

    public function listarOrcamentoPorCliente($id)
    {
        $this->middleware(['can:listar_orcamentos']);
        $cliente = Cliente::where("id",$id)->first();
        if(!$cliente) {
            return redirect()->back();
        }    
        $orcamentos = $cliente->orcamentos()
            ->selectRaw("IF(odonto = 1,'Sim','NAO') AS odonto")
            ->selectRaw("IF(coparticipacao = 1,'Sim','NAO') AS coparticipacao")
            ->selectRaw("id,administradora_id")
            ->selectRaw("status")
            ->with('administradora')->get();   
                  
        return view('admin.pages.orcamento.administrador.listar-orcamento-por-cliente',[
            "orcamentos" => $orcamentos,
            "cliente" => $cliente
        ]);
    }

    public function orcamentosCorretoresDaCorretora($idCorretora,$idAdministrador) 
    {
        $this->middleware(['can:orcamentos_corretores']);
        $id = auth()->user()->id;
        $userLogado = User::find($id);
        if($userLogado->corretora_id != $idCorretora) {
            return redirect()->route('dashboard.index');
        }

        if(!$userLogado->admin) {
            return redirect()->route('dashboard.index');
        }


        $user = User::where("id",$idAdministrador)->where("corretora_id",$idCorretora)->first();
        if(!$user) {
            return redirect()->route('dashboard.index');
        }
        $corretores = User::where("corretora_id",$idCorretora)->where("id","!=",$idAdministrador)->get();
        return view("admin.pages.orcamento.administrador.listar-corretores-por-corretora",[
            'corretores' => $corretores
        ]);
    }


    public function showOrcamentoUnico($id) 
    {
        $this->middleware(['can:listar_orcamentos']);
        $orcamento = Orcamento::where('id',$id)->first(); 
        if(!$orcamento) {
            return redirect()->back();
        } 
        $cidade = DB::table('cliente_orcamento')
            ->selectRaw("(SELECT nome FROM cidades WHERE cidades.id = cliente_orcamento.cidade_id) as cidade")
            ->where("orcamento_id",$id)
            ->first();
            
        
       
        $faixas = $orcamento->faixas()->get();
        return view('admin.pages.orcamento.administrador.listar-orcamento-por-id-orcamento',[
            "cliente" => $orcamento->clientes[0],
            "plano" => $orcamento->administradora->nome,
            "faixas" => $faixas,
            "total" => $orcamento->total($faixas),
            "etiquetas" => Etiquetas::all(),
            "status" => $orcamento->status,
            "id" => $id,
            "odonto" => ($orcamento->odonto == 1 ? "Sim" : "Não"),
            "coparticipacao" => ($orcamento->coparticipacao == 1 ? "Sim" : "Não"),
            "cidade" => $cidade
        ]);    
    }

    public function mudarStatusEtiqueta(Request $request)
    {
        $this->middleware(['can:cadastrar_orcamentos']);
        $orcamento = $request->orcamento;
        $etiqueta = $request->etiqueta;
        $orcamento = Orcamento::find($orcamento);
        $orcamento->status = $etiqueta;
        $orcamento->save();
        return true;
    }


    public function listarCorretor()
    {
        $this->middleware(['can:listar_orcamentos']);
        $corretora_id = auth()->user()->corretora_id;
        $id = auth()->user()->id;
        $user = User::find($id);
        if(!$user) {
            return redirect()->back();
        }       
        $clientes = DB::table('clientes')
            ->selectRaw("nome,id")
            ->selectRaw("(SELECT COUNT(*) FROM cliente_orcamento WHERE clientes.id = cliente_orcamento.cliente_id AND clientes.user_id = ".$id.") AS quantidade")
            ->whereRaw('user_id = '.$id)
            ->get();
          
        return view("admin.pages.orcamento.listar-orcamento-corretor",[
            "clientes" => $clientes
        ]);
    }

    public function listarOrcamentoPorCorretor($idCorretor)
    {
        
        $this->middleware(['can:orcamentos_corretores']);
        $corretor = User::find($idCorretor);
        if(!$corretor) {
            return redirect()->back();
        }

        $orcamentos = $corretor
            ->orcamentos()
            ->selectRaw("id,cliente_id,administradora_id,status,created_at")
            ->selectRaw("(SELECT nome FROM clientes WHERE clientes.id = orcamentos.cliente_id) as cliente")
            ->with(['administradora'])
            ->get();
        
         
        
        return view("admin.pages.orcamento.administrador.listar-orcamento-corretor-especifico",[
            'orcamentos' => $orcamentos,
            'corretor' => $corretor
        ]);
    }

    public function listarOrcamentoDetalhe($idOrcamento)
    {
        $this->middleware(['can:orcamentos_corretores']);
        $orcamento = Orcamento::where('id',$idOrcamento)->first(); 
        if(!$orcamento) {
            return redirect()->back();
        } 

        $faixas = $orcamento->faixas()->get();
        $nome_corretor = User::where("id",$orcamento->user_id)->selectRaw("name")->first();
        
        // dd($orcamento->clientes[0]->nome);

        return view('admin.pages.orcamento.administrador.listar-orcamento-detalhe-corretor',[
            "cliente" => $orcamento->clientes[0],
            "logo" => $orcamento->administradora->logo,
            "faixas" => $faixas,
            "total" => $orcamento->total($faixas),
            "etiquetas" => Etiquetas::where("id",$orcamento->status)->first(),
            "status" => $orcamento->status,
            "id" => $idOrcamento,
            "data_criacao" => $orcamento->created_at,
            "id_corretora" => $orcamento->corretora_id,
            "id_administrador" => auth()->user()->id,
            "id_corretor" => $orcamento->user_id,
            "nome_corretor" => $nome_corretor
        ]);    
    }






}
