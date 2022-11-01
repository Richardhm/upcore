@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('content_header')
    <h1>Dashboard - Corretor</h1>
@stop
@section('content_top_nav_right')

<li class="nav-item">
        <a href="{{route('home.calculadora')}}" class="nav-link text-white">
            <i class="fas fa-calculator"></i>
            Calculadora
        </a>
    </li>
    <li class="nav-item">
        <a href="{{route('home.calendario')}}" class="nav-link text-white">
            <i class="fas fa-calendar-alt"></i>
            Calendario
        </a>
    </li>
    <li class="nav-item">
        <a href="{{route('home.lembretes')}}" class="nav-link text-white">
            <i class="fas fa-sticky-note"></i>
            Lembretes
        </a>
    </li>
    <li class="nav-item">
        <!-- <div class="d-flex align-items-center bg-danger"> -->
            
            <a href="{{route('admin.home.search')}}" class="nav-link text-white">
                <i class="fas fa-money-check-alt"></i>
                Tabela de Preços
            </a>
        <!-- </div> -->
        
    </li>

@stop
@section('content')
<section class="content">

<div class="container-fluid">
    <div class="row">

            <div class="col-md-3 col-3">
                <div class="small-box bg-info shadow-lg">
                    <a href="{{url('/admin/tarefas?ac=hoje')}}">
                        <div>
                            <h3 class="ml-2" style="margin:0px;">{{$tarefasHoje}}</h3>
                            <p class="ml-2">Tarefas Hoje</p>
                            <div class="icon text-white">
                                <i class="fas fa-calendar-day fa-xs" style="font-size:50px;top:10px;"></i>
                            </div>                        
                        </div>
                    </a>    
                </div>
            </div>

            <div class="col-md-3 col-3">
                <div class="small-box bg-danger">
                    <a href="{{url('/admin/tarefas?ac=atraso')}}">
                        <div>
                            <h3 class="ml-2" style="margin:0px;">{{$tarefasAtrasadas}}</h3>
                            <p class="ml-2">Tarefas Atrasadas</p>
                            <div class="icon text-white">
                                <i class="fas fa-thumbs-down fa-xs text-white" style="font-size:50px;top:10px;"></i>
                                
                            </div>   
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3 col-3">
                <div class="small-box bg-teal">
                    <a href="{{url('/admin/tarefas?ac=mes')}}">
                        <div>
                            <h3 class="text-white ml-2" style="margin:0px;">{{$tarefasProximas}}</h3>
                            <p class="text-white ml-2">Para esse Mês</p>
                            <div class="icon text-white">
                                <i class="fas fa-external-link-alt fa-xs text-white" style="font-size:50px;top:10px;"></i>
                            </div>   
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3 col-3">
                <div class="small-box bg-orange">
                    <a href="{{url('/admin/tarefas?ac=semana')}}">
                        <div>
                            <h3 class="text-white ml-2" style="margin:0px;">{{$tarefaSemana}}</h3>
                            <p class="text-white ml-2">Para Essa Semana</p>
                            <div class="icon text-white">
                                <i class="far fa-hand-point-right" style="font-size:50px;top:10px;"></i>
                            </div>   
                        </div>
                    </a>
                </div>
            </div>



    </div>
</div>

<section class="container-fluid mb-3">
    <div class="d-flex">            
        @foreach($etiquetas as $et)
            <div class="flex-fill border mr-2 rounded" style="background-color:#FFF0F5;">
                <a href='{{url("/admin/clientes?ac=etiquetas&id={$et->id}")}}'>
                    <div class="d-flex flex-column">
                        <h3 class="border-bottom border-dark text-center text-dark">{{$et->quantidade}}</h3>
                        <span class="border-bottom border-dark text-center  text-dark"><i><u>{{$et->nome}}</u></i></span>                    
                    </div>
                </a>    
            </div>
            @if($loop->last)
            <div class="flex-fill border rounded" style="background-color:#FFF0F5;">
                <div class="d-flex flex-column">
                    <h3 class="border-bottom border-dark text-center text-dark">{{$qtd_leads}}</h3>
                    <span class="border-bottom border-dark text-center text-dark"><i><u><a href="{{route('leads.prospeccao')}}" class="text-dark">Leads</a></u></i></span>                    
                </div>
            </div>
            @endif
        @endforeach
    </div>    
</section>


<div class="bg-dark d-flex justify-content-center rounded py-1 align-item-center mb-3 container-fluid">
    <h3 class="align-self-center">Clientes</h3>
</div>


<section class="container-fluid mt-3">
    <div class="d-flex">            
        
            <div class="small-box flex-fill mr-2 shadow bg-white" style="border:3px solid black;">
                <a href="{{route('financeiro.homeColaboradorAguardandoBoletoColetivo',auth()->user()->id)}}" class="text-dark">
                    <div class="d-flex justify-content-between">
                        <h3 class="ml-2">{{$aguardando_boleto_coletivo}}</h3>
                        <p class="align-self-center mr-2">R$ {{number_format($aguardando_boleto_coletivo_total,2,",",".")}}</p>                        
                    </div>
                    <h6 class="text-center" style="border-top:3px solid black;border-bottom:3px solid black;">Aguardando Boleto Coletivo</h6>
                    <div class="d-flex justify-content-end mr-2">
                        Vidas: &nbsp; <b>{{$aguardando_boleto_coletivo_vidas ?? 0}}</b>
                    </div>
                </a>    
            </div>
             
            <div class="small-box flex-fill mr-2 shadow bg-white" style="border:3px solid black;">
                <a href="{{route('financeiro.homeColaboradorAguardandoPagAdesaoColetivo',auth()->user()->id)}}" class="text-dark">
                    <div class="d-flex justify-content-between">
                        <h3 class="ml-2">{{$aguardando_pagamento_adesao_coletivo}}</h3>
                        <p class="align-self-center mr-2">R$ {{number_format($aguardando_pagamento_boleto_coletivo_total,2,",",".")}}</p>                        
                    </div>
                    <h6 class="text-center" style="border-top:3px solid black;border-bottom:3px solid black;">Aguardando Pag. Adesão Coletivo</h6>
                    <div class="d-flex justify-content-end mr-2">
                        Vidas: &nbsp; <b>{{$aguardando_pagamento_boleto_coletivo_vidas ?? 0}}</b>
                    </div>
                </a>    
            </div>

            <div class="small-box flex-fill mr-2 shadow bg-white" style="border:3px solid black;">
                <a href="{{route('financeiro.homeColaboradorAguardandoPagVigencia',auth()->user()->id)}}" class="text-dark">
                    <div class="d-flex justify-content-between border-bottom">
                        <h3>{{$aguardando_pagamento_vigencia}}</h3>
                        <p class="align-self-center mr-2">R$ {{number_format($aguardando_pagamento_vigencia_total,2,",",".")}}</p>                        
                    </div>  
                    <h6 class="text-center" style="border-top:3px solid black;border-bottom:3px solid black;">Aguardando Pag. Vigencia</h6>
                    <div class="d-flex justify-content-end mr-2">
                        Vidas: &nbsp; <b>{{$aguardando_pagamento_vigencia_vidas ?? 0}}</b>
                    </div>
                </a>    
            </div>


            <div class="small-box flex-fill mr-2 shadow bg-white" style="border:3px solid black;">
                <a href="{{route('financeiro.colaboradorPlanoindividual',auth()->user()->id)}}" class="text-dark">
                    <div class="d-flex justify-content-between">
                        <h3>{{$aguardando_individual_qtd}}</h3>
                        <p class="align-self-center mr-2">R$ {{number_format($aguardando_individual_total,2,",",".")}}</p>                        
                    </div>
                    <h6 class="text-center" style="border-top:3px solid black;border-bottom:3px solid black;">Aguardando Pag. Plano individual</h6>
                    <div class="d-flex justify-content-end mr-2">
                        Vidas: &nbsp; <b>{{$aguardando_individual_vidas ?? 0}}</b>
                    </div>
                </a>    
            </div>    

                

            <div class="small-box flex-fill mr-2 shadow bg-white" style="border:3px solid black;">
                <a href="{{route('financeiro.empresarialColaborador',auth()->user()->id)}}" class="text-dark">
                    <div class="d-flex justify-content-between">
                        <h3>{{$aguardando_pagamento_empresarial}}</h3>
                        <p class="align-self-center mr-2">R$ {{number_format($valor_aguardando_pagamento_empresarial,2,",",".")}}</p>                        
                    </div>
                    <h6 class="text-center" style="border-top:3px solid black;border-bottom:3px solid black;">
                        Aguardando Pag. Empresarial
                    </h6>
                    <div class="d-flex justify-content-end mr-2">
                        Vidas: &nbsp; <b>{{$qtd_vidas_aguardando_pagamento_empresarial}}</b>
                    </div>
                </a>
            </div>    

    </div>    
</section>

    <div class="container-fluid">
        <div class="d-flex">
                <div class="small-box bg-warning flex-fill mr-1">
                    <div class="inner">
                        <h3>{{$totalCliente ?? 0}}</h3>
                        <p>Total de Clientes</p>                        
                        <p>Vidas: {{$totalVidasQuantidade ?? 0}}</p>                        
                    </div>
                    <div class="icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <a href="{{route('clientes.index')}}" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            
                <div class="small-box bg-success flex-fill mr-1">
                    <div class="inner">
                        <h3>{{$totalClientesNegociados ?? 0}}</h3>
                        <p>Cliente Negociados</p>
                        <p>Vidas: {{$totalVidasClientesNegociados ?? 0}}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <a href="{{url('admin/contratos?ac=negociados')}}" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                        
                <div class="small-box bg-info flex-fill mr-1">
                    <div class="inner">
                        <h3>{{$totalClientesNegociacao ?? 0}}</h3>
                        <p>Em Negociação</p>
                        <p>Vidas: {{$vidasTotalClientesNegociacao ?? 0}}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <a href="{{url('admin/contratos?ac=negociacao')}}" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                        
                <div class="small-box bg-orange flex-fill mr-1">
                    <div class="inner">
                        <h3>{{$clientesCadastradosEsseMes}}</h3>
                        <p>Cadastrado no mês</p>
                        <p>Vidas: {{$clientesCadastradosEsseMesVidas}}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <a href="#" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            
                <div class="small-box bg-danger flex-fill">
                    <div class="inner">
                        <h3>0</h3>
                        <p>Perdidos</p>
                        <p>Vidas 8</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <a href="#" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>

        </div>
    </div>

    <div class="bg-dark d-flex justify-content-center rounded py-1 align-item-center mb-3">
        <h3 class="align-self-center">Referente ao mês de Agosto/2022</h3>
    </div>
 

    <section class="d-flex">

    
        <div class="info-box bg-dark flex-fill mr-2">
            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
            <div class="info-box-content">
                <div>
                    <span class="info-box-text">Total Vendido</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>                    
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">{{$totalVidasVendidas}}</span>
                        <span class="">Vidas</span>
                        <span>R$ {{number_format($totalVendido,2,",",".") ?? 0}}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">{{$totalVidasVendidasIndividual}}</span>
                        <span>Individual</span>
                        <span>R$ {{number_format($totalVendidoCotacaoIndividual,2,",",".") ?? 0}}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">{{$totalVidasVendidasColetivo}}</span>
                        <span>Coletivo</span>
                        <span>R$ {{number_format($totalVendidoCotacaoColetivo,2,",",".") ?? 0}}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">0</span>
                        <span>Empresarial</span>
                        <span>R$ 0,00</span>
                    </div>
                </div>
           </div>
        </div>
   


    
 
        <div class="info-box bg-navy flex-fill mr-2">
            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
            <div class="info-box-content">
                <div>
                    <span class="info-box-text">Comissões a Receber</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>                    
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".") ?? 0,00}}</span>
                        <span>Total</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissaoIndividual,2,",",".")}}</span>
                        <span>Individual</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissaoColetivo,2,",",".")}}</span>
                        <span>Coletivo</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ 0,00</span>
                        <span>Empresarial</span>
                    </div>
                </div>
           </div>
        </div>
  

        <div class="info-box bg-lightblue flex-fill mr-2">
            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
            <div class="info-box-content">
                <div>
                    <span class="info-box-text">Premiação a Receber</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>                    
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalPremiacao,2,",",".")}}</span>
                        <span>Total</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalPremiacaoIndividual,2,",",".")}}</span>
                        <span>Individual</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalPremiacaoColetivo,2,",",".")}}</span>
                        <span>Coletivo</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ 0,00</span>
                        <span>Empresarial</span>
                    </div>
                </div>
           </div>
        </div>
    
    
    
        <div class="info-box bg-olive flex-fill mr-2">
            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
            <div class="info-box-content">
                <div>
                    <span class="info-box-text">Total a Receber</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>                    
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalMes,2,",",".")}}</span>
                        <span>Total</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{ number_format($valorTotalValorMesIndividualTotal,2,",",".") }}</span>
                        <span>Individual</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($valorTotalColetivoQuantidade,2,",",".")}}</span>
                        <span>Coletivo</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ 0,00</span>
                        <span>Empresarial</span>
                    </div>
                </div>
           </div>
        </div>
    
    </section>

    <div class="bg-dark d-flex justify-content-center rounded py-1 align-item-center mb-3">
        <h3 class="align-self-center">Restante a Receber</h3>
    </div>

    <section class="d-flex">

    
        <div class="info-box bg-dark flex-fill mr-2">
            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
            <div class="info-box-content">
                <div>
                    <span class="info-box-text">Total Vendido</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>                    
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">{{$totalVidasVendidasRestante}}</span>
                        <span class="">Vidas</span>
                        <span>R$ {{number_format($totalVendidoRestante,2,",",".") ?? 0}}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">{{$totalVidasVendidasIndividualRestante}}</span>
                        <span>Individual</span>
                        <span>R$ {{number_format($totalVendidoCotacaoIndividualRestante,2,",",".") ?? 0}}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">{{$totalVidasVendidasColetivoRestante}}</span>
                        <span>Coletivo</span>
                        <span>R$ {{number_format($totalVendidoCotacaoColetivoRestante,2,",",".") ?? 0}}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">0</span>
                        <span>Empresarial</span>
                        <span>R$ 0,00</span>
                    </div>
                </div>
           </div>
        </div>
   


    
 
        <div class="info-box bg-navy flex-fill mr-2">
            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
            <div class="info-box-content">
                <div>
                    <span class="info-box-text">Comissões a Receber</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>                    
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissaoRestante,2,",",".") ?? 0}}</span>
                        <span>Total</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissaoIndividualRestante,2,",",".") ?? 0}}</span>
                        <span>Individual</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissaoColetivoRestante,2,",",".") ?? 0}}</span>
                        <span>Coletivo</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">0,00</span>
                        <span>Empresarial</span>
                    </div>
                </div>
           </div>
        </div>
  

        <div class="info-box bg-lightblue flex-fill mr-2">
            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
            <div class="info-box-content">
                <div>
                    <span class="info-box-text">Premiação a Receber</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>                    
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalPremiacaoRestante,2,",",".")}}</span>
                        <span>Total</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalPremiacaoIndividualRestante,2,",",".")}}</span>
                        <span>Individual</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalPremiacaoColetivoRestante,2,",",".")}}</span>
                        <span>Coletivo</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ 0,00</span>
                        <span>Empresarial</span>
                    </div>
                </div>
           </div>
        </div>
    
    
    
        <div class="info-box bg-olive flex-fill mr-2">
            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
            <div class="info-box-content">
                <div>
                    <span class="info-box-text">Total a Receber</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>                    
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissaoRestante,2,",",".") ?? 0}}</span>
                        <span>Total</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissaoIndividualRestante,2,",",".") ?? 0}}</span>
                        <span>Individual</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalVendidoCotacaoIndividualRestante,2,",",".") ?? 0}}</span>
                        <span>Coletivo</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ 0,00</span>
                        <span>Empresarial</span>
                    </div>
                </div>
           </div>
        </div>
    
    </section>



<!---------------- Começo Seção CLiente Tarefa ------------------------>
<section class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header text-white bg-dark ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="ion ion-clipboard mr-1"></i>
                    Lista de Tarefas
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table listartarefas">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Titulo</th>
                            <th>Dias Faltando</th>
                        </tr>
                    </thead>
                    <tbody></tbody>                  
                </table>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header text-white bg-dark ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="ion ion-clipboard mr-1"></i>
                    Lista de Clientes
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table listarclientes">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th align="center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
            </div>
           
        </div>
    </div>
</section>
<!---------------- FIM Seção CLiente Tarefa ------------------------>

<!---------------- Começo Comissao e  Premiação ------------------------>
<section class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header text-white bg-dark ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="ion ion-clipboard mr-1"></i>
                    Comissão a Receber
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table listarcomisao">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Administradora</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>  
                </table>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header text-white bg-dark ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="ion ion-clipboard mr-1"></i>
                    Lista de Premiações referente ao mes de {{date('M')}}
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table listarpremiacao">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Administradora</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">              
            </div>
        </div>
    </div>
</section>
<!---------------- Fim Comissao e  Premiação ------------------------>








@stop

@section('js')
    <script>
         $(document).ready(function(){
            // $(".fa-bars").on('click',function(){
                
            //     if($('body').hasClass('sidebar-collapse')) {
            //         $('body').removeClass('sidebar-mini');
            //         $('body').addClass('sidebar-hidden')
            //     } else {
            //         $('body').removeClass('sidebar-hidden');
            //         $('body').addClass('sidebar-mini')
            //     }
            // });



            $(".listartarefas").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('home.listarTarefasHome') }}",
                    "dataSrc": ""
                },
                "lengthMenu": [5,10,15],
                "ordering": true,
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                order: [[3, "asc"]],
                columns: [
                    {data:"data",name:"data"},
                    {data:"cliente",name:"cliente"},
                    {data:"title",name:"title"},
                    {data:"falta",name:"falta"},
                ],
                "columnDefs": [ {
                    "targets": 3,
                    "createdCell": function (td, cellData, rowData, row, col) {
                        if(cellData < 0) {
                            $(td).html('<div class="badge badge-dark w-50" style="font-size:1.1em">'+cellData+'</div>')
                        } else if(cellData <= 3) {
                            $(td).html('<div class="badge badge-danger w-50" style="font-size:1.1em">'+cellData+'</div>')  
                        } else if(cellData > 3 && cellData <= 10) {
                            $(td).html('<div class="badge badge-warning w-50" style="font-size:1.1em">'+cellData+'</div>')
                        } else {
                            $(td).html('<div class="badge badge-info w-50" style="font-size:1.1em">'+cellData+'</div>')
                        }
                       
                    
                    }
                }]
            });

            $(".listarclientes").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('home.listarClientesHome') }}",
                    "dataSrc": ""
                },
                "lengthMenu": [5,10,15],
                "ordering": true,
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                
                columns: [
                    {data:"data",name:"data"},
                    {data:"nome",name:"nome"},
                    {data:"telefone",name:"telefone"},
                    {data:"status",name:"status"},
                ],
                "columnDefs": [ {
                    "targets": 3,
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).html("<div style='width:20px;height:20px;border-radius:50%;background-color:"+cellData+"'></div>")
                       
                    
                    }
                }]
                
            });

            
            $(".listarcomisao").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('home.comissoes') }}",
                    "dataSrc": ""
                },
                "lengthMenu": [5,10,15],
                "ordering": true,
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                
                columns: [
                    {data:"data",name:"data",render:function(data, type, row, meta) {
                        return data.split("-").reverse().join("/")
                    }},
                    {data:"comissao.cliente.nome",name:"cliente"},
                    {data:"comissao.cotacao.administradora.nome",name:"administradora"},
                    {data:"valor",name:"valor",render:function(data,type,row,meta){
                        return parseFloat(data).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
                    }},
                ],
                
                
            });

            $('.listarpremiacao').DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('home.premiacoes') }}",
                    "dataSrc": ""
                },
                "lengthMenu": [5,10,15],
                "ordering": true,
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                
                columns: [
                    {data:"data",name:"data",render:function(data, type, row, meta) {
                        return data.split("-").reverse().join("/")
                    }},
                    {data:"comissao.cliente.nome",name:"cliente"},
                    {data:"comissao.cotacao.administradora.nome",name:"administradora"},
                    {data:"total",name:"total",render:function(data,type,row,meta){
                        return parseFloat(data).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
                    }},
                ],
                
                
            });



         });
    </script>
@stop        