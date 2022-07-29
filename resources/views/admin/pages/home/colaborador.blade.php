@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('content_header')
    <h1>Dashboard - Corretor</h1>
@stop
@section('content_top_nav_right')

    <li class="nav-item"><a href="{{route('home.relatorio')}}" class="nav-link"><i class="fas fa-file-excel"></i>  </a></li> <!--Relatorio-->
    <li class="nav-item"><a href="{{route('admin.home.search')}}" class="nav-link">Tabela de Preços</a></li> <!--Consulta Rapida-->

@stop
@section('content')
<section class="content">

<div class="container-fluid">
    <div class="row">

            <div class="col-md-3 col-3">
                <div class="small-box bg-info shadow-lg">
                    <a href="{{url('/admin/clientes?ac=hoje')}}">
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
                    <a href="{{url('/admin/clientes?ac=atrasado')}}">
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
                    <a href="{{url('/admin/clientes?ac=proximas')}}">
                        <div>
                            <h3 class="text-white ml-2" style="margin:0px;">{{$tarefasProximas}}</h3>
                            <p class="text-white ml-2">Tarefas proximos 03 dias</p>
                            <div class="icon text-white">
                                <i class="fas fa-external-link-alt fa-xs text-white" style="font-size:50px;top:10px;"></i>
                                
                            </div>   
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3 col-3">
                <div class="small-box bg-orange">
                    <a href="{{url('/admin/clientes?ac=semtarefa')}}">
                        <div>
                            <h3 class="text-white ml-2" style="margin:0px;">{{$clientesSemTarefas}}</h3>
                            <p class="text-white ml-2">Sem Tarefas</p>
                            <div class="icon text-white">
                                <i class="far fa-frown fa-xs text-white" style="font-size:50px;top:10px;"></i>
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
            <div class="flex-fill border mr-2 bg-navy rounded">
                <div class="d-flex flex-column">
                    <h3 class="text-white border-bottom text-center">{{$et->quantidade}}</h3>
                    <span class="text-white border-bottom text-center"><i><u><a href='{{url("/admin/clientes?ac=etiquetas&id={$et->id}")}}' class="text-white">{{$et->nome}}</a></u></i></span>                    
                </div>
            </div>
            @if($loop->last)
            <div class="flex-fill border bg-navy rounded">
                <div class="d-flex flex-column">
                    <h3 class="text-white text-center border-bottom">18</h3>
                    <span class="text-white border-bottom text-center"><i><u><a href="#" class="text-white">Leads</a></u></i></span>                    
                </div>
            </div>
            @endif
        @endforeach
    </div>    
</section>


<div class="bg-dark d-flex justify-content-center rounded py-1 align-item-center mb-3 container-fluid">
    <h3 class="align-self-center">Clientes</h3>
</div>


<section class="container-fluid mb-3">
    <div class="d-flex">            
        
        
            <div class="small-box bg-info flex-fill mr-2">
                <div class="d-flex justify-content-between border-bottom">
                    <h3>8</h3>
                    <p class="align-self-center">R$ 1000,00</p>                        
                </div>
                <h6 class="text-center border-bottom">Aguardando Boleto Coletivo</h6>
                <div class="d-flex justify-content-end">
                    Vidas 9
                </div>
            </div>
             
            <div class="small-box bg-info flex-fill mr-2">
                <div class="d-flex justify-content-between border-bottom">
                    <h3>8</h3>
                    <p class="align-self-center">R$ 1000,00</p>                        
                </div>
                <h6 class="text-center border-bottom">Aguardando Pag. Adesão Coletivo</h6>
                <div class="d-flex justify-content-end">
                    Vidas 9
                </div>
            </div>

            <div class="small-box bg-info flex-fill mr-2">
                <div class="d-flex justify-content-between border-bottom">
                    <h3>8</h3>
                    <p class="align-self-center">R$ 1000,00</p>                        
                </div>
                <h6 class="text-center border-bottom">Aguardando Pag. Plano individual</h6>
                <div class="d-flex justify-content-end">
                    Vidas 12
                </div>
            </div>    

            <div class="small-box bg-info flex-fill mr-2">
                <div class="d-flex justify-content-between border-bottom">
                    <h3>8</h3>
                    <p class="align-self-center">R$ 1000,00</p>                        
                </div>
                <h6 class="text-center border-bottom">Aguardando Pag. Vigencia</h6>
                <div class="d-flex justify-content-end">
                    Vidas 12
                </div>
            </div>    

            <div class="small-box bg-info flex-fill mr-2">
                <div class="d-flex justify-content-between border-bottom">
                    <h3>8</h3>
                    <p class="align-self-center">R$ 1000,00</p>                        
                </div>
                <h6 class="text-center border-bottom">Aguardando Pag. Empresarial</h6>
                <div class="d-flex justify-content-end">
                    Vidas 10
                </div>
            </div>    

    </div>    
</section>





    <div class="container-fluid">
        <div class="d-flex">

            
                <div class="small-box bg-warning flex-fill mr-1">
                    <div class="inner">
                        <h3>{{$totalCliente}}</h3>
                        <p>Total de Clientes</p>                        
                        <p>Vidas 25</p>                        
                    </div>
                    <div class="icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <a href="#" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            

            
                <div class="small-box bg-success flex-fill mr-1">
                    <div class="inner">
                        <h3>{{$clienteFechados}}</h3>
                        <p>Cliente Negociados</p>
                        <p>Vidas 12</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <a href="{{route('contratos.index')}}" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            

            
                <div class="small-box bg-info flex-fill mr-1">
                    <div class="inner">
                        <h3>{{$clienteFechados}}</h3>
                        <p>Em Negociação</p>
                        <p>Vidas 12</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <a href="{{route('contratos.index')}}" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            

            
                <div class="small-box bg-orange flex-fill mr-1">
                    <div class="inner">
                        <h3>{{$clienteFechados}}</h3>
                        <p>Cadastrado no mês</p>
                        <p>Vidas 11</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <a href="{{route('contratos.index')}}" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            

            
                <div class="small-box bg-danger flex-fill">
                    <div class="inner">
                        <h3>{{$clienteFechados}}</h3>
                        <p>Perdidos</p>
                        <p>Vidas 8</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <a href="{{route('contratos.index')}}" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            
            



        </div>
    </div>

    <div class="bg-dark d-flex justify-content-center rounded py-1 align-item-center mb-3">
        <h3 class="align-self-center">Referente ao mês de Julho/2022</h3>
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
                        <span class="info-box-number">20</span>
                        <span class="">Vidas</span>
                        <span>R$ 5.000,00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">6</span>
                        <span>Individual</span>
                        <span>R$ 1000,00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">14</span>
                        <span>Coletivo</span>
                        <span>R$ 4000,00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">14</span>
                        <span>Empresarial</span>
                        <span>R$ 4000,00</span>
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
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                        <span>Total</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                        <span>Individual</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                        <span>Coletivo</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
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
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                        <span>Total</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                        <span>Individual</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                        <span>Coletivo</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
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
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                        <span>Total</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                        <span>Individual</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                        <span>Coletivo</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
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
                        <span class="info-box-number">20</span>
                        <span class="">Vidas</span>
                        <span>R$ 5.000,00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">6</span>
                        <span>Individual</span>
                        <span>R$ 1000,00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">14</span>
                        <span>Coletivo</span>
                        <span>R$ 4000,00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">14</span>
                        <span>Empresarial</span>
                        <span>R$ 4000,00</span>
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
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                        <span>Total</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                        <span>Individual</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                        <span>Coletivo</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
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
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                        <span>Total</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                        <span>Individual</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                        <span>Coletivo</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
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
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                        <span>Total</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                        <span>Individual</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                        <span>Coletivo</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
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