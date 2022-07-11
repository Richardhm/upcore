@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('content')
<section class="content">
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
                    <a href="#" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            

            
        </div>
    </div>
</section> 

<section class="row">
    @foreach($etiquetas as $et)
        <div class="col-md-3 col-sm-6 col-12">
            
            <div class="info-box shadow">
                <span class="info-box-icon border border-dark">
                    <div style="width:20px;height:20px;border-radius:50%;background-color:{{$et->cor}}"></div> 
                </span>
                <div class="info-box-content">
                    <span class="info-box-text"><i><u><a href="{{route('home.listarPorEtiquetaEspecifica',$et->id)}}" class="text-dark">{{$et->nome}}</a></u></i></span>
                    
                    <span class="info-box-number">Quantidade: {{$et->quantidade}}</span>
                </div>
            </div>
        </div>
    @endforeach

</section>


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
                <ul class="todo-list ui-sortable" data-widget="todo-list">
                    @if(count($tarefas) >= 1)
                        <div class="d-flex justify-content-between">
                            <span>Data</span>
                            <span>Cliente</span>
                            <span>Titulo</span>
                        </div>
                        @foreach($tarefas as $tt)
                        <li>
                            <div class="icheck-primary d-inline ml-2">
                                {{date("d/m/Y",strtotime($tt->data))}}
                            </div>
                            <span class="text">{{$tt->title}}</span>
                            <small class="badge badge-danger"><i class="far fa-clock"></i> 2 minutos</small>
                            <div class="tools">
                                <i class="fas fa-edit"></i>
                                <i class="fas fa-trash-o"></i>
                            </div>
                        </li>



                        @endforeach

                    @endif
                
                
                </ul>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col">
                        <ul class="pagination">
                            <li class="page-item"><a href="#" class="page-link">«</a></li>
                            @for($i=1;$i<=$tarefas->lastPage();$i++)
                            <li class="page-item {{$i == $tarefas->currentPage() ? 'active' : ''}}">
                                <a class="page-link" href="{{isset($filtro) && count($filtro) >= 1 ? $tarefas->appends($filtro)->url($i) : $tarefas->url($i)}}">{{$i}}</a>
                            </li>
                            @endfor
                           
                           
                            <li class="page-item"><a href="#" class="page-link">»</a></li>
                        </ul>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-primary float-right">Ver Todas</button>
                    </div>
                </div>
                
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
                <table class="table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th align="center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $c)
                            <tr>
                                <td>{{date('d/m/Y',strtotime($c->created_at))}}</td>
                                <td>{{$c->nome}}</td>
                                <td>{{$c->telefone}}</td>
                                <td align="center"><div style="width:20px;height:20px;border-radius:50%;background-color:{{$c->status}}"></div></td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <ul class="pagination justify-content-center">
                    <li class="page-item"><a href="#" class="page-link">«</a></li>
                    @for($ii=1;$ii<=$clientes->lastPage();$ii++)
                        <li class="page-item {{$ii == $clientes->currentPage() ? 'active' : ''}}">
                            <a class="page-link" href="{{isset($filtro) && count($filtro) >= 1 ? $clientes->appends($filtro)->url($ii) : $clientes->url($ii)}}">{{$ii}}</a>
                        </li>
                    @endfor
                    <li class="page-item"><a href="#" class="page-link">»</a></li>
                </ul>
                
            </div>
        </div>
    </div>




   


    
</section>








@stop
@section('js')
    <script>
         $(document).ready(function(){
          
         });
    </script>
@stop        