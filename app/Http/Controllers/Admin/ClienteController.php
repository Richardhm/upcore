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

    public function listarPessoaFisica()
    {
    
        $qtd_atrasada = Cliente::
            where("user_id",auth()->user()->id)
            ->where('pessoa_fisica',1)
            ->where('lead',0)
            ->where("etiqueta_id","!=",3)
            ->where("visivel",1)
            ->whereHas('tarefas',function($query){
                $query->where('status',0);
                $query->whereDate('data','<',date('Y-m-d'));
        })->count();
              
        
        $qtd_hoje = Cliente
            ::where("user_id",auth()->user()->id)
            ->where('pessoa_fisica',1)
            ->where('lead',0)
            ->where("etiqueta_id","!=",3)
            ->where('visivel',1)
            ->whereHas('tarefas',function($query){
                $query->where('status',0);
                $query->whereDate('data',"=",date('Y-m-d'));
            })->count();
        
        $qtd_semana = Cliente
            ::where("user_id",auth()->user()->id)
            ->where('pessoa_fisica',1)
            ->where('lead',0)
            ->where("etiqueta_id","!=",3)
            ->where('visivel',1)
            ->whereHas('tarefas',function($query){
                $query->where('status',0);
                $query->whereRaw("YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND data > now()");
            })->count();
        
        $qtd_mes = Cliente::
            where("user_id",auth()->user()->id)
            ->where('pessoa_fisica',1)
            ->where('lead',0)
            ->where('visivel',1)
            ->where('etiqueta_id',"!=",3)
            ->whereHas('tarefas',function($query){
                $query->where('status',0);
                $query->whereRaw("MONTH(data) = MONTH(NOW())");
            })
        ->count();
        
        

        $titulos = TarefasTitulo::where("id","!=",1)->get();

        $clientes_total = Cliente::where("user_id",auth()->user()->id)->where('pessoa_fisica',1)->where("etiqueta_id","!=",3)->where('visivel',1)->where('lead',0)->count();
        $negociacao = Cliente::where("user_id",auth()->user()->id)
            ->where('pessoa_fisica',1)
            ->where('lead',0)
            ->where("etiqueta_id",3)
            ->whereHas("cotacao",function($query){
                $query->where("financeiro_id","!=",6);
            })            
            ->count();
        //$finalizados = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id",6)->toSql();
        $finalizados = Cliente::where("user_id",auth()->user()->id)->where('pessoa_fisica',1)->where('lead',0)->where("etiqueta_id",3)
            ->whereHas('cotacao',function($query){
                $query->where('financeiro_id',6);
            })->count();
                
        
        $cadastrado_mes = Cliente::where("user_id",auth()->user()->id)->where('pessoa_fisica',1)->where('lead',0)->whereRaw("MONTH(created_at) = MONTH(NOW())")->count();

        $perdidos = Cliente::where("user_id",auth()->user()->id)->where("visivel",0)->where('pessoa_fisica',1)->where('lead',0)->whereRaw("MONTH(created_at) = MONTH(NOW())")->whereHas('tarefas',function($query){
            $query->whereRaw("motivo_id IS NOT NULL");
        })->count();
        
        $perdidos_mes = Cliente::where("user_id",auth()->user()->id)->where("visivel",0)->where('pessoa_fisica',1)->where('lead',0)->whereRaw("MONTH(created_at) = MONTH(NOW())")->whereHas('tarefas',function($query){
            $query->whereRaw("motivo_id IS NOT NULL");
        })->count();

        
        $finalizados_mes = Cliente::where("user_id",auth()->user()->id)->where('pessoa_fisica',1)->where('lead',0)->where("etiqueta_id",3)
            ->whereHas('cotacao',function($query){
                $query->where('financeiro_id',6);
                $query->whereRaw("MONTH(updated_at) = MONTH(NOW())");
            })->count();

        $negociacao_mes = Cliente::where("user_id",auth()->user()->id)
            ->where('pessoa_fisica',1)
            ->where('lead',0)
            ->where("etiqueta_id",3)
            ->whereHas("cotacao",function($query){
                $query->where("financeiro_id","!=",6);
                $query->whereRaw("MONTH(created_at) = MONTH(NOW())");
            })->count();            
          


        $motivos = TarefaMotivoPerda::all();

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
            'negociacao_mes' => $negociacao_mes,
            'titulos' => $titulos,
            'motivos' => $motivos,
            'perdidos' => $perdidos,
            'perdidos_mes' => $perdidos_mes
        ]);
    }

    public function listarPessoaJuridica()
    {
        $qtd_atrasada = Cliente::
            where("user_id",auth()->user()->id)
            ->where('pessoa_juridica',1)
            ->where('lead',0)
            ->where("etiqueta_id","!=",3)
            ->where("visivel",1)
            ->whereHas('tarefas',function($query){
                $query->where('status',0);
                $query->whereDate('data','<',date('Y-m-d'));
            })->count(); 

        $qtd_hoje = Cliente
            ::where("user_id",auth()->user()->id)
            ->where('pessoa_juridica',1)
            ->where('lead',0)
            ->where("etiqueta_id","!=",3)
            ->where('visivel',1)
            ->whereHas('tarefas',function($query){
                $query->where('status',0);
                $query->whereDate('data',"=",date('Y-m-d'));
            })->count();

        $qtd_semana = Cliente
            ::where("user_id",auth()->user()->id)
            ->where('pessoa_juridica',1)
            ->where('lead',0)
            ->where("etiqueta_id","!=",3)
            ->where('visivel',1)
            ->whereHas('tarefas',function($query){
                $query->where('status',0);
                $query->whereRaw("YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND data > now()");
            })->count();    

        $qtd_mes = Cliente
            ::where("user_id",auth()->user()->id)
            ->where('pessoa_juridica',1)
            ->where('lead',0)
            ->where("etiqueta_id","!=",3)
            ->where('visivel',1)
            ->whereHas('tarefas',function($query){
                $query->where('status',0);
                $query->whereRaw("MONTH(data) = MONTH(NOW())");
            })->count();
        

        $titulos = TarefasTitulo::where("id","!=",1)->get();

        $clientes_total = Cliente::where("user_id",auth()->user()->id)->where('pessoa_juridica',1)->where("etiqueta_id","!=",3)->where('visivel',1)->where('lead',0)->count();
        $negociacao = Cliente::where("user_id",auth()->user()->id)
            ->where('pessoa_juridica',1)
            ->where('lead',0)
            ->where("etiqueta_id",3)
            ->whereHas("cotacao",function($query){
                $query->where("financeiro_id","!=",6);
            })            
            ->count();
        //$finalizados = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id",6)->toSql();
        $finalizados = Cliente::where("user_id",auth()->user()->id)->where('pessoa_juridica',1)->where('lead',0)->where("etiqueta_id",3)
            ->whereHas('cotacao',function($query){
                $query->where('financeiro_id',6);
            })->count();
                
        
        $cadastrado_mes = Cliente::where("user_id",auth()->user()->id)->where('pessoa_juridica',1)->where('lead',0)->whereRaw("MONTH(created_at) = MONTH(NOW())")->count();

        $perdidos = Cliente::where("user_id",auth()->user()->id)->where("visivel",0)->where('pessoa_juridica',1)->where('lead',0)->whereRaw("MONTH(created_at) = MONTH(NOW())")->whereHas('tarefas',function($query){
            $query->whereRaw("motivo_id IS NOT NULL");
        })->count();
        
        $perdidos_mes = Cliente::where("user_id",auth()->user()->id)->where("visivel",0)->where('pessoa_juridica',1)->where('lead',0)->whereRaw("MONTH(created_at) = MONTH(NOW())")->whereHas('tarefas',function($query){
            $query->whereRaw("motivo_id IS NOT NULL");
        })->count();

        
        $finalizados_mes = Cliente::where("user_id",auth()->user()->id)->where('pessoa_juridica',1)->where('lead',0)->where("etiqueta_id",3)
            ->whereHas('cotacao',function($query){
                $query->where('financeiro_id',7);
                $query->whereRaw("MONTH(updated_at) = MONTH(NOW())");
            })->count();

        $negociacao_mes = Cliente::where("user_id",auth()->user()->id)
            ->where('pessoa_juridica',1)
            ->where('lead',0)
            ->where("etiqueta_id",3)
            ->whereHas("cotacao",function($query){
                $query->where("financeiro_id","!=",6);
                $query->whereRaw("MONTH(created_at) = MONTH(NOW())");
            })->count();            

        $motivos = TarefaMotivoPerda::all();

        return view('admin.pages.tarefas.juridico',[
            'qtd_atrasada' => $qtd_atrasada,
            'qtd_hoje' => $qtd_hoje,
            'qtd_semana' => $qtd_semana,
            'qtd_mes' => $qtd_mes,
            'clientes_total' => $clientes_total,
            'negociacao' => $negociacao,
            'finalizados' => $finalizados,
            'cadastrado_mes' => $cadastrado_mes,
            'finalizados_mes' => $finalizados_mes,
            'titulos' => $titulos,
            'motivos' => $motivos,
            'perdidos' => $perdidos,
            'perdidos_mes' => $perdidos_mes,
            'negociacao_mes' => $negociacao_mes
        ]);
    }

    public function listarClientesAjaxPJ(Request $request)
    {
        $id_user = auth()->user()->id;
        $visivel = 1;

        $clientes = Cliente::where("user_id",$id_user)->where('pessoa_juridica',1)->where('lead',0)
        
        ->whereHas('tarefas',function($query) use($visivel){
            $query->where('visivel',$visivel);
        })
       
        ->with('tarefas',function($query) use($visivel){
            $query->where('visivel',$visivel)->with('titulo');
        })
        
        ->with(['cidade','etiqueta','cotacao.somarCotacaoFaixaEtaria'])
        ->get();
        //->with(['tarefas.titulo','cidade','etiqueta','cotacao.somarCotacaoFaixaEtaria'])->get();
        //dd($clientes);
        return $clientes;
    }



    public function listarClientesAjaxPF(Request $request)
    {
        $id_user = auth()->user()->id;
        $visivel = 1;

        $clientes = Cliente::where("user_id",$id_user)->where('pessoa_fisica',1)->where('lead',0)->where("etiqueta_id","!=",3)->where("visivel",$visivel)

        ->whereHas('tarefas',function($query) use($visivel){
            $query->where("visivel",$visivel);
        })
        ->with('tarefas',function($query) use($visivel){
            $query->where("visivel",$visivel)->with('titulo');
        })


        ->with(['cidade','origem','etiqueta','cotacao.somarCotacaoFaixaEtaria'])
        ->get();

        

        //->with(['tarefas.titulo','cidade','etiqueta','cotacao.somarCotacaoFaixaEtaria'])->get();
        //dd($clientes);
        return $clientes;
    }



    public function prospeccao()
    {
        $cidades = Cidade::all();
        $origens = Origem::all();
        //$qtdAtrasado = Cliente::where("lead",1)->where("visivel",1)->whereDate("created_at","<",date('Y-m-d'))->count();
        //$qtdHoje = Cliente::where("lead",1)->where("visivel",1)->whereDate('created_at',"=",date('Y-m-d'))->count();
        //$qtdSemana = Cliente::where("lead",1)->where("visivel",1)->whereRaw("YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1) AND created_at > now()")->count();
        //$qtdMes = Cliente::where("lead",1)->where("visivel",1)->whereRaw("MONTH(created_at) = MONTH(NOW())")->count();
        $qtdTotal = Cliente::where("lead",1)->where("visivel",1)->count();
        
        $qtdAtrasado = Cliente::
            where("user_id",auth()->user()->id)
            ->where('lead',1)
            ->where("etiqueta_id","!=",3)
            ->where("visivel",1)
            ->whereDate('created_at','<',date('Y-m-d'))
            ->count();

          
        
        $qtdHoje = Cliente::
            where("user_id",auth()->user()->id)
            ->where('lead',1)
            ->where("etiqueta_id","!=",3)
            ->where("visivel",1)
            ->whereDate('created_at','=',date('Y-m-d'))
            ->count();    

        $qtdSemana = Cliente::
            where("user_id",auth()->user()->id)
            ->where('lead',1)
            ->where("etiqueta_id","!=",3)
            ->where("visivel",1)
            ->whereRaw("YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1) AND created_at > now()")
            ->count();        

        $qtdMes = Cliente::
            where("user_id",auth()->user()->id)
            ->where('lead',1)
            ->where("etiqueta_id","!=",3)
            ->where("visivel",1)
            ->whereRaw("MONTH(created_at) = MONTH(NOW())")
            ->count();        



        return view('admin.pages.clientes.prospeccao',[
            "cidades" => $cidades,
            "origem" => $origens,
            "qtdAtrasado" => $qtdAtrasado,
            "qtdHoje" => $qtdHoje,
            "qtdSemana" => $qtdSemana,
            "qtdMes" => $qtdMes,
            "qtdTotal" => $qtdTotal
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
        $cliente->ultimo_contato = date("Y-m-d");
        $cliente->email = $request->email;
        if($cliente->save()) {
            return $request->nome;
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
        $cliente->telefone = $request->telefone;
        $cliente->telefone_empresa = (!empty($request->telefone_empresa) ? $request->telefone_empresa : null);
        $cliente->pessoa_fisica = 0;
        $cliente->pessoa_juridica = 1;
        $cliente->ultimo_contato = date("Y-m-d");
        $cliente->email = $request->email;
        if($cliente->save()) {
            return $request->nome;
        } else {
            return "error";
        }
    }

    public function pegarPlanosPorAdministradora(Request $request)
    {
        $administradora = Administradora::where("id",$request->administradora)->with("planos")->first();
        return $administradora;
        
    }

    public function prospeccaoLeitura()
    {
        $clientes = Cliente::where("user_id",auth()->user()->id)->where("lead",1)->with('origem')->get();
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
            ->where("etiqueta_id","!=",3)
            
            ->whereHas('tarefas',function($query){
                $query->where("status",0);
                $query->whereDate('data','=',date('Y-m-d'));
            })
            ->with('tarefas',function($query){
                $query->where("status",0);
                $query->whereDate('data','=',date('Y-m-d'))->with('titulo');
            })
        ->with(['cidade','etiqueta','cotacao.somarCotacaoFaixaEtaria'])->get();
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
            ->where("etiqueta_id","!=",3)
            
            ->whereHas('tarefas',function($query){
                $query->where("status",0);
                $query->whereDate('data','=',date('Y-m-d'));
            })
            ->with('tarefas',function($query){
                $query->where("status",0);
                $query->whereDate('data','=',date('Y-m-d'))->with('titulo');
            })
        ->with(['cidade','etiqueta','cotacao.somarCotacaoFaixaEtaria'])->get();
        return $clientes;                
    } 




    public function getClientesParaHojeProspeccao(Request $request)
    {
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("lead",1)
            ->where("visivel",1)
            
            ->where("etiqueta_id","!=",3)
            ->whereDate('created_at',"=",date('Y-m-d'))
        ->with('origem')->get();
        return $clientes;                
    } 



    
    public function getClienteAtrasadasAjax(Request $request)
    {
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("lead",0)
            ->where('pessoa_fisica',1)
            ->where('visivel',1)
            ->where("etiqueta_id","!=",3)
            ->whereHas('tarefas',function($query){
                $query->where("status",0);
                $query->whereDate("data","<",date('Y-m-d'));
            })
            ->with('tarefas',function($query){
                $query->where("status",0);
                $query->whereDate("data","<",date('Y-m-d'))->with('titulo');
            })


        ->with(['cidade','etiqueta','cotacao.somarCotacaoFaixaEtaria','origem'])->get();
        return $clientes;                
    }

    public function getClienteAtrasadasAjaxPJ(Request $request)
    {
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("lead",0)
            ->where('pessoa_juridica',1)
            ->where('visivel',1)
            ->where("etiqueta_id","!=",3)
            ->whereHas('tarefas',function($query){
                $query->where("status",0);
                $query->whereDate("data","<",date('Y-m-d'));
            })
            ->with('tarefas',function($query){
                $query->where("status",0);
                $query->whereDate("data","<",date('Y-m-d'))->with('titulo');
            })


        ->with(['cidade','etiqueta','cotacao.somarCotacaoFaixaEtaria','origem'])->get();
        return $clientes;                
    }



    public function getClienteAtrasadasAjaxProspeccao(Request $request)
    {
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("lead",1)
            
            ->where('visivel',1)
            ->where("etiqueta_id","!=",3)
            ->whereDate("created_at","<",date('Y-m-d'))
        ->with('origem')->get();
        return $clientes;            
    }

    public function listarClientesSemanaAjax(Request $request)
    {
        $visivel = 1;
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("pessoa_fisica",1)
            ->where("etiqueta_id","!=",3)
            ->where("lead",0)
            ->where('visivel',1)
           
            ->whereHas('tarefas',function($query) use($visivel){
                $query->where("status",0);
                $query->whereRaw("YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND data > now()");
            })
            ->with('tarefas',function($query) use($visivel){
                $query->where("status",0);
                $query->whereRaw("YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND data > now()")->with('titulo');
            })
            ->with(['cidade','etiqueta','cotacao.somarCotacaoFaixaEtaria','origem'])->get();
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
           
            ->whereHas('tarefas',function($query) use($visivel){
                $query->where("status",0);
                $query->whereRaw("YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND data > now()");
            })
            ->with('tarefas',function($query) use($visivel){
                $query->where("status",0);
                $query->whereRaw("YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND data > now()")->with('titulo');
            })
            ->with(['cidade','etiqueta','cotacao.somarCotacaoFaixaEtaria','origem'])->get();
        return $clientes;      
    }




    public function listarClientesSemanaAjaxProspeccao(Request $request)
    {
        $clientes = Cliente::
        where("user_id",auth()->user()->id)
        
        ->where("etiqueta_id","!=",3)
        ->where("lead",1)
        ->where('visivel',1)
        ->whereRaw("YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1) AND created_at > now()")
        ->with('origem')->get();
        return $clientes;      
    }

    public function listarClienteMesAjax(Request $request)
    {
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("pessoa_fisica",1)
            ->where("etiqueta_id","!=",3)
            ->where("lead",0)
            ->where('visivel',1)
            ->whereHas('tarefas',function($query){
                $query->where("status",0);
                $query->whereRaw("MONTH(created_at) = MONTH(NOW())");
            })
            ->with('tarefas',function($query){
                $query->where("status",0);
                $query->whereRaw("MONTH(created_at) = MONTH(NOW())")->with('titulo');
            })
            
            ->with(['cidade','etiqueta','origem'])->get();
        return $clientes; 
    }

    public function listarClienteMesAjaxPJ(Request $request)
    {
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            ->where("pessoa_juridica",1)
            ->where("etiqueta_id","!=",3)
            ->where("lead",0)
            ->where('visivel',1)
            ->whereHas('tarefas',function($query){
                $query->where("status",0);
                $query->whereRaw("MONTH(created_at) = MONTH(NOW())");
            })
            ->with('tarefas',function($query){
                $query->where("status",0);
                $query->whereRaw("MONTH(created_at) = MONTH(NOW())")->with('titulo');
            })
            
            ->with(['cidade','etiqueta','origem'])->get();
        return $clientes; 
    }

    public function listarClienteMesAjaxProspeccao(Request $request)
    {
        $clientes = Cliente::
            where("user_id",auth()->user()->id)
            
            ->where("etiqueta_id","!=",3)
            ->where("lead",1)
            ->where('visivel',1)
            ->whereRaw("MONTH(created_at) = MONTH(NOW())")
            ->with('origem')->get();
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
        return view("admin.pages.contrato.pessoa_fisica.pendentes");
    }

    public function listarContratosPFPendentes()
    {
        $fisica = 1;
        $contratos = Cotacao::where("user_id",auth()->user()->id)
            ->where("financeiro_id","!=",7)
            ->whereHas('clientes',function($query) use($fisica){
                $query->where('pessoa_fisica',$fisica);
            })
            ->with('clientes',function($query) use($fisica){
                $query->where('pessoa_fisica',$fisica);
            })
            ->with(['administradora','financeiro','cidade','acomodacao'])
            ->get();
        return $contratos;       
    }

    public function listarContratosPJ(Request $request)
    {
        return view("admin.pages.contrato.pessoa_juridica.pendentes");
    }

    public function listarContratosPJPendentes()
    {
        $juridica = 1;
        $contratos = Cotacao::where("user_id",auth()->user()->id)
            ->where("financeiro_id","!=",6)
            ->whereHas('clientes',function($query) use($juridica){
                $query->where('pessoa_juridica',$juridica);
            })
            ->with('clientes',function($query) use($juridica){
                $query->where('pessoa_juridica',$juridica);
            })
            ->with(['administradora','financeiro','cidade','acomodacao'])
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
