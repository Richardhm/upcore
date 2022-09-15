<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Acomodacao,
    Administradora,
    User,
    Cliente,
    ComissoesCorretoraLancadas,
    ComissoesCorretorLancados,
    Cotacao,
    CotacaoFaixaEtaria,
    CotacaoJuridica,
    Etiquetas,
    Operadora,
    Planos,
    PremiacaoCorretoraLancadas,
    PremiacaoCorretoresLancados,
    Tarefa
};

use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find(auth()->user()->id);       
        if($user->admin) {
            return $this->administrador();    
        } elseif($user->hasPermission('comissoes')) {
           return $this->financeiro();
        } else {
            return $this->corretor();            
        }
    }

    public function administrador()
    {
            $tarefasHoje = Tarefa::where("status",0)
                ->whereDate('data',date('Y-m-d'))
                ->count();
            $tarefasAtrasadas = Tarefa::where("status",0)
                ->whereDate('data','<',date('Y-m-d'))
                ->count();           
            $tarefasProximas = Tarefa::where("status",0)
                ->whereDate('data','>',date('Y-m-d'))
                ->whereDate('data',"<=",date("Y-m-d",strtotime(now()."+3day")))
                ->count();
            $clientesSemTarefas = Cliente::whereNotIn('id',function($query){
                $query->select('tarefas.cliente_id');
                $query->from('tarefas');                
            })->count();
            $etiquetas = Etiquetas::selectRaw('nome')->selectRaw('(SELECT count(id) FROM clientes WHERE clientes.etiqueta_id = etiquetas.id) AS quantidade')->get();
            $aguardando_boleto_coletivo = Cotacao::where("financeiro_id",1)->where('plano_id',"!=",1)->count();
            $aguardando_boleto_coletivo_total = Cotacao::where("financeiro_id",1)->where('plano_id',"!=",1)->selectRaw("sum(valor) as total")->first()->total;
            $aguardando_boleto_coletivo_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("financeiro_id",1);
                $query->where("plano_id","!=",1);
            })->selectRaw("sum(quantidade) as total")->first()->total;
            $aguardando_pagamento_adesao_coletivo = Cotacao::where("financeiro_id",2)->where('plano_id',"!=",1)->count();
            $aguardando_pagamento_boleto_coletivo_total = Cotacao::where("financeiro_id",2)->where('plano_id',"!=",1)->selectRaw("sum(valor) as total")->first()->total;
            $aguardando_pagamento_boleto_coletivo_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("financeiro_id",2);
                $query->where("plano_id","!=",1);
            })->selectRaw("sum(quantidade) as total")->first()->total;
            $aguardando_pagamento_vigencia = Cotacao::where("financeiro_id",4)->where('plano_id',"!=",1)->count();
            $aguardando_pagamento_vigencia_total = Cotacao::where("financeiro_id",4)->where('plano_id',"!=",1)->selectRaw("sum(valor) as total")->first()->total;
            $aguardando_pagamento_vigencia_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("financeiro_id",4);
                $query->where("plano_id","!=",1);
            })->selectRaw("sum(quantidade) as total")->first()->total;
            $aguardando_individual_qtd = Cotacao::where("financeiro_id",1)->where("plano_id",1)->count();
            $aguardando_individual_total = Cotacao::where("financeiro_id",1)->where("plano_id",1)->selectRaw("sum(valor) as total")->first()->total;
            $aguardando_individual_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("financeiro_id",1);
                $query->where("plano_id",1);
            })->selectRaw("sum(quantidade) as total")->first()->total;
            $totalCliente    = Cliente::count();
            $totalVidasQuantidade = CotacaoFaixaEtaria::whereIn("cotacao_id",function($query){
                $query->select('cotacoes.id');
                $query->from('cotacoes');
            })->selectRaw("sum(quantidade) as quantidade_total_vidas")->first()->quantidade_total_vidas;
            $totalClientesNegociados = Cotacao::where("financeiro_id",6)->whereHas('clientes',function($query){
                $query->where('etiqueta_id','=',3);
            })->count();
            $totalVidasClientesNegociados = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("financeiro_id",6);    
            })->selectRaw("SUM(quantidade) AS total_quantidade")->first()->total_quantidade;

            $totalClientesNegociacao = Cotacao::where("financeiro_id","!=",6)->count();
            $vidasTotalClientesNegociacao = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("financeiro_id","!=",6);
            })->selectRaw("sum(quantidade) as total")->first()->total;
            $clientesCadastradosEsseMes = DB::table('clientes')->whereRaw("MONTH(NOW()) = MONTH(created_at) AND YEAR(now()) = YEAR(created_at)")->count();
            $clientesCadastradosEsseMesVidas = CotacaoFaixaEtaria::whereHas('cotacao.clientes',function($query){
                $query->whereMonth('created_at',date('m'));
                $query->whereYear('created_at',date('Y'));
            })->selectRaw("sum(quantidade) as total")->first()->total;
            /***********************Mes Atual**********************************************************************/
            $totalVendido = Cotacao::where("financeiro_id",6)->whereHas('comissao.comissaoCorretoraLancadas',function($query){
                $query->where("status",1);
                $query->whereRaw("MONTH(data) = MONTH(NOW())");
            })->selectRaw("sum(valor) as total")->first()->total;            
                        
            $totalVidasVendidas = CotacaoFaixaEtaria::whereHas('cotacao.comissao.comissaoCorretoraLancadas',function($query){
                $query->where("status",1);
                $query->whereRaw("MONTH(data) = MONTH(now())");
            })->selectRaw("sum(quantidade) as total")->first()->total;   

            

            $totalVidasVendidasIndividual = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("plano_id",1);
                $query->whereHas("comissao.comissaoCorretoraLancadas",function($query){
                    $query->where("status",1);
                    $query->whereRaw("MONTH(data) = MONTH(now()) AND YEAR(data) = YEAR(now())");
                });
            })->selectRaw("sum(quantidade) as total")->first()->total;

            $totalVidasVendidasColetivo = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("plano_id",3);
                $query->whereHas("comissao.comissaoCorretoraLancadas",function($query){
                    $query->where("status",1);
                    $query->whereRaw("MONTH(data) = MONTH(now()) AND YEAR(data) = YEAR(now())");
                });
            })->selectRaw("sum(quantidade) as total")->first()->total;

            $totalVendidoCotacaoIndividual = Cotacao::where('plano_id',1)->where("financeiro_id",6)->whereHas('comissao.comissaoCorretoraLancadas',function($query){
                $query->where("status",1);
                $query->whereRaw("MONTH(data) = MONTH(NOW())");
            })->selectRaw("sum(valor) as total")->first()->total;

            $totalVendidoCotacaoColetivo = Cotacao::where('plano_id',3)->where("financeiro_id",6)->whereHas('comissao.comissaoCorretoraLancadas',function($query){
                $query->where("status",1);
                $query->whereRaw("MONTH(data) = MONTH(NOW()) AND YEAR(data) = YEAR(now())");
            })->selectRaw("sum(valor) as total")->first()->total;                      
            /************************Comissao do Mes***************************************** */     

            // $totalComissao = ComissoesCorretorLancados::where("status",1)->whereMonth("data",date('m'))->selectRaw("sum(valor) as total")->first()->total;
            $totalComissao = ComissoesCorretoraLancadas::where("status",1)->whereMonth("data",date('m'))->selectRaw("sum(valor) as total")->first()->total;
            $totalComissaoIndividual = ComissoesCorretoraLancadas::where("status",1)
                ->whereMonth("data",date('m'))
                ->whereHas('comissao.cotacao',function($query){
                    $query->where("plano_id",1);
            })->selectRaw("sum(valor) as total_individual")->first()->total_individual;
            $totalComissaoColetivo = ComissoesCorretoraLancadas::where("status",1)
                ->whereMonth("data",date('m'))
                ->whereHas('comissao.cotacao',function($query){
                    $query->where("plano_id",3);
            })->selectRaw("sum(valor) as total_coletivo")->first()->total_coletivo;
            /************************Fim Comissao do Mes***************************************** */
            /*********************PREMIAÇÔES DO MES*************************** */
            $totalPremiacao = PremiacaoCorretoraLancadas::where("status",1)
                ->whereMonth("data",date('m'))
                ->selectRaw("sum(total) as total")
                ->first()
                ->total;            
            $totalPremiacaoIndividual = PremiacaoCorretoraLancadas::where("status",1)
                ->whereMonth("data",date('m'))
                ->whereHas('comissao.cotacao',function($query){
                    $query->where("plano_id",1);
                })->selectRaw("sum(total) as total_individual")
            ->first()
            ->total_individual;
            $totalPremiacaoColetivo = PremiacaoCorretoraLancadas::where("status",1)
                ->whereMonth("data",date('m'))
                ->whereHas('comissao.cotacao',function($query){
                    $query->where("plano_id",3);
            })->selectRaw("sum(total) as total_coletivo")
            ->first()
            ->total_coletivo;
            /*********************FIM PREMIAÇÔES DO MES*************************** */
            /*****************************************************Fim Mes Atual**********************************************************************************/
            /*****************************************************Total Restante*********************************************************************************/
            $totalVendidoRestante = Cotacao::where("financeiro_id",6)->whereHas('comissao.comissaoCorretoraLancadas',function($query){
                $query->where("status",0);
                $query->whereRaw("MONTH(data) != MONTH(NOW())");
            })->selectRaw("sum(valor) as total")->first()->total;
            $totalVidasVendidasRestante = CotacaoFaixaEtaria::whereHas('cotacao.comissao.comissaoCorretoraLancadas',function($query){
                $query->where("status",0);
                $query->whereRaw("MONTH(data) != MONTH(now())");
            })->selectRaw("sum(quantidade) as total")->first()->total;
            $totalVendidoCotacaoIndividualRestante = Cotacao::where('plano_id',1)->where("financeiro_id",6)->whereHas('comissao.comissaoCorretoraLancadas',function($query){
                $query->where("status",0);
                $query->whereRaw("MONTH(data) != MONTH(NOW())");
            })->selectRaw("sum(valor) as total")->first()->total;
            $totalVidasVendidasIndividualRestante = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("plano_id",1);
                $query->whereHas("comissao.comissaoCorretoraLancadas",function($query){
                    $query->where("status",0);
                    $query->whereRaw("MONTH(data) != MONTH(now())");
                });
            })->selectRaw("sum(quantidade) as total")->first()->total;
            $totalVendidoCotacaoColetivoRestante = Cotacao::where('plano_id',3)->where("financeiro_id",6)->whereHas('comissao.comissaoCorretoraLancadas',function($query){
                $query->where("status",0);
                $query->whereRaw("MONTH(data) != MONTH(NOW())");
            })->selectRaw("sum(valor) as total")->first()->total;
            $totalVidasVendidasColetivoRestante = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("plano_id",3);
                $query->whereHas("comissao.comissaoCorretoraLancadas",function($query){
                    $query->where("status",0);
                    $query->whereRaw("MONTH(data) != MONTH(now())");
                });
            })->selectRaw("sum(quantidade) as total")->first()->total;
            /*****************************************************Fim Total Restante*********************************************************************************/
            /************************Comissao do Restante***********************************************/
            $totalComissaoRestante = ComissoesCorretoraLancadas::where("status",0)
                ->whereMonth("data","!=",date('m'))
                ->selectRaw("sum(valor) as total")
                ->first()
                ->total;
            $totalComissaoIndividualRestante = ComissoesCorretoraLancadas::where("status",0)
                ->whereMonth("data","!=",date('m'))
                ->whereHas('comissao.cotacao',function($query){
                    $query->where("plano_id",1);
            })
            ->selectRaw("sum(valor) as total_individual")
            ->first()
            ->total_individual;
            $totalComissaoColetivoRestante = ComissoesCorretoraLancadas::where("status",0)
                ->whereMonth("data","!=",date('m'))
                ->whereHas('comissao.cotacao',function($query){
                    $query->where("plano_id",3);
            })
            ->selectRaw("sum(valor) as total_coletivo")
            ->first()
            ->total_coletivo;
            /************************Fim Comissao Restante**********************************************/
            /*************************PREMIAÇÔES DO MES Restante****************************/
            $totalPremiacaoRestante = PremiacaoCorretoraLancadas::where("status",0)
            ->whereMonth("data","!=",date('m'))
            ->selectRaw("sum(total) as total")
            ->first()
            ->total;
            $totalPremiacaoIndividualRestante = PremiacaoCorretoraLancadas::where("status",0)
            ->whereMonth("data","!=",date('m'))
            ->whereHas('comissao.cotacao',function($query){
                $query->where("plano_id",0);
            })
            ->selectRaw("sum(total) as total_individual")
            ->first()
            ->total_individual;
            $totalPremiacaoColetivoRestante = PremiacaoCorretoraLancadas::where("status",0)
                ->whereMonth("data","!=",date('m'))
                ->whereHas('comissao.cotacao',function($query){
                    $query->where("plano_id",3);
            })
            ->selectRaw("sum(total) as total_coletivo")
            ->first()
            ->total_coletivo;
            /************************FIM PREMIAÇÔES DO Mes Restante*************************** */
            return view('admin.pages.home.administrador',[
                "totalCliente" => $totalCliente,
                "totalVidasQuantidade" => $totalVidasQuantidade,
                "totalClientesNegociados" => $totalClientesNegociados,                
                "totalVidasClientesNegociados" => $totalVidasClientesNegociados,
                "totalClientesNegociacao" => $totalClientesNegociacao,
                "vidasTotalClientesNegociacao" => $vidasTotalClientesNegociacao,
                "clientesCadastradosEsseMes" => $clientesCadastradosEsseMes,
                "clientesCadastradosEsseMesVidas" => $clientesCadastradosEsseMesVidas,
                "etiquetas" => $etiquetas,
                "totalComissao" => $totalComissao,
                "totalComissaoIndividual" => $totalComissaoIndividual,
                "totalComissaoColetivo" => $totalComissaoColetivo,
                "totalVidasVendidas" => $totalVidasVendidas,
                "totalVidasVendidasIndividual" => $totalVidasVendidasIndividual,
                "totalVidasVendidasColetivo" => $totalVidasVendidasColetivo,
                "totalVendido" => $totalVendido,
                "totalVendidoCotacaoIndividual" => $totalVendidoCotacaoIndividual,
                "totalVendidoCotacaoColetivo" => $totalVendidoCotacaoColetivo,
                "valorTotalValorMesIndividualTotal" => $totalComissaoIndividual + $totalPremiacaoIndividual,                
                "valorTotalColetivoQuantidade" => $totalComissaoColetivo + $totalPremiacaoColetivo,
                "totalPremiacao" => $totalPremiacao,
                "totalPremiacaoIndividual" => $totalPremiacaoIndividual,
                "totalPremiacaoColetivo" => $totalPremiacaoColetivo,
                "totalPremiacaoRestante" => $totalPremiacaoRestante,
                "totalPremiacaoIndividualRestante" => $totalPremiacaoIndividualRestante,
                "totalPremiacaoColetivoRestante" => $totalPremiacaoColetivoRestante,
                "totalVendidoRestante" => $totalVendidoRestante,
                "totalVidasVendidasRestante" => $totalVidasVendidasRestante,
                "totalVidasVendidasIndividualRestante" => $totalVidasVendidasIndividualRestante,
                "totalComissaoRestante" => $totalComissaoRestante,
                "totalComissaoIndividualRestante" => $totalComissaoIndividualRestante,
                'totalVendidoCotacaoIndividualRestante' => $totalVendidoCotacaoIndividualRestante,
                "totalComissaoColetivoRestante" => $totalComissaoColetivoRestante,
                'totalVendidoCotacaoColetivoRestante' => $totalVendidoCotacaoColetivoRestante, 
                'totalVidasVendidasColetivoRestante' => $totalVidasVendidasColetivoRestante,
                'aguardando_boleto_coletivo' => $aguardando_boleto_coletivo,
                'aguardando_boleto_coletivo_total' => $aguardando_boleto_coletivo_total, 
                'aguardando_boleto_coletivo_vidas' => $aguardando_boleto_coletivo_vidas,
                'aguardando_pagamento_adesao_coletivo' => $aguardando_pagamento_adesao_coletivo,
                'aguardando_pagamento_boleto_coletivo_total' => $aguardando_pagamento_boleto_coletivo_total,
                'aguardando_pagamento_boleto_coletivo_vidas' => $aguardando_pagamento_boleto_coletivo_vidas,
                'aguardando_pagamento_vigencia' => $aguardando_pagamento_vigencia, 
                'aguardando_pagamento_vigencia_total' => $aguardando_pagamento_vigencia_total, 
                'aguardando_pagamento_vigencia_vidas' => $aguardando_pagamento_vigencia_vidas,                
                "totalMes" => $totalComissao + $totalPremiacao,
                "tarefasProximas" => $tarefasProximas,
                "tarefasHoje" => $tarefasHoje,
                "tarefasAtrasadas" => $tarefasAtrasadas,
                "clientesSemTarefas" => $clientesSemTarefas,
                "aguardando_individual_qtd" => $aguardando_individual_qtd,
                "aguardando_individual_total" => $aguardando_individual_total,
                "aguardando_individual_vidas" => $aguardando_individual_vidas
                
            ]);

        /********************************************* */
        
    }

    public function corretor()
    {
            $tarefasHoje = Tarefa::where("user_id",auth()->user()->id)
                ->where("status",0)
                ->whereDate('data',date('Y-m-d'))
                ->count();
            
            $tarefasAtrasadas = Tarefa::where("user_id",auth()->user()->id)
                ->where("status",0)
                ->whereDate('data','<',date('Y-m-d'))
                ->count();           
        
            $tarefasProximas = Tarefa::where("user_id",auth()->user()->id)
                ->where("status",0)
                ->whereDate('data','>',date('Y-m-d'))
                ->whereDate('data',"<=",date("Y-m-d",strtotime(now()."+3day")))
                ->count();

            $clientesSemTarefas = Cliente::where("user_id",auth()->user()->id)->whereNotIn('id',function($query){
                $query->select('tarefas.cliente_id');
                $query->from('tarefas');
                $query->whereRaw("user_id=".auth()->user()->id);
            })->count();

            $etiquetas = Etiquetas::selectRaw('nome')->selectRaw('(SELECT count(id) FROM clientes WHERE clientes.etiqueta_id = etiquetas.id AND user_id = '.auth()->user()->id.') AS quantidade')->get();


            $aguardando_boleto_coletivo = Cotacao::where("financeiro_id",1)->where('plano_id',"!=",1)->where("user_id",auth()->user()->id)->count();
            $aguardando_boleto_coletivo_total = Cotacao::where("financeiro_id",1)->where('plano_id',"!=",1)->where("user_id",auth()->user()->id)->selectRaw("sum(valor) as total")->first()->total;
            $aguardando_boleto_coletivo_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("financeiro_id",1);
                $query->where("user_id",auth()->user()->id);
                $query->where("plano_id","!=",1);
            })->selectRaw("sum(quantidade) as total")->first()->total;

            $aguardando_pagamento_adesao_coletivo = Cotacao::where("financeiro_id",2)->where('plano_id',"!=",1)->where('user_id',auth()->user()->id)->count();
            $aguardando_pagamento_boleto_coletivo_total = Cotacao::where("financeiro_id",2)->where('plano_id',"!=",1)->where('user_id',auth()->user()->id)->selectRaw("sum(valor) as total")->first()->total;
            $aguardando_pagamento_boleto_coletivo_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("financeiro_id",2);
                $query->where("user_id",auth()->user()->id);
                $query->where("plano_id","!=",1);
            })->selectRaw("sum(quantidade) as total")->first()->total;

            $aguardando_pagamento_vigencia = Cotacao::where("financeiro_id",4)->where('plano_id',"!=",1)->where('user_id',auth()->user()->id)->count();
            $aguardando_pagamento_vigencia_total = Cotacao::where("financeiro_id",4)->where('plano_id',"!=",1)->where('user_id',auth()->user()->id)->selectRaw("sum(valor) as total")->first()->total;
            $aguardando_pagamento_vigencia_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("financeiro_id",4);
                $query->where("user_id",auth()->user()->id);
                $query->where("plano_id","!=",1);
            })->selectRaw("sum(quantidade) as total")->first()->total;

            $aguardando_individual_qtd = Cotacao::where("financeiro_id",1)->where("user_id",auth()->user()->id)->where("plano_id",1)->count();
            $aguardando_individual_total = Cotacao::where("financeiro_id",1)->where("user_id",auth()->user()->id)->where("plano_id",1)->selectRaw("sum(valor) as total")->first()->total;
            $aguardando_individual_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("financeiro_id",1);
                $query->where("plano_id",1);
                $query->where("user_id",auth()->user()->id);
            })->selectRaw("sum(quantidade) as total")->first()->total;

            $totalCliente    = Cliente::where("user_id",auth()->user()->id)->count();
            $totalVidasQuantidade = CotacaoFaixaEtaria::whereIn("cotacao_id",function($query){
                $query->select('cotacoes.id');
                $query->from('cotacoes');
                $query->whereRaw("cotacoes.user_id=".auth()->user()->id);
            })->selectRaw("sum(quantidade) as quantidade_total_vidas")->first()->quantidade_total_vidas;

            $totalClientesNegociados = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id",6)->whereHas('clientes',function($query){
                $query->where('etiqueta_id','=',3);
            })->count();

            $totalVidasClientesNegociados = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("user_id",auth()->user()->id);
                $query->where("financeiro_id",6);    
            })->selectRaw("SUM(quantidade) AS total_quantidade")->first()->total_quantidade;

            $totalClientesNegociacao = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id","!=",6)->count();
            $vidasTotalClientesNegociacao = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("financeiro_id","!=",6);
                $query->where("user_id",auth()->user()->id);
            })->selectRaw("sum(quantidade) as total")->first()->total;
            
            $clientesCadastradosEsseMes = DB::table('clientes')->whereRaw("user_id = ? AND MONTH(NOW()) = MONTH(created_at) AND YEAR(now()) = YEAR(created_at)",[auth()->user()->id])->count();
            $clientesCadastradosEsseMesVidas = CotacaoFaixaEtaria::whereHas('cotacao.clientes',function($query){
                $query->where("user_id",auth()->user()->id);
                $query->whereMonth('created_at',date('m'));
                $query->whereYear('created_at',date('Y'));
            })->selectRaw("sum(quantidade) as total")->first()->total;
            



            /***********************Mes Atual**********************************************************************/
            $totalVendido = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id",6)->whereHas('comissao.comissaoLancadas',function($query){
                $query->where("status",1);
                $query->where("user_id",auth()->user()->id);
                $query->whereRaw("MONTH(data) = MONTH(NOW())");
            })->selectRaw("sum(valor) as total")->first()->total;
            
            $totalVidasVendidas = CotacaoFaixaEtaria::whereHas('cotacao.comissao.comissaoLancadas',function($query){
                $query->where("status",1);
                $query->whereRaw("MONTH(data) = MONTH(now())");
            })->selectRaw("sum(quantidade) as total")->first()->total;    


            
            

            $totalVidasVendidasIndividual = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("plano_id",1);
                $query->whereHas("comissao.comissaoLancadas",function($query){
                    $query->where("status",1);
                    $query->whereRaw("MONTH(data) = MONTH(now()) AND YEAR(data) = YEAR(now())");
                });
            })->selectRaw("sum(quantidade) as total")->first()->total;
            
            $totalVidasVendidasColetivo = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("plano_id",3);
                $query->whereHas("comissao.comissaoLancadas",function($query){
                    $query->where("status",1);
                    $query->whereRaw("MONTH(data) = MONTH(now()) AND YEAR(data) = YEAR(now())");
                });
            })->selectRaw("sum(quantidade) as total")->first()->total;
        
            $totalVendidoCotacaoIndividual = Cotacao::where("user_id",auth()->user()->id)->where('plano_id',1)->where("financeiro_id",6)->whereHas('comissao.comissaoLancadas',function($query){
                $query->where("status",1);
                $query->whereRaw("MONTH(data) = MONTH(NOW())");
            })->selectRaw("sum(valor) as total")->first()->total;

            $totalVendidoCotacaoColetivo = Cotacao::where("user_id",auth()->user()->id)->where('plano_id',3)->where("financeiro_id",6)->whereHas('comissao.comissaoLancadas',function($query){
                $query->where("status",1);
                $query->whereRaw("MONTH(data) = MONTH(NOW()) AND YEAR(data) = YEAR(now())");
            })->selectRaw("sum(valor) as total")->first()->total;                      

            /************************Comissao do Mes***************************************** */
            
            $totalComissao = ComissoesCorretorLancados::where("user_id",auth()->user()->id)->where("status",1)->whereMonth("data",date('m'))->selectRaw("sum(valor) as total")->first()->total;
            $totalComissaoIndividual = ComissoesCorretorLancados::where("user_id",auth()->user()->id)
                ->where("status",1)
                ->whereMonth("data",date('m'))
                ->whereHas('comissao.cotacao',function($query){
                    $query->where("plano_id",1);
            })->selectRaw("sum(valor) as total_individual")->first()->total_individual;

            $totalComissaoColetivo = ComissoesCorretorLancados::where("user_id",auth()->user()->id)
                ->where("status",1)
                ->whereMonth("data",date('m'))
                ->whereHas('comissao.cotacao',function($query){
                    $query->where("plano_id",3);
            })->selectRaw("sum(valor) as total_coletivo")->first()->total_coletivo;

            /************************Fim Comissao do Mes***************************************** */




            /*********************PREMIAÇÔES DO MES*************************** */
            $totalPremiacao = PremiacaoCorretoresLancados::where("user_id",auth()->user()->id)->where("status",1)->whereMonth("data",date('m'))->selectRaw("sum(total) as total")->first()->total;
            $totalPremiacaoIndividual = PremiacaoCorretoresLancados::where("user_id",auth()->user()->id)
            ->where("status",1)
            ->whereMonth("data",date('m'))
            ->whereHas('comissao.cotacao',function($query){
                $query->where("plano_id",1);
            })->selectRaw("sum(total) as total_individual")->first()->total_individual;
            $totalPremiacaoColetivo = PremiacaoCorretoresLancados::where("user_id",auth()->user()->id)
                ->where("status",1)
                ->whereMonth("data",date('m'))
                ->whereHas('comissao.cotacao',function($query){
                    $query->where("plano_id",3);
            })->selectRaw("sum(total) as total_coletivo")->first()->total_coletivo;
            /*********************FIM PREMIAÇÔES DO MES*************************** */





            /*****************************************************Fim Mes Atual**********************************************************************************/


            /*****************************************************Total Restante*********************************************************************************/
            $totalVendidoRestante = Cotacao::where("user_id",auth()->user()->id)->where("financeiro_id",6)->whereHas('comissao.comissaoLancadas',function($query){
                $query->where("status",0);
                $query->whereRaw("MONTH(data) != MONTH(NOW())");
            })->selectRaw("sum(valor) as total")->first()->total;
            $totalVidasVendidasRestante = CotacaoFaixaEtaria::whereHas('cotacao.comissao.comissaoLancadas',function($query){
                $query->where("status",0);
                $query->whereRaw("MONTH(data) != MONTH(now())");
            })->selectRaw("sum(quantidade) as total")->first()->total;

            $totalVendidoCotacaoIndividualRestante = Cotacao::where("user_id",auth()->user()->id)->where('plano_id',1)->where("financeiro_id",6)->whereHas('comissao.comissaoLancadas',function($query){
                $query->where("status",0);
                $query->whereRaw("MONTH(data) != MONTH(NOW())");
            })->selectRaw("sum(valor) as total")->first()->total;
            $totalVidasVendidasIndividualRestante = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("plano_id",1);
                $query->whereHas("comissao.comissaoLancadas",function($query){
                    $query->where("status",0);
                    $query->whereRaw("MONTH(data) != MONTH(now())");
                });
            })->selectRaw("sum(quantidade) as total")->first()->total;

            $totalVendidoCotacaoColetivoRestante = Cotacao::where("user_id",auth()->user()->id)->where('plano_id',3)->where("financeiro_id",6)->whereHas('comissao.comissaoLancadas',function($query){
                $query->where("status",0);
                $query->whereRaw("MONTH(data) != MONTH(NOW())");
            })->selectRaw("sum(valor) as total")->first()->total;
            $totalVidasVendidasColetivoRestante = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("plano_id",3);
                $query->whereHas("comissao.comissaoLancadas",function($query){
                    $query->where("status",0);
                    $query->whereRaw("MONTH(data) != MONTH(now())");
                });
            })->selectRaw("sum(quantidade) as total")->first()->total;



            /*****************************************************Fim Total Restante*********************************************************************************/


            /************************Comissao do Restante***********************************************/
            $totalComissaoRestante = ComissoesCorretorLancados::where("user_id",auth()->user()->id)
                ->where("status",0)
                ->whereMonth("data","!=",date('m'))
                ->selectRaw("sum(valor) as total")
                ->first()
                ->total;
            $totalComissaoIndividualRestante = ComissoesCorretorLancados::where("user_id",auth()->user()->id)
                ->where("status",0)
                ->whereMonth("data","!=",date('m'))
                ->whereHas('comissao.cotacao',function($query){
                    $query->where("plano_id",1);
            })
            ->selectRaw("sum(valor) as total_individual")
            ->first()
            ->total_individual;

            $totalComissaoColetivoRestante = ComissoesCorretorLancados::where("user_id",auth()->user()->id)
                ->where("status",0)
                ->whereMonth("data","!=",date('m'))
                ->whereHas('comissao.cotacao',function($query){
                    $query->where("plano_id",3);
            })
            ->selectRaw("sum(valor) as total_coletivo")
            ->first()
            ->total_coletivo;

            /************************Fim Comissao Restante**********************************************/

            /*************************PREMIAÇÔES DO MES Restante****************************/
            
            $totalPremiacaoRestante = PremiacaoCorretoresLancados::where("user_id",auth()->user()->id)
            ->where("status",0)
            ->whereMonth("data","!=",date('m'))
            ->selectRaw("sum(total) as total")
            ->first()
            ->total;

            $totalPremiacaoIndividualRestante = PremiacaoCorretoresLancados::where("user_id",auth()->user()->id)
            ->where("status",0)
            ->whereMonth("data","!=",date('m'))
            ->whereHas('comissao.cotacao',function($query){
                $query->where("plano_id",0);
            })
            ->selectRaw("sum(total) as total_individual")
            ->first()
            ->total_individual;

            $totalPremiacaoColetivoRestante = PremiacaoCorretoresLancados::where("user_id",auth()->user()->id)
                ->where("status",0)
                ->whereMonth("data","!=",date('m'))
                ->whereHas('comissao.cotacao',function($query){
                    $query->where("plano_id",3);
            })
            ->selectRaw("sum(total) as total_coletivo")
            ->first()
            ->total_coletivo;

            
            
            /************************FIM PREMIAÇÔES DO Mes Restante*************************** */
            return view('admin.pages.home.colaborador',[
                "totalCliente" => $totalCliente,
                "totalVidasQuantidade" => $totalVidasQuantidade,
                "totalClientesNegociados" => $totalClientesNegociados,                
                "totalVidasClientesNegociados" => $totalVidasClientesNegociados,
                "totalClientesNegociacao" => $totalClientesNegociacao,
                "vidasTotalClientesNegociacao" => $vidasTotalClientesNegociacao,
                "clientesCadastradosEsseMes" => $clientesCadastradosEsseMes,
                "clientesCadastradosEsseMesVidas" => $clientesCadastradosEsseMesVidas,
                "etiquetas" => $etiquetas,
                "totalComissao" => $totalComissao,
                "totalComissaoIndividual" => $totalComissaoIndividual,
                "totalComissaoColetivo" => $totalComissaoColetivo,
                "totalVidasVendidas" => $totalVidasVendidas,
                "totalVidasVendidasIndividual" => $totalVidasVendidasIndividual,
                "totalVidasVendidasColetivo" => $totalVidasVendidasColetivo,
                "totalVendido" => $totalVendido,
                "totalVendidoCotacaoIndividual" => $totalVendidoCotacaoIndividual,
                "totalVendidoCotacaoColetivo" => $totalVendidoCotacaoColetivo,
                "valorTotalValorMesIndividualTotal" => $totalComissaoIndividual + $totalPremiacaoIndividual,                
                "valorTotalColetivoQuantidade" => $totalComissaoColetivo + $totalPremiacaoColetivo,
                "totalPremiacao" => $totalPremiacao,
                "totalPremiacaoIndividual" => $totalPremiacaoIndividual,
                "totalPremiacaoColetivo" => $totalPremiacaoColetivo,
                "totalPremiacaoRestante" => $totalPremiacaoRestante,
                "totalPremiacaoIndividualRestante" => $totalPremiacaoIndividualRestante,
                "totalPremiacaoColetivoRestante" => $totalPremiacaoColetivoRestante,
                "totalVendidoRestante" => $totalVendidoRestante,
                "totalVidasVendidasRestante" => $totalVidasVendidasRestante,
                "totalVidasVendidasIndividualRestante" => $totalVidasVendidasIndividualRestante,
                "totalComissaoRestante" => $totalComissaoRestante,
                "totalComissaoIndividualRestante" => $totalComissaoIndividualRestante,
                'totalVendidoCotacaoIndividualRestante' => $totalVendidoCotacaoIndividualRestante,
                "totalComissaoColetivoRestante" => $totalComissaoColetivoRestante,
                'totalVendidoCotacaoColetivoRestante' => $totalVendidoCotacaoColetivoRestante, 
                'totalVidasVendidasColetivoRestante' => $totalVidasVendidasColetivoRestante,
                'aguardando_boleto_coletivo' => $aguardando_boleto_coletivo,
                'aguardando_boleto_coletivo_total' => $aguardando_boleto_coletivo_total, 
                'aguardando_boleto_coletivo_vidas' => $aguardando_boleto_coletivo_vidas,
                'aguardando_pagamento_adesao_coletivo' => $aguardando_pagamento_adesao_coletivo,
                'aguardando_pagamento_boleto_coletivo_total' => $aguardando_pagamento_boleto_coletivo_total,
                'aguardando_pagamento_boleto_coletivo_vidas' => $aguardando_pagamento_boleto_coletivo_vidas,
                'aguardando_pagamento_vigencia' => $aguardando_pagamento_vigencia, 
                'aguardando_pagamento_vigencia_total' => $aguardando_pagamento_vigencia_total, 
                'aguardando_pagamento_vigencia_vidas' => $aguardando_pagamento_vigencia_vidas,                
                "totalMes" => $totalComissao + $totalPremiacao,
                "tarefasProximas" => $tarefasProximas,
                "tarefasHoje" => $tarefasHoje,
                "tarefasAtrasadas" => $tarefasAtrasadas,
                "clientesSemTarefas" => $clientesSemTarefas,
                "aguardando_individual_qtd" => $aguardando_individual_qtd,
                "aguardando_individual_total" => $aguardando_individual_total,
                "aguardando_individual_vidas" => $aguardando_individual_vidas
                
            ]);
    }

    public function financeiro()
    {
        
        $meses = ['01'=>"Janeiro",'02'=>"Fevereiro",'03'=>"Março",'04'=>"Abril",'05'=>"Maio",'06'=>"Junho",'07'=>"Julho",'08'=>"Agosto",'09'=>"Setembro",'10'=>"Outubro",'11'=>"Novembro",'12'=>"Dezembro"];
            $aguardando_boleto_coletivo = Cotacao::where("financeiro_id",1)->where("plano_id","!=",1)->whereMonth('updated_at', date('m'))->whereYear("updated_at",date('Y'))->count();
            $aguardando_boleto_coletivo_total = Cotacao::where("financeiro_id",1)->where("plano_id","!=",1)->whereYear("updated_at",date('Y'))->whereMonth('updated_at', date('m'))->selectRaw("sum(valor) as total")->first()->total;
            $aguardando_boleto_coletivo_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("financeiro_id",1);
                $query->where("plano_id","!=",1);
                $query->whereYear("updated_at",date('Y'));
                $query->whereMonth("updated_at",date('m'));
            })->selectRaw("sum(quantidade) as total")->first()->total;
       
            $aguardando_pagamento_adesao_coletivo = Cotacao::where("financeiro_id",2)->whereYear("updated_at",date('Y'))->whereMonth('updated_at', date('m'))->where("plano_id","!=",1)->count();
            $aguardando_pagamento_boleto_coletivo_total = Cotacao::where("financeiro_id",2)->whereYear("updated_at",date('Y'))->whereMonth('updated_at', date('m'))->where("plano_id","!=",1)->selectRaw("sum(valor) as total")->first()->total;
            $aguardando_pagamento_boleto_coletivo_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("financeiro_id",2);
                $query->where("plano_id","!=",1);
                $query->whereMonth('updated_at',date('m'));
                $query->whereYear("updated_at",date('Y'));
            })->selectRaw("sum(quantidade) as total")->first()->total;

            $aguardando_individual_qtd = Cotacao::where("financeiro_id",1)->whereMonth('updated_at', date('m'))->whereYear("updated_at",date('Y'))->where("plano_id",1)->count();
            
            $aguardando_individual_total = Cotacao::where("financeiro_id",1)->whereMonth('updated_at', date('m'))->whereYear("updated_at",date('Y'))->where("plano_id",1)->selectRaw("sum(valor) as total")->first()->total;
            $aguardando_individual_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("financeiro_id",1);
                $query->where("plano_id",1);
                $query->whereMonth('updated_at', date('m'));
                $query->whereYear('updated_at', date('Y'));
            })->selectRaw("sum(quantidade) as total")->first()->total;


            $aguardando_pagamento_vigencia = Cotacao::where("financeiro_id",4)->whereYear('updated_at', date('Y'))->whereMonth('updated_at', date('m'))->where("plano_id","!=",1)->count();
            $aguardando_pagamento_vigencia_total = Cotacao::where("financeiro_id",4)->whereYear('updated_at', date('Y'))->whereMonth('updated_at', date('m'))->where("plano_id","!=",1)->selectRaw("sum(valor) as total")->first()->total;
            $aguardando_pagamento_vigencia_vidas = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("financeiro_id",4);
                $query->where("plano_id","!=",1);
                $query->whereMonth('updated_at', date('m'));
                $query->whereYear('updated_at', date('Y'));
            })->selectRaw("sum(quantidade) as total")->first()->total;

            $primeiros = DB::select(DB::raw("SELECT 
                user_id,
                (SELECT NAME FROM users WHERE users.id = cc.user_id) AS vendedor,
                (SELECT image FROM users WHERE users.id = cc.user_id) AS imagem, 
                (SELECT if(SUM(quantidade)>0,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id IN(SELECT id FROM cotacoes AS dentro WHERE dentro.user_id = cc.user_id AND dentro.plano_id = 1 AND dentro.financeiro_id = 6)) AS vidas_individual,
                (SELECT if(SUM(quantidade)>0,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id IN(SELECT id FROM cotacoes AS dentro WHERE dentro.user_id = cc.user_id AND dentro.plano_id = 3 AND dentro.financeiro_id = 6)) AS vidas_coletivo,
                SUM(quantidade) AS total_vidas,
                (SELECT sum(valor) FROM cotacoes AS dentro WHERE dentro.plano_id = 1 AND dentro.financeiro_id = 6 AND dentro.user_id = cc.user_id) AS valor_individual,
                (SELECT sum(valor) FROM cotacoes AS dentro WHERE dentro.plano_id = 3 AND dentro.financeiro_id = 6 AND dentro.user_id = cc.user_id) AS valor_coletivo,
                (SELECT SUM(valor) FROM cotacoes dentro WHERE dentro.financeiro_id = 6 AND dentro.user_id = cc.user_id) total_valor
                FROM cotacao_faixa_etarias AS cf
                INNER JOIN cotacoes AS cc ON cc.id = cf.cotacao_id
                WHERE financeiro_id = 6 AND YEAR(cc.updated_at) = YEAR(NOW()) AND MONTH(cc.updated_at) = MONTH(NOW())
                GROUP BY user_id
                ORDER BY total_vidas DESC
                LIMIT 5
            "));

            $ranking = DB::select("SELECT 
                id_user,
                usuarios,quantidade_allcare,allcare,quantidade_alter,alters,quantidade_qualicorp,qualicorp,quantidade_hapvida,hapvida,total
                FROM 
                (
                    select 
                        (SELECT id FROM users WHERE users.id = fora.user_id) id_user,
                        (SELECT NAME FROM users WHERE users.id = fora.user_id) AS usuarios,
                        (SELECT if(SUM(valor)>0,SUM(valor),0) from cotacoes AS dentro WHERE dentro.user_id = users.id AND financeiro_id = 6 AND dentro.administradora_id = 1) AS 'allcare',
                        (SELECT if(SUM(quantidade)>0,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id IN(SELECT id FROM cotacoes as dentro WHERE dentro.user_id = users.id AND administradora_id = 1 AND financeiro_id = 6)) AS 'quantidade_allcare',
                        (SELECT if(SUM(valor)>0,SUM(valor),0) from cotacoes AS dentro WHERE dentro.user_id = users.id AND financeiro_id = 6 AND dentro.administradora_id = 2) AS 'alters',
                        (SELECT if(SUM(quantidade)>0,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id IN(SELECT id FROM cotacoes as dentro WHERE dentro.user_id = users.id AND administradora_id = 2 AND financeiro_id = 6)) AS 'quantidade_alter',
                        (SELECT if(SUM(valor)>0,SUM(valor),0) from cotacoes AS dentro WHERE dentro.user_id = users.id AND financeiro_id = 6 AND dentro.administradora_id = 3) AS 'qualicorp',
                        (SELECT if(SUM(quantidade)>0,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id IN(SELECT id FROM cotacoes as dentro WHERE dentro.user_id = users.id AND administradora_id = 3 AND financeiro_id = 6)) AS 'quantidade_qualicorp',
                        (SELECT if(SUM(valor)>0,SUM(valor),0) from cotacoes AS dentro WHERE dentro.user_id = users.id AND financeiro_id = 6 AND dentro.administradora_id = 4) AS 'hapvida',
                        (SELECT if(SUM(quantidade)>0,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id IN(SELECT id FROM cotacoes as dentro WHERE dentro.user_id = users.id AND administradora_id = 4 AND financeiro_id = 6)) AS 'quantidade_hapvida',
                        (SELECT SUM(valor) FROM cotacoes AS dentro WHERE dentro.user_id = users.id AND financeiro_id = 6) AS 'total'
                    from cotacoes AS fora
                    INNER JOIN cotacao_faixa_etarias ON cotacao_faixa_etarias.cotacao_id = fora.id
                    INNER JOIN administradoras ON fora.administradora_id = administradoras.id 
                    INNER JOIN users ON users.id = fora.user_id
                    where financeiro_id = 6 AND MONTH(fora.updated_at) = MONTH(NOW()) AND YEAR(fora.updated_at) = YEAR(NOW()) GROUP BY fora.user_id
                    ORDER BY total desc
                )
                AS full_tabela"
            );

            $totalIndividual = Cotacao::where("financeiro_id",6)
                ->where("plano_id",1)
                ->whereMonth("updated_at",date('m'))
                ->whereYear("updated_at",date('Y'))
                ->selectRaw("sum(valor) as total")
                ->first()
                ->total;
           
            $totalGeralVidas = Cotacao::where("financeiro_id",6)->whereMonth("cotacoes.updated_at",date('m'))->whereYear('cotacoes.updated_at',date('Y'))
                ->join("cotacao_faixa_etarias","cotacao_faixa_etarias.cotacao_id","cotacoes.id")
                ->selectRaw("sum(quantidade) as qtd")->first()->qtd;
               
      
            $totalVidasIndividual = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("plano_id",1);
                $query->whereMonth("updated_at",date('m'));
                $query->whereYear("updated_at",date('Y'));
                $query->where("financeiro_id",6);
            })->selectRaw("sum(quantidade) as total")->first()->total;
        
            $totalColetivo = Cotacao::where("financeiro_id",6)
            ->where("plano_id",3)
            ->whereMonth("updated_at",date('m'))
            ->whereYear("updated_at",date('Y'))
            ->selectRaw("sum(valor) as total")
            ->first()
            ->total;

            $totalVidasColetivo = CotacaoFaixaEtaria::whereHas('cotacao',function($query){
                $query->where("plano_id",3);
                $query->whereMonth("updated_at",date('m'));
                $query->whereYear("updated_at",date('Y'));
                $query->where("financeiro_id",6);
            })->selectRaw("sum(quantidade) as total")->first()->total;

            $administradorasVidaTotal = DB::select(
                "SELECT 
                id,nome,
                (SELECT SUM(valor) FROM cotacoes WHERE cotacoes.administradora_id = administradoras.id AND financeiro_id = 6 AND MONTH(cotacoes.updated_at) = MONTH(NOW()) AND YEAR(cotacoes.updated_at) = YEAR(NOW())) AS valores,
                (SELECT if(SUM(quantidade)>0,SUM(quantidade),0) FROM cotacao_faixa_etarias WHERE cotacao_id IN(SELECT id FROM cotacoes as dentro WHERE administradora_id = (SELECT id FROM administradoras as aa WHERE aa.id = administradoras.id) AND financeiro_id = 6)) AS qte
            FROM administradoras WHERE id != (SELECT id FROM administradoras WHERE nome LIKE '%hap%')"
            );
            

            $atrasadoAguardandoPagAdesaoColetivo = Cotacao::where("financeiro_id",2)->whereMonth("updated_at",date('m'))->whereYear("updated_at",date('Y'))->whereHas('clientes',function($query){
                $query->where("data_boleto","<",date('Y-m-d'));            
            })->count();
        
            $atrasadoAguardandoPagVigenciaColetivo = Cotacao::where("financeiro_id",4)->whereMonth("updated_at",date('m'))->whereYear("updated_at",date('Y'))->whereHas('clientes',function($query){
                $query->where("data_vigente","<",date('Y-m-d'));            
            })->count();

            $atrasadoPlanoIndividual = Cotacao::where("plano_id",1)->where("financeiro_id",1)->whereHas('clientes',function($query){
                $query->where("data_boleto","<",date('Y-m-d'));
                $query->orWhere("data_vigente","<",date("Y-m-d"));
            })->count();
            
            
        
        //$aguardando_pagamento_plano_individual = Cotacao::where("financeiro_id",3)->count();
        $aguardando_pagamento_empresarial = CotacaoJuridica::where("status",0)->count();
        $valor_aguardando_pagamento_empresarial = CotacaoJuridica::where("status",0)->selectRaw("SUM(valor) as total")->first()->total;
        $qtd_vidas_aguardando_pagamento_empresarial = CotacaoJuridica::where("status",0)->selectRaw("SUM(quantidade_vidas) as quantidade")->first()->quantidade;

        return view('admin.pages.home.financeiro',[
            "quantidade_aguardando_boleto_coletivo" => $aguardando_boleto_coletivo,
            "aguardando_boleto_coletivo_total" =>  $aguardando_boleto_coletivo_total,
            "aguardando_boleto_coletivo_vidas" => $aguardando_boleto_coletivo_vidas,
            "quantidade_aguardando_pagamento_adesao_coletivo" => $aguardando_pagamento_adesao_coletivo,
            "aguardando_pagamento_boleto_coletivo_total" => $aguardando_pagamento_boleto_coletivo_total,
            "aguardando_pagamento_boleto_coletivo_vidas" => $aguardando_pagamento_boleto_coletivo_vidas,
            
            "quantidade_aguardando_pagamento_plano_individual" => $aguardando_individual_qtd,
            "aguardando_individual_total" => $aguardando_individual_total,
            "aguardando_individual_vidas" => $aguardando_individual_vidas,

            "atrasadoAguardandoPagAdesaoColetivo" => $atrasadoAguardandoPagAdesaoColetivo,
            "atrasadoAguardandoPagVigenciaColetivo" => $atrasadoAguardandoPagVigenciaColetivo,
            "atrasadoPlanoIndividual" => $atrasadoPlanoIndividual,

            "quantidade_pagamento_vigencia" =>  $aguardando_pagamento_vigencia,
            "aguardando_pagamento_vigencia_total" =>  $aguardando_pagamento_vigencia_total,
            "aguardando_pagamento_vigencia_vidas" =>  $aguardando_pagamento_vigencia_vidas,
            "quantidade_pagamento_empresarial" => $aguardando_pagamento_empresarial,
            "valor_aguardando_pagamento_empresarial" => $valor_aguardando_pagamento_empresarial,
            "qtd_vidas_aguardando_pagamento_empresarial" => $qtd_vidas_aguardando_pagamento_empresarial,

            "primeiros" => $primeiros,
            "ranking" => $ranking,
            "totalIndividual" => $totalIndividual,
            "totalVidasIndividual" => $totalVidasIndividual,
            "totalColetivo" => $totalColetivo,
            "totalVidasColetivo" => $totalVidasColetivo,
            "administradorasVidaTotal" => $administradorasVidaTotal,
            "totalGeralVidas" => $totalGeralVidas,
            "aguardando_individual_qtd" => $aguardando_individual_qtd,
            "mes" => $meses[(\DateTime::createFromFormat('!m', date('m')))->format('m')]
        ]);
    }

    public function detalhesColaborador($id)
    {
        $user = User::find($id);
        $cargo = $user->hasPermission('comissoes') ? "Financeiro" : "Corretor";
        
        return view("admin.pages.home.detalhes",[
            "user" => $user,
            "cargo" => $cargo
        ]);
    }

    public function pegarCidadesHome(Request $request)
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




    public function comissoes(Request $request)
    {
        if($request->ajax()) {
            $user = User::where("id",auth()->user()->id)->first();
            if($user->hasPermission('configuracoes') || $user->isAdmin()) {  
                $comissoes = ComissoesCorretoraLancadas
                    ::where("status",1)
                    ->whereRaw("MONTH(data) = MONTH(now())")
                    ->with(
                        "comissao",
                        "comissao.cliente",
                        "comissao.cotacao",
                        "comissao.cotacao.administradora"
                    )->get();    
                return response()->json($comissoes); 
            } else {
                $comissoes = ComissoesCorretorLancados
                ::where("status",1)
                ->where("user_id",auth()->user()->id)
                ->whereRaw("MONTH(data) = MONTH(now())")
                ->with("comissao","comissao.cliente","comissao.cotacao","comissao.cotacao.administradora")
                ->get();    
                return response()->json($comissoes); 
            }
        }    
    }

    public function premiacoes(Request $request)
    {
        if($request->ajax()) {
            $user = User::where("id",auth()->user()->id)->first();
            if($user->hasPermission('configuracoes') || $user->isAdmin()) { 
                $premiacoes = PremiacaoCorretoraLancadas::where("status",1)->whereRaw("MONTH(data) = MONTH(now())")->with("comissao","comissao.cliente","comissao.cotacao","comissao.cotacao.administradora")->get();
                return response()->json($premiacoes); 
            } else {
                $premiacoes = PremiacaoCorretoresLancados::where("status",1)->where("user_id",auth()->user()->id)->whereRaw("MONTH(data) = MONTH(now())")->with("comissao","comissao.cliente","comissao.cotacao","comissao.cotacao.administradora")->get();    
                return response()->json($premiacoes); 
            }
            
        }    
    }

    public function listarTarefasHome(Request $request)
    {
        if($request->ajax()) {
            $user = User::where("id",auth()->user()->id)->first();
            if($user->hasPermission('configuracoes') || $user->isAdmin()) {  
                $tarefas = Tarefa::where("status",0)
                ->selectRaw('(SELECT nome FROM clientes WHERE clientes.id = tarefas.cliente_id) AS cliente')
                ->selectRaw('(SELECT name FROM users WHERE users.id = tarefas.user_id) AS corretor')
                ->selectRaw("title")
                ->selectRaw("DATE_FORMAT(data, '%d/%m/%Y') as data")
                ->selectRaw("DATA - DATE(NOW()) AS falta")
                ->get();
                return $tarefas;
            } else {
                $tarefas = Tarefa::where("user_id",auth()->user()->id)->where("status",0)
                ->selectRaw('(SELECT nome FROM clientes WHERE clientes.id = tarefas.cliente_id) AS cliente')
                ->selectRaw("title")
                ->selectRaw("DATE_FORMAT(data, '%d/%m/%Y') as data")
                ->selectRaw("DATA - DATE(NOW()) AS falta")
                ->get();
                return $tarefas;
            }
        } else {
            return redirect()->route("admin.home");
        }
    }

    public function listarClientesHome(Request $request)
    {
        if($request->ajax()) {
            $user = User::where("id",auth()->user()->id)->first();
            if($user->hasPermission('configuracoes') || $user->isAdmin()) {  
                $clientes =  Cliente::where('etiqueta_id',"!=",3)
                ->selectRaw("DATE_FORMAT(created_at, '%d/%m/%Y') as data")
                ->selectRaw("(SELECT name FROM users WHERE users.id = clientes.user_id) as corretor")
                ->selectRaw("nome,telefone")    
                ->selectRaw("(SELECT cor FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS status")->get();
                return $clientes;
            } else {
                $clientes =  Cliente::where("user_id",auth()->user()->id)->where('etiqueta_id',"!=",3)
                ->selectRaw("DATE_FORMAT(created_at, '%d/%m/%Y') as data")
                ->selectRaw("nome,telefone")    
                ->selectRaw("(SELECT cor FROM etiquetas WHERE etiquetas.id = clientes.etiqueta_id) AS status")->get();
                return $clientes;
            }
            
        } else {
            return redirect()->route("admin.home");
        }
    }







    public function searchHome()
    {
        
        $operadoras = Operadora::all();
        $administradoras = Administradora::all();
        $tipos = Planos::all();    
        $modelos = Acomodacao::all();
        return view("admin.pages.home.search",[
                "operadoras" => $operadoras,
                "administradoras" => $administradoras,
                "tipos" => $tipos,
                "modelos" => $modelos
            ]);  
    }

    public function storeSearch(Request $request)
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
            "operadora_search.required" => "Operadora e obrigatorio",
            "administradora_search.required" => "Administradora e obrigatorio",
            "planos_search.required" => "Plano e campo obrigatorio",
            "coparticipacao_search.required" => "Coparticipacao e obrigatorio",
            "odonto_search.required" => "Odonto e obrigatorio",
            "cidade_search.required" => "Cidade e obrigatorio"
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
        return view("admin.pages.home.search",[
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


    public function relatorio()
    {
        $administradoras = Administradora::all();
        $planos = Planos::all();

        return view("admin.pages.home.relatorio",[
            "administradoras" => $administradoras,
            "planos" => $planos
        ]);
    }


    public function criarRelatorio(Request $request)
    {
        $rules = ["data_inicial" => "required","data_final" => "required"];
        $message = [
            "data_inicial.required" => "O campo data inicial e campo obrigatorio",
            "data_final.required" => "O campo data final e campo obrigatorio"
        ];
        $request->validate($rules,$message);
        $comissoes = ComissoesCorretorLancados::where("user_id",auth()->user()->id)
            ->whereHas("comissao.cotacao",function($q) use($request){
                    if(!empty($request->administradora)) {
                        $q->where("administradora_id",$request->administradora);
                    }
                    if(!empty($request->plano)) {
                        $q->where("plano_id",$request->plano);
                    }
            })
            ->whereDate("data",">=",$request->data_inicial)
            ->whereDate("data","<=",$request->data_final)

            ->where("status",1)    
            ->with(["comissao.cotacao","comissao.cliente"])
            ->get();
        
        if(count($comissoes) >= 1) {
            return view("admin.pages.home.modal",[
                "comissoes" => $comissoes,
                "data_inicial" => $request->data_inicial,
                "data_final" => $request->data_final
            ]);
        } else {
            $administradoras = Administradora::all();
            $planos = Planos::all();
            return view("admin.pages.home.relatorio",[
                "administradoras" => $administradoras,
                "planos" => $planos,
                
            ])->with("error","Não existe registro nesse periodo de tempo");
        }   
    
            
        
        
        
    }








}
