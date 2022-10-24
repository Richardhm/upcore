<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Cidade,
    Cliente,
    Cotacao,
    Tarefa,
    TarefaMotivoPerda,
    TarefasTitulo,
    User
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TarefaController extends Controller
{
    public function index()
    {
        $qtd_atrasada = $clientes = Cliente::where("user_id",auth()->user()->id)->where('lead',0)->whereHas('tarefas',function($query){
            $query->where('status',0);
            $query->whereDate('data','<',date('Y-m-d'));
        })->count(); 
        
        $qtd_hoje = Cliente::where("user_id",auth()->user()->id)->where('lead',0)->whereHas('tarefas',function($query){
            $query->where('status',0);
            $query->whereDate('data',"=",date('Y-m-d'));
        })->count();
        
        $qtd_semana = Cliente::where("user_id",auth()->user()->id)->where('lead',0)->whereHas('tarefas',function($query){
            $query->where('status',0);
            $query->whereRaw("YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND data > now()");
        })->count();
        
        $qtd_mes = Cliente::where("user_id",auth()->user()->id)->where('lead',0)->whereHas('tarefas',function($query){
            $query->where('status',0);
            $query->whereRaw("MONTH(data) = MONTH(NOW())");
        })->count();

        $titulos = TarefasTitulo::where("id","!=",1)->get();

        $clientes_total = Cliente::where("user_id",auth()->user()->id)->count();
        $negociacao = Cliente::where("user_id",auth()->user()->id)->where("etiqueta_id",3)->count();
        $finalizados = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id",6)->count();
        $cadastrado_mes = Cliente::where("user_id",auth()->user()->id)->whereRaw("MONTH(created_at) = MONTH(NOW())")->count();
        $finalizados_mes = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id",6)->whereRaw("MONTH(updated_at) = MONTH(NOW())")->count();

        return view('admin.pages.tarefas.page',[
            'qtd_atrasada' => $qtd_atrasada,
            'qtd_hoje' => $qtd_hoje,
            'qtd_semana' => $qtd_semana,
            'qtd_mes' => $qtd_mes,
            'clientes_total' => $clientes_total,
            'negociacao' => $negociacao,
            'finalizados' => $finalizados,
            'cadastrado_mes' => $cadastrado_mes,
            'finalizados_mes' => $finalizados_mes,
            'titulos' => $titulos
        ]);
        //  $user = User::find(auth()->user()->id);
        //  if($user->isAdmin()) {
        //     $users = DB::table('users')
        //         ->selectRaw("users.id,users.name,users.email")
        //         ->selectRaw("(SELECT COUNT(id) FROM tarefas WHERE tarefas.user_id = users.id) AS tarefas_total")
        //         ->selectRaw("(SELECT COUNT(*) FROM tarefas WHERE tarefas.user_id = users.id AND tarefas.motivo_id = 1) AS preco")
        //         ->selectRaw("(SELECT COUNT(*) FROM tarefas WHERE tarefas.user_id = users.id AND tarefas.motivo_id = 2) AS ja_tem_plano")
        //         ->selectRaw("(SELECT COUNT(*) FROM tarefas WHERE tarefas.user_id = users.id AND tarefas.motivo_id = 3) AS fez_unimed")
        //         ->selectRaw("(SELECT COUNT(*) FROM tarefas WHERE tarefas.user_id = users.id AND tarefas.motivo_id = 4) AS sem_interesse")
        //         ->selectRaw("(SELECT COUNT(*) FROM clientes WHERE clientes.user_id = users.id) AS total_clientes")
        //         ->whereRaw("admin IS NULL")
        //         ->whereRaw("id IN(SELECT user_id FROM permission_user WHERE permission_id IN(SELECT id FROM permissions WHERE NAME = 'clientes' OR NAME LIKE '%tarefas%' OR NAME LIKE '%contratos%') GROUP BY user_id)")
        //         ->get();  
               
        //     return view('admin.pages.tarefas.administrador',[
        //         "users" => $users
        //     ]);


        //  } else {
        //     $cidades = Cidade::all();
        //     $id_user = auth()->user()->id;

        //     $clientes = Cliente::where("user_id",$id_user)->whereHas('tarefas',function($query){
        //         $query->where('status',0);
        //     })->get();

        //     $motivos = TarefaMotivoPerda::all();
        //     $titulos = TarefasTitulo::where("id","!=",1)->get();
        //     return view('admin.pages.tarefas.page',[
        //         "clientes" => $clientes,
        //         "motivos" => $motivos,
        //         "cidades" => $cidades,
        //         "titulos" => $titulos
        //     ]);
        //  }       
    }

   

    public function historicoCliente(Request $request)
    {
        $tarefas = Tarefa::where("cliente_id",$request->id)
            ->orderBy('created_at','desc')
            ->with('titulo')->get();
        
        return view('admin.pages.tarefas.ajax.timeline',[
            "tarefas" => $tarefas
        ]);
    }




    public function listarClientesAjax(Request $request)
    {
        $clientes = Cliente::where("user_id",auth()->user()->id)->get();
        return view('admin.pages.tarefas.ajax.todos-os-clientes',[
            "clientes" => $clientes
        ]);
    }


    


    




    public function cadastrarTitulo(Request $request)
    {
        if(empty($request->titulo)) {
            return "errortitulo";
        }
        TarefasTitulo::create($request->all());
        return "sucesso";
    }

    public function tarefasDetalhes($id)
    {
        $preco = Tarefa::where("user_id",$id)->where("motivo_id",1)->selectRaw("(select nome from clientes where clientes.id = tarefas.cliente_id) as nome")->get();
        $ja_tem_plano = Tarefa::where("user_id",$id)->where("motivo_id",2)->selectRaw("(select nome from clientes where clientes.id = tarefas.cliente_id) as nome")->get();
        $fez_unimed = Tarefa::where("user_id",$id)->where("motivo_id",3)->selectRaw("(select nome from clientes where clientes.id = tarefas.cliente_id) as nome")->get();
        $sem_interesse = Tarefa::where("user_id",$id)
            ->where("motivo_id",4)
            ->selectRaw("title,id,cliente_id")
            ->selectRaw("(select nome from clientes where clientes.id = tarefas.cliente_id) as nome")
            ->get();
        $sem_tarefa = DB::table('clientes')
            ->whereRaw('user_id = ?',$id)
            ->whereRaw('id NOT IN(SELECT cliente_id FROM tarefas WHERE tarefas.user_id = ?)',$id)
            ->get();
        $corretores = User::where("id","!=",$id)
            ->whereRaw("admin IS NULL")
            ->whereRaw("id IN(SELECT user_id FROM permission_user WHERE permission_id IN(SELECT id FROM permissions WHERE NAME = 'clientes' OR NAME LIKE '%tarefas%' OR NAME LIKE '%contratos%') GROUP BY user_id)") 
            ->get();
        $tarefas = Tarefa::where("user_id",$id)->selectRaw("title,descricao,data,(SELECT nome FROM clientes WHERE clientes.id = tarefas.cliente_id) as cliente")->get();

        return view('admin.pages.tarefas.detalhes',[
            "preco" => $preco,
            "ja_tem_plano" => $ja_tem_plano,
            "fez_unimed" => $fez_unimed,
            "sem_interesse" => $sem_interesse,
            "sem_tarefa" => $sem_tarefa,
            "corretores" => $corretores,
            "tarefas" => $tarefas
        ]);
           
    }

    public function detalhesPerda(Request $request)
    {
        $id_tarefa = $request->id_tarefa;
        $tarefa = Tarefa::where("id",$id_tarefa)
            ->selectRaw("title,descricao,descricao_motivo,(SELECT nome FROM tarefa_motivo_perdas WHERE tarefa_motivo_perdas.id = tarefas.motivo_id) as motivo")
            ->selectRaw("(select nome from clientes where clientes.id = tarefas.cliente_id) as cliente")
            ->first();

        return $tarefa;
    }

    public function mudarCorretor(Request $request)
    {
        $cliente = $request->cliente;
        $user = $request->user;
        
        $alt = Cliente::find($cliente);
        $alt->user_id = $user;
        $alt->save();

        $tarefa = Tarefa::where("cliente_id",$cliente)->first();
        $tarefa->user_id = $user;
        $tarefa->save();
        
       
        // if($alt->save()) {
        //     return "sucesso";
        // } else {
        //     return "error";
        // }   
        
        

    }





    public function motivoPerdaTarefa(Request $request)
    {
        
        $cli = Cliente::find($request->motivo_cliente_id);
        $cli->visivel = 0;
        $cli->ultimo_contato = date("Y-m-d");
        $cli->save();

        $tarefa = Tarefa::find($request->tarefa_id_cadastrado_aqui);
        $tarefa->motivo_id = $request->motivo;
        
        if($request->descricao_motivo) {
            $tarefa->descricao_motivo = $request->descricao_motivo;
        }




        if($tarefa->save()) {
            return $cli->id;
        } else {
            return "error";
        }
        
    }



    public function agendaTarefa($id)
    {
        $id_user = auth()->user()->id;
        $clientes = Cliente::where("user_id",$id_user)->get();
        return view('admin.pages.tarefas.page',[
            "clientes" => $clientes
        ]);
    }

    public function listarTarefaEspecificaCategoriaLink(Request $request)
    {
        $tarefas = [];
        switch($request->alvo) {
            case "atraso":
                $tarefas = Tarefa::where("user_id",auth()->user()->id)->whereRaw("data < now()")->where('visivel',1)->with('cliente')->get();
            break;
            case "hoje":
                $tarefas = Tarefa::where("user_id",auth()->user()->id)->whereDate('data',"=",date('Y-m-d'))->where('visivel',1)->with('cliente')->get();
            break;
            case "semana":
                $tarefas = Tarefa::where("user_id",auth()->user()->id)->whereRaw("YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1)")->where('visivel',1)->with('cliente')->get();
            break;    
            case "mes":
                $tarefas = Tarefa::where("user_id",auth()->user()->id)->whereRaw("MONTH(data) = MONTH(NOW())")->where('visivel',1)->with('cliente')->get();
            break;
        }

        if(count($tarefas) >= 1) {
            return view('admin.pages.tarefas.ajax.listar-por-categoria',[
                "tarefas" => $tarefas,
                "titulo" => $request->alvo
            ]);
        } else {
            return $tarefas;
        }
    }

    public function listarTarefaEspecificaCategoriaLinkCliente(Request $request)
    {
        
        $tarefas = [];
        switch($request->alvo) {
            case "atraso":
                $tarefas = Tarefa::where("user_id",auth()->user()->id)->where("cliente_id",$request->cliente)->whereRaw("data < now()")->where('visivel',1)->with('cliente')->toSql();
            break;
            case "hoje":
                $tarefas = Tarefa::where("user_id",auth()->user()->id)->where("cliente_id",$request->cliente)->whereDate('data',"=",date('Y-m-d'))->where('visivel',1)->with('cliente')->get();
            break;
            case "semana":
                $tarefas = Tarefa::where("user_id",auth()->user()->id)->where("cliente_id",$request->cliente)->whereRaw("YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1)")->where('visivel',1)->with('cliente')->get();
            break;    
            case "mes":
                $tarefas = Tarefa::where("user_id",auth()->user()->id)->where("cliente_id",$request->cliente)->whereRaw("MONTH(data) = MONTH(NOW())")->where('visivel',1)->with('cliente')->get();
            break;
        }

        if(count($tarefas) >= 1) {
            return view('admin.pages.tarefas.ajax.listar-por-categoria',[
                "tarefas" => $tarefas,
                "titulo" => $request->alvo
            ]);
        } else {
            return $tarefas;
        }
    }




    public function listarTarefaPeloId(Request $request)
    {
        $id_tarefa = $request->id_tarefa;
        $tarefa = Tarefa::where("id",$id_tarefa)->with('cliente')->first();
        return $tarefa;
    }

    public function pegarHistoricoDoCliente(Request $request) 
    {
        $id_cliente = $request->id;
        $tarefas = Tarefa::where("cliente_id",$id_cliente)->get();
        return view('admin.pages.tarefas.ajax.historico',[
            "tarefas" => $tarefas
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
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        Tarefa::create($data);
        return redirect()->route('clientes.agendarTarefa',[$request->cliente_id]);   
    }

    public function searchTarefas(Request $request)
    {
        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;
        $tarefas = Tarefa::where("user_id",auth()->user()->id)->whereRaw('data BETWEEN ? AND ?',[$data_inicial,$data_final])->with('cliente')->get();
        if(count($tarefas) >= 1) {
            return view('admin.pages.tarefas.ajax.listar-por-categoria',[
                "tarefas" => $tarefas,
                "titulo" => "datas"
            ]);
        } else {
            return "nada";
        } 
    }

    public function cadastrarTarefaAjax(Request $request)
    {
        
        $cliente = Cliente::where("id",$request->cliente_id)->first();
        $cliente->ultimo_contato = date("Y-m-d");
        $cliente->star = $request->star;
        $cliente->save();
        
        
        $tarefa_cliente = Tarefa::where("cliente_id",$request->cliente_id)->update(['status'=>1,'visivel'=>0]);

        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $data['visivel'] = 1;    
        


        $tarefa = Tarefa::create($data);
        $hoje = date("Y-m-d");
        $data_form = $request->data;
        $data_form_explode = explode("-",$data_form);
        $numeroSemanaDataHoje=intval( date('z', mktime(0,0,0,date("m"),date('d'),date("Y")) ) / 7 ) + 1;
        $numeroSemanaDataForm=intval( date('z', mktime(0,0,0,$data_form_explode[1],$data_form_explode[2],$data_form_explode[0]) ) / 7 ) + 1;
        // $titulo = "";
        // if($data_form < $hoje) {
        //     $titulo = "atraso";
        // } elseif(date('m') == date("m",strtotime($data_form)) && date("d") !=  date("d",strtotime($data_form)) && $numeroSemanaDataHoje != $numeroSemanaDataForm) {
        //     $titulo = "mes";
        // } elseif(date("d") ==  date("d",strtotime($data_form)) && $numeroSemanaDataHoje == $numeroSemanaDataForm) {
        //     $titulo = "hoje";
        // } elseif(date("d") !=  date("d",strtotime($data_form)) && $numeroSemanaDataHoje == $numeroSemanaDataForm) {
        //     $titulo = "semana";
        // } else {
        //     $titulo = "personalizado";
        // }
        // $tarefas = null;
        // switch($titulo) {
        //     case "atraso":
        //         $tarefas = Tarefa::where("user_id",auth()->user()->id)->whereRaw("data < now()")->with('cliente')->get();
        //     break;
        //     case "hoje":
        //         $tarefas = Tarefa::where("user_id",auth()->user()->id)->whereDate('data',"=",date('Y-m-d'))->with('cliente')->get();
        //     break;
        //     case "semana":
        //         $tarefas = Tarefa::where("user_id",auth()->user()->id)->whereRaw("YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1)")->with('cliente')->get();
        //     break;    
        //     case "mes":
        //         $tarefas = Tarefa::where("user_id",auth()->user()->id)->whereRaw("MONTH(data) = MONTH(NOW())")->get();
        //     break;
        // }

        // if($tarefas != null  && count($tarefas) >= 1) {
        //     return view('admin.pages.tarefas.ajax.listar-por-categoria',[
        //         "tarefas" => $tarefas,
        //         "titulo" => $titulo,
        //         "tarefa" => $tarefa->id
        //     ]);
        // } else {
        //     return $tarefas;
        // }

        return $request->cliente_id;
    }

    public function cadastrarTarefaAjaxCliente(Request $request)
    {
        $cliente = Cliente::where("id",$request->cliente_id)->first();
        $cliente->ultimo_contato = date("Y-m-d");
        $cliente->save();

        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $tarefa = Tarefa::create($data);
        
        $hoje = date("Y-m-d");
        $data_form = $request->data;
        $data_form_explode = explode("-",$data_form);
        $numeroSemanaDataHoje=intval( date('z', mktime(0,0,0,date("m"),date('d'),date("Y")) ) / 7 ) + 1;
        $numeroSemanaDataForm=intval( date('z', mktime(0,0,0,$data_form_explode[1],$data_form_explode[2],$data_form_explode[0]) ) / 7 ) + 1;
        $titulo = "";
        if($data_form < $hoje) {
            $titulo = "atraso";
        } elseif(date('m') == date("m",strtotime($data_form)) && date("d") !=  date("d",strtotime($data_form)) && $numeroSemanaDataHoje != $numeroSemanaDataForm) {
            $titulo = "mes";
        } elseif(date("d") ==  date("d",strtotime($data_form)) && $numeroSemanaDataHoje == $numeroSemanaDataForm) {
            $titulo = "hoje";
        } elseif(date("d") !=  date("d",strtotime($data_form)) && $numeroSemanaDataHoje == $numeroSemanaDataForm) {
            $titulo = "semana";
        } else {
            $titulo = "personalizado";
        }

        switch($titulo) {
            case "atraso":
                $tarefas = Tarefa::where("user_id",auth()->user()->id)->whereRaw("data < now()")->with('cliente')->get();
            break;
            case "hoje":
                $tarefas = Tarefa::where("user_id",auth()->user()->id)->whereDate('data',"=",date('Y-m-d'))->with('cliente')->get();
            break;
            case "semana":
                $tarefas = Tarefa::where("user_id",auth()->user()->id)->whereRaw("YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1)")->with('cliente')->get();
            break;    
            case "mes":
                $tarefas = Tarefa::where("user_id",auth()->user()->id)->whereRaw("MONTH(data) = MONTH(NOW())")->get();
            break;
        }

        if(count($tarefas) >= 1) {
            return view('admin.pages.tarefas.ajax.listar-por-categoria',[
                "tarefas" => $tarefas,
                "titulo" => $titulo,
                "tarefa" => $tarefa->id
            ]);
        } else {
            return $tarefas;
        }
    }

    






    public function clienteTarefaEspecifica(Request $request)
    {
        $tarefas = DB::table("tarefas")->selectRaw("title")->selectRaw("id")->selectRaw("descricao")->selectRaw("DATE_FORMAT(DATA, '%Y-%m-%d') as start")->whereRaw("tarefas.cliente_id = ".$request->id)->get();
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

    public function tarefasProximo03Dias()
    {
        return view('admin.pages.tarefas.proximas');
    }

    public function getTarefasProximo03Dias(Request $request)
    {
        if($request->ajax()) {
            $user = User::where("id",auth()->user()->id)->first();
            if($user->hasPermission('configuracoes') || $user->isAdmin()) {
                $tarefasProximas = Tarefa::where("status",0)
                ->whereDate('data','>',date('Y-m-d'))
                ->whereDate('data',"<=",date("Y-m-d",strtotime(now()."+3day")))
                ->selectRaw('(SELECT nome FROM clientes WHERE clientes.id = tarefas.cliente_id) as cliente')
                ->selectRaw('(SELECT name FROM users WHERE users.id = tarefas.user_id) as corretor')
                ->selectRaw('title,descricao')
                ->selectRaw('DATE_FORMAT(data,"%d/%m/%Y") as criacao')
                ->get();
                return $tarefasProximas;    
            } else {
                $tarefasProximas = Tarefa::where("user_id",auth()->user()->id)
                ->where("status",0)
                ->whereDate('data','>',date('Y-m-d'))
                ->whereDate('data',"<=",date("Y-m-d",strtotime(now()."+3day")))
                ->selectRaw('(SELECT nome FROM clientes WHERE clientes.id = tarefas.cliente_id) as cliente')
                ->selectRaw('title,descricao')
                ->selectRaw('DATE_FORMAT(data,"%d/%m/%Y") as criacao')
                ->get();
                return $tarefasProximas;    
            }           
        }
    }

    public function tarefasParaHoje(Request $request)
    {
        return view('admin.pages.tarefas.ajax.hoje');
    }
    
    

    public function clienteTarefasAtrasadasHome()
    {
        $dados = Tarefa::where("status",0)->where("user_id",auth()->user()->id)->whereRaw("data < now()")->with('cliente')->get();
        return view('admin.pages.tarefas.atrasadas',[
            "tarefas" => $dados
        ]);       
    }

    public function clienteSemTarefaAjax()
    {
        return view("admin.pages.tarefas.ajax.cliente-sem-tarefa");
    }

    public function getClienteSemTarefaAjax(Request $request) 
    {
        if($request->ajax()) {
            $user = User::where("id",auth()->user()->id)->first();
            if($user->hasPermission('configuracoes') || $user->isAdmin()) {        
                $dados = Cliente::selectRaw("nome,telefone")
                ->selectRaw("(SELECT nome from etiquetas WHERE etiquetas.id = clientes.etiqueta_id) as etiqueta")
                ->selectRaw("(SELECT name from users WHERE users.id = clientes.user_id) as corretor")
                ->selectRaw("id")
                ->get();
                return $dados;
            } else {
                $dados = Cliente::where("user_id",auth()->user()->id)->whereNotIn('id',function($query){
                    $query->select('tarefas.cliente_id');
                    $query->from('tarefas');
                    $query->whereRaw("user_id=".auth()->user()->id);
                })
                ->selectRaw("nome,telefone")
                ->selectRaw("(SELECT cor from etiquetas WHERE etiquetas.id = clientes.etiqueta_id) as etiqueta")
                ->selectRaw("id")
                ->get();
                return $dados;
            }
        }
    }

    public function clienteTarefasAtrasadasAjax()
    {
        return view("admin.pages.tarefas.ajax.cliente-tarefas-atrasadas");
    }

    



    public function mudarStatusTarefaAjax(Request $request)
    {
        $id = $request->id;
        $tarefa = Tarefa::where("id",$id)->first();
        if($tarefa) {
            $tarefa->status = 1;
            $tarefa->save();
        }
        $qtd = Tarefa::where("status",0)->where("user_id",auth()->user()->id)->whereRaw("data < now()")->count();
        if($qtd == 0) {
            return view("admin.pages.tarefas.ajax.cliente-tarefas-atrasadas",[
                "clientes" => []
            ]); 
        }
    }

    public function tarefasRealizadasAjax()
    {
        return view("admin.pages.tarefas.ajax.tarefas-realizadas");
    }

    public function getTarefasRealizadasAjax(Request $request) 
    {
        if($request->ajax()) {
            $user = User::where("id",auth()->user()->id)->first();
            if($user->hasPermission('configuracoes') || $user->isAdmin()) {
                $tarefas = Tarefa::where("status",1)
                ->selectRaw("title")
                ->selectRaw("DATE_FORMAT(data,'%d/%m/%Y') as data")
                ->selectRaw("DATE_FORMAT(updated_at,'%d/%m/%Y') as realizada")
                ->selectRaw("(SELECT nome FROM clientes WHERE clientes.id = tarefas.cliente_id) as cliente")
                ->selectRaw("(SELECT name FROM users WHERE users.id = tarefas.user_id) as corretor")
                ->get();
                return $tarefas;                    
            } else {
                $tarefas = Tarefa::where("user_id",auth()->user()->id)
                ->where("status",1)
                ->selectRaw("title")
                ->selectRaw("DATE_FORMAT(data,'%d/%m/%Y') as data")
                ->selectRaw("DATE_FORMAT(updated_at,'%d/%m/%Y') as realizada")
                ->selectRaw("(SELECT nome FROM clientes WHERE clientes.id = tarefas.cliente_id) as cliente")
                ->get();
                return $tarefas;
            }    
        }    
    }




    public function listarTodasAsTarefasAjax()
    {
        return view('admin.pages.tarefas.ajax.todas-as-tarefas');
    }

    public function getListarTodasAsTarefasAjax(Request $request)
    {
        if($request->ajax()) {
            $user = User::where("id",auth()->user()->id)->first();
            if($user->hasPermission('configuracoes') || $user->isAdmin()) {
                $tarefas = Tarefa::selectRaw("title,id")
                ->selectRaw("status")
                ->selectRaw("DATE_FORMAT(data,'%d/%m/%Y') as criacao")
                ->selectRaw("(SELECT nome FROM clientes WHERE clientes.id = tarefas.cliente_id) as cliente")
                ->selectRaw("(SELECT name FROM users WHERE users.id = tarefas.user_id) as corretor")
                ->get();
                return $tarefas;
            } else {
                $tarefas = Tarefa::where("user_id",auth()->user()->id)
                ->selectRaw("title,id")
                ->selectRaw("status")
                ->selectRaw("DATE_FORMAT(data,'%d/%m/%Y') as criacao")
                ->selectRaw("(SELECT nome FROM clientes WHERE clientes.id = tarefas.cliente_id) as cliente")
                ->get();
                return $tarefas;
            }  
        }
    }    

    public function marcarTarefasRealizarAjax(Request $request)
    {
        if($request->ajax()) {
            $tarefa = Tarefa::where("user_id",auth()->user()->id)->where("id",$request->id)->first();
            $tarefa->status = $tarefa->status == 1 ? 0 : 1;
            $tarefa->save();
        }
    }

}