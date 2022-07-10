@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('content_header')
    <h1>Dashbord</h1>
@stop

@section('content')


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        
                        <h3>{{$orcamentosAll}}</h3>
                        <p class="d-flex"><span class="mr-auto">Orçamentos Realizados</span> <span style="font-size:0.8em;font-weight:bold;">Hoje: {{$orcamentosHoje}}</span></p>
                        
                       
                    </div>
                    <div class="icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <a href="#" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{$contratosAll}}</h3>
                        <p class="d-flex"><span class="mr-auto">Contratos Realizados</span> <span style="font-size:0.8em;font-weight:bold;">Hoje: {{$contratosHoje}}</span></p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <a href="#" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{count($corretores)}}</h3>
                        <p>Nossos Corretores</p>
                    </div>
                    <div class="icon">
                     
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="{{route('corretores.index')}}" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$cidades}}</h3>
                        <p>Cidades onde estamos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-city"></i>
                    </div>
                    <a href="{{route('cidades.index')}}" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>    

<!--Orcamentos-->

    <section class="row">
       <div class="col">
            <div class="card">
                <div class="card-header border-bottom bg-gray-dark disabled color-palette">
                    <h3 class="card-title">Meus Orçamentos</h3>
                    <div class="card-tools">
                        
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered myorcamentos">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <!-- <th>Adminstradora</th> -->
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                    
                        </tbody>
                    </table>            
                </div>
            </div>
       </div>     
       <div class="col">
            <div class="card">
                <div class="card-header border-bottom bg-gray-dark disabled color-palette">
                    <h3 class="card-title">Orçamentos Corretores</h3>
                    <div class="card-tools">
                        
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>    




                <div class="card-body">
                    <table class="table table-bordered outherorcamentos">
                        <thead>
                            <tr>
                                
                                <th>Cliente</th>
                                <th>Corretor</th>
                                
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                    
                        </tbody>
                    </table>       
    
                </div>
            </div>
       </div>     
    </section>

<!--Fim Orcamento-->    
   
<!--Corretores-->
<section class="row">
    
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Nossos Colaboradores</h3>
                <div class="card-tools">
                    <span class="badge badge-danger">{{count($corretores)}} Membros</span>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="users-list clearfix">
                    @php
                        $t = new \App\Support\Thumb();
                    @endphp
                    @foreach($corretores as $c)
                    <li>
                        @if(!empty($c->image)) 
                        <img src="{{\Illuminate\Support\Facades\Storage::url($t->makes($c->image,100,100))}}" alt="User Image">
                        @else
                        <img src="{{\Illuminate\Support\Facades\Storage::url('avatar-default.jpg')}}" width="100" height="100" alt="User Image">
                        @endif
                        
                        <a class="users-list-name" href="{{route('corretores.edit',$c->id)}}"  target="_blank">{{$c->name}}</a>
                        <span class="users-list-date">{{date('d/m/Y',strtotime($c->created_at))}}</span>
                    </li>
                    @endforeach
                    
                </ul>
            </div>
            <div class="card-footer text-center">
                <a href="{{route('corretores.index')}}" target="_blank">Visualizar Todos</a>
            </div>
        </div>
    </div>
    
    
    
    <div class="col-4">
    <div class="info-box">
        <span class="info-box-icon bg-success"><i class="far fa-envelope"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Campeão Do Dia: Richard</span>
            <span class="info-box-number">Vidas: 10</span>
        </div>
    </div>
    </div>
</section>
<!--Fim Corretores-->


<section class="row">
    <div class="col">
    <div class="card">
        <div class="card-header ui-sortable-handle" style="cursor: move;">
            <h3 class="card-title">
                <i class="ion ion-clipboard mr-1"></i>
                Lista de Tarefas
            </h3>
            <div class="card-tools">
                <ul class="pagination pagination-sm">
                    <li class="page-item"><a href="#" class="page-link">«</a></li>
                    <li class="page-item"><a href="#" class="page-link">1</a></li>
                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                    <li class="page-item"><a href="#" class="page-link">3</a></li>
                    <li class="page-item"><a href="#" class="page-link">»</a></li>
                </ul>
            </div>
        </div>

        <div class="card-body">
            <ul class="todo-list ui-sortable" data-widget="todo-list">

                <li>

                    <span class="handle ui-sortable-handle">
                        <i class="fas fa-ellipsis-v"></i>
                        <i class="fas fa-ellipsis-v"></i>
                    </span>

                    <div class="icheck-primary d-inline ml-2">
                        <input type="checkbox" value="" name="todo1" id="todoCheck1">
                        <label for="todoCheck1"></label>
                    </div>

                    <span class="text">Reunião Marcada</span>

                    <small class="badge badge-danger"><i class="far fa-clock"></i> 2 minutos</small>

                    <div class="tools">
                        <i class="fas fa-edit"></i>
                        <i class="fas fa-trash-o"></i>
                    </div>
                </li>
            
                <!-- <li class="done"> -->
                <li>
                    <span class="handle ui-sortable-handle">
                        <i class="fas fa-ellipsis-v"></i>
                        <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div class="icheck-primary d-inline ml-2">
                        <input type="checkbox" value="" name="todo2" id="todoCheck2">
                        <label for="todoCheck2"></label>
                    </div>
                    <span class="text">Falar Com Fulano</span>
                    <small class="badge badge-info"><i class="far fa-clock"></i> 4 horas</small>
                    <div class="tools">
                        <i class="fas fa-edit"></i>
                        <i class="fas fa-trash-o"></i>
                    </div>
                </li>
            
                <li>
                    <span class="handle ui-sortable-handle">
                        <i class="fas fa-ellipsis-v"></i>
                        <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div class="icheck-primary d-inline ml-2">
                        <input type="checkbox" value="" name="todo3" id="todoCheck3">
                        <label for="todoCheck3"></label>
                    </div>
                    <span class="text">Reunião com a Allcare</span>
                        <small class="badge badge-warning"><i class="far fa-clock"></i> 1 dia</small>
                        <div class="tools">
                            <i class="fas fa-edit"></i>
                            <i class="fas fa-trash-o"></i>
                        </div>
                </li>

                <li>
                    <span class="handle ui-sortable-handle">
                        <i class="fas fa-ellipsis-v"></i>
                        <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div class="icheck-primary d-inline ml-2">
                        <input type="checkbox" value="" name="todo4" id="todoCheck4">
                        <label for="todoCheck4"></label>
                    </div>
                    <span class="text">Pagamento de Funcionarios</span>
                        <small class="badge badge-success"><i class="far fa-clock"></i> 10 dias</small>
                        <div class="tools">
                            <i class="fas fa-edit"></i>
                            <i class="fas fa-trash-o"></i>
                        </div>
                </li>

                <li>
                    <span class="handle ui-sortable-handle">
                        <i class="fas fa-ellipsis-v"></i>
                        <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div class="icheck-primary d-inline ml-2">
                        <input type="checkbox" value="" name="todo5" id="todoCheck5">
                        <label for="todoCheck5"></label>
                    </div>
                    <span class="text">Receber Pagamento de Administradora</span>
                    <small class="badge badge-primary"><i class="far fa-clock"></i> 1 Semana</small>
                    <div class="tools">
                        <i class="fas fa-edit"></i>
                        <i class="fas fa-trash-o"></i>
                    </div>
                </li>

                <li>
                    <span class="handle ui-sortable-handle">
                        <i class="fas fa-ellipsis-v"></i>
                        <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <div class="icheck-primary d-inline ml-2">
                        <input type="checkbox" value="" name="todo6" id="todoCheck6">
                        <label for="todoCheck6"></label>
                    </div>
                    <span class="text">Conferir Contabilidade</span>
                    <small class="badge badge-secondary"><i class="far fa-clock"></i> 1 mês</small>
                    <div class="tools">
                        <i class="fas fa-edit"></i>
                        <i class="fas fa-trash-o"></i>
                    </div>
                </li>
            </ul>
        </div>

        <div class="card-footer clearfix">
            <button type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add item</button>
        </div>
    </div>

    </div>


   


    
</section>



<section class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header"><h2>A pagar:</h2></div>
            <div class="card-body">
                <table class="table comisaoapagar">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Corretor</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" style="text-align:right">Total:</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    <div class="col-6">
        <div class="card">
            <div class="card-header"><h2>A Receber:</h2></div>
            <div class="card-body">
                <table class="table areceber">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Corretor</th>
                            <th>Valor</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                    
                </table>
            </div>
        </div>

    </div>
</section>











@stop
@section('js')
    <script src="{{asset('vendor/jquery-ui/jquery-ui.min.js')}}"></script>   
    <script>
        $(document).ready(function(){

            $(".myorcamentos").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('admin.orcamentos') }}",
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
                    {data:"cliente",name:"cliente"},
                    {data:"quantidade",name:"quantidade"}
                ]
            });

            $(".outherorcamentos").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('admin.outherorcamentos') }}",
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
                    {data:"cliente",name:"cliente"},
                    {data:"corretor",name:"corretor"},
                ]
            });

            
            $(".comisaoapagar").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('comissoes.apagar') }}",
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
                    {data:"corretor",name:"corretor"},
                    {data:"valor",name:"valor"},
                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();
                    var intVal = function (i) {
                        return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                    };
 
                    total = this.api()
                        .column(2)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                        console.log(total);
                        $(api.column(2).footer()).html(total);    
                }
                
            });

            

            

            $(".areceber").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('comissoes.areceber') }}",
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
                    {data:"corretor",name:"corretor"},
                    {data:"valor",name:"valor"},
                ]
            });



        });
    </script>
    <script src="{{asset('js/dashboard.js')}}"></script>  
@stop