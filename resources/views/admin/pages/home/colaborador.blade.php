@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('content_top_nav_right')

    <li class="nav-item"><a href="{{route('home.relatorio')}}" class="nav-link"><i class="fas fa-file-excel"></i>  </a></li> <!--Relatorio-->
    <li class="nav-item"><a href="{{route('admin.home.search')}}" class="nav-link"><i class="fas fa-search"></i></a></li> <!--Consulta Rapida-->

@stop



@section('content')
<section class="content">

    @if(count($tarefasProximas) >= 1)
        <p class="alert bg-primary text-center">
            Você tem {{count($tarefasProximas)}} tarefa(s) para os proximos 03 dias
            <a href="{{route('cliente.tarefas.proximas')}}" class="ml-4"><i class="fas fa-asterisk"></i>Clique Aqui</a>
        </p>
    @endif

    

    @if(count($tarefasAtrasadas) >= 1)
        <p class="alert bg-danger disabled text-center">
        Você tem {{count($tarefasAtrasadas)}} tarefa(s) Atrasada
         <a href="{{route('tarefa.clienteTarefasAtrasadasHome')}}" class="ml-4"><i class="fas fa-asterisk"></i>Clique Aqui</a>
        </p>
    @endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{$totalCliente}}</h3>
                        <p>Total de Clientes</p>
                        
                    </div>
                    <div class="icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <a href="#" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-6 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{$clienteFechados}}</h3>
                        <p>Cliente Negociados</p>
                       
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <a href="{{route('contratos.index')}}" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            

            
        </div>
    </div>
</section> 

<div class="row">
    
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-navy">
            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
            <div class="info-box-content">
                <span class="info-box-number">R$ {{number_format($totalComissao,2,",",".")}}</span>
                <span class="info-box-text">Comissões a Receber</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                    
                </div>
                <span class="progress-description">
                    Referente ao mês {{date('M')}}
                </span>
                
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-lightblue">
            <span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>
            <div class="info-box-content">
                <span class="info-box-number">R$ {{number_format($totalPremiacao,2,",",".")}}</span>
                <span class="info-box-text">Premiações a Receber</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                    
                </div>
                <span class="progress-description">
                    Referente ao mês {{date('M')}}
                </span>
               
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-olive">
            <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-number">{{number_format($totalMes,2,",",".")}}</span>
                <span class="info-box-text">Total a Receber</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                    
                </div>
                <span class="progress-description">
                    Referente ao mês {{date('M')}}
                </span>    
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-gray-dark">
            <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-number">{{$totalVidas}}</span>
                <span class="info-box-text">Total Vidas</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                    
                </div>
                <span class="progress-description">
                    Referente ao mês {{date('M')}}
                </span>    
            </div>
        </div>
    </div>
    

</div>


<section class="row">
    @foreach($etiquetas as $et)
        <div class="col-md-3 col-sm-6 col-12">
            
            <div class="info-box shadow">
                <span class="info-box-icon border border-dark" style="background-color:{{$et->cor}}">
                    
                </span>
                <div class="info-box-content">
                    <span class="info-box-text"><i><u><a href="{{route('home.listarPorEtiquetaEspecifica',$et->id)}}" class="text-dark">{{$et->nome}}</a></u></i></span>
                    
                    <span class="info-box-number">Quantidade: {{$et->quantidade}}</span>
                </div>
            </div>
        </div>
    @endforeach
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