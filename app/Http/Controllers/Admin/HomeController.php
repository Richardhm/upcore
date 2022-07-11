<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,
    Cidade,
    Cliente,
    Orcamento,
    Contrato,
    ComissoesVendedor,
    Cotacao,
    Etiquetas,
    Tarefa
};

use Illuminate\Support\Facades\DB;

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
            $orcamentosHoje = Orcamento::where("corretora_id",auth()->user()->corretora_id)->whereDate("created_at","=",date('Y-m-d'))->count();
            $orcamentosAll = Orcamento::where("corretora_id",auth()->user()->corretora_id)->count();
            $contratosHoje = Contrato::whereDate("created_at","=",date("Y-m-d"))->get()->count();

            $contratosAll = Contrato::get()->count();
            
            return view('admin.pages.home.administrador',[
                "corretores" => $corretores,
                "cidades" => $cidades,
                "orcamentosHoje" => $orcamentosHoje,
                "orcamentosAll" => $orcamentosAll,
                "contratosHoje" => $contratosHoje, 
                "contratosAll" => $contratosAll 
            ]);
        } else {

            
            
            $totalCliente    = Cliente::where("user_id",auth()->user()->id)->count();
            $clienteFechados = Cotacao::where("user_id",auth()->user()->id)->whereHas('clientes',function($query){
                $query->where('etiqueta_id','=',3);
            })->count();
            $etiquetas = Etiquetas::selectRaw('id,nome,cor')->selectRaw('(SELECT count(id) FROM clientes WHERE clientes.etiqueta_id = etiquetas.id) AS quantidade')->paginate(5);
            $tarefas = Tarefa::paginate(5,['*'], 'tarefas');

            $tarefas->withPath('/admin');
            $clientes = Cliente::where("user_id",auth()->user()->id)->where('etiqueta_id',"!=",3)
                ->selectRaw("created_at,nome,telefone")    
                ->selectRaw("(SELECT cor FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS status")

                ->paginate(5,['*'], 'clientes');

            return view('admin.pages.home.colaborador',[
                "totalCliente" => $totalCliente,
                "clienteFechados" => $clienteFechados,
                "etiquetas" => $etiquetas,
                "tarefas" => $tarefas,
                "clientes" => $clientes

            ]);    
        }
    }

    public function orcamentosAdministrador(Request $request)
    {
        if($request->ajax()) {
            $user = User::find(auth()->user()->id);
            if(!$user || !$user->admin) {
                 return redirect()->back();
            }  
            $orcamentos = $user
                ->orcamentos()
                ->selectRaw("(SELECT nome FROM clientes WHERE clientes.id = orcamentos.cliente_id) AS cliente")
                //->selectRaw("(SELECT nome FROM administradoras WHERE administradoras.id = orcamentos.administradora_id) AS administradora")
                ->selectRaw("(SELECT COUNT(*) FROM cliente_orcamento WHERE cliente_orcamento.cliente_id = orcamentos.cliente_id) AS quantidade")
                ->groupByRaw("orcamentos.cliente_id")
                ->get();
            return response()->json($orcamentos);
        }
       
    }

    public function outherorcamentos(Request $request)
    {
        if($request->ajax()) {
            $user = User::find(auth()->user()->id);
            
            $corretores = User::where("corretora_id",$user->corretora_id)->where("id","!=",$user->id)->get();

            $user = User::find(auth()->user()->id);       
            $corretores = DB::table("orcamentos")
                //>selectRaw("(case when (STATUS = 1) then '<span class=\"badge badge-primary\">Em Aberto</span>' when (STATUS = 2) then 'Finalizado' when (STATUS = 3) then 'Vai Fechar' when (STATUS = 4) then 'Sem Interesse' when (STATUS = 5) then 'Aguardando Documentação' END) AS status_texto")
                ->selectRaw("(SELECT name FROM users WHERE orcamentos.user_id = users.id) AS corretor")
                ->selectRaw("(SELECT nome FROM clientes WHERE clientes.id = orcamentos.cliente_id) as cliente")
                //->selectRaw("(SELECT nome FROM administradoras WHERE administradoras.id = orcamentos.administradora_id) AS administradora")
                ->whereRaw("user_id !=".$user->id)
                ->whereRaw("corretora_id = ".$user->corretora_id)
                ->get();
            
             
            return response()->json($corretores);
            
        }
            
    }

    public function corretorOrcamentoEspecifico(Request $request)
    {
        
        if($request->ajax()) {
            $id = auth()->user()->id;
            
            $orcamentos = DB::table('orcamentos')
                ->selectRaw("DATE_FORMAT(created_at, '%d/%m/%Y') AS data")
                ->selectRaw("(SELECT nome FROM clientes WHERE clientes.id = orcamentos.cliente_id) AS cliente")
                ->selectRaw("(SELECT telefone FROM clientes WHERE clientes.id = orcamentos.cliente_id) AS telefone")
                ->selectRaw("(SELECT nome FROM cidades WHERE id =  (SELECT cidade_id FROM clientes WHERE clientes.id = orcamentos.cliente_id)) AS cidade")
                ->whereRaw("user_id = ".$id." AND cliente_id NOT IN(SELECT cliente_id FROM contratos WHERE user_id = ".$id.")")
                
                ->get();

            return response()->json($orcamentos); 
        }
        
    }

    public function comissoesAPagar(Request $request)
    {
        if($request->ajax()) {
            $comissoes = DB::table('comissoes_vendedor')
                ->selectRaw("DATE_FORMAT(data, '%d/%m/%Y') AS data")
                ->selectRaw("valor")
                ->selectRaw("(SELECT NAME FROM users WHERE id = (SELECT user_id FROM comissoes WHERE comissoes.id = comissoes_vendedor.comissao_id)) AS corretor")
                ->whereRaw("status = 1")
                ->get();
            return response()->json($comissoes); 
        }    
    }

    public function areceber(Request $request)
    {
        if($request->ajax()) {
            $receber = DB::table('comissoes_vendedor')
                ->selectRaw("DATE_FORMAT(data, '%d/%m/%Y') AS data")
                ->selectRaw("(SELECT valor FROM contratos WHERE id = (SELECT contrato_id FROM comissoes WHERE comissoes.contrato_id = comissoes_vendedor.comissao_id)) AS valor")
                ->selectRaw("(SELECT NAME FROM users WHERE id = (SELECT user_id FROM comissoes WHERE comissoes.id = comissoes_vendedor.comissao_id)) AS corretor")
                ->whereRaw("status = 1")->get();
            return response()->json($receber);    
        }
    }




}
