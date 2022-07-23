@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.Datatables', true)
@section('content_header')
    <h1>Dashboard - Administrador</h1>
@stop

@section('content')

<section class="content">


    <div class="container-fluid">
        <div class="row">

            <div class="col-md-3 col-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>0</h3>
                        <p>Total de Clientes</p>                        
                    </div>
                    <div class="icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <a href="#" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-md-3 col-3">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>0</h3>
                        <p>Cliente Negociados</p>
                       
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <a href="{{route('contratos.index')}}" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-md-3 col-3">
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3 class="text-white">0</h3>
                        <p class="text-white">Tarefa(s) para os proximos 03 dias</p>
                       
                    </div>
                    <div class="icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <a href="{{route('cliente.tarefas.proximas')}}" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-md-3 col-3">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 class="text-white">0</h3>
                        <p class="text-white">Tarefa(s) Atrasada</p>
                       
                    </div>
                    <div class="icon">
                        <i class="fas fa-thumbs-down"></i>
                    </div>
                    <a href="{{route('tarefa.clienteTarefasAtrasadasHome')}}" class="small-box-footer">Saiba Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>



        </div>
    </div>
</section> 

<section class="row">
    
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-navy">
            <span class="info-box-icon"><i class="far fa-bookmark"></i></span>
            <div class="info-box-content">
                <span class="info-box-number">R$ 000</span>
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
                <span class="info-box-number">R$ 00</span>
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
                <span class="info-box-number">00</span>
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
            <span class="info-box-icon"><i class="fas fa-user"></i></span>
            <div class="info-box-content">
                <span class="info-box-number">00</span>
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
    
</section>

<section>
    
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Funcionarios</h3>
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


                        <a class="users-list-name" href="{{route('home.administrador.colaborador',$c->id)}}"  target="_blank">{{$c->name}}</a>
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

    </div>
</section>









@stop
@section('js')
    <script src="{{asset('vendor/jquery-ui/jquery-ui.min.js')}}"></script>   
    <script>
        $(document).ready(function(){
        });
    </script>
    <script src="{{asset('js/dashboard.js')}}"></script>  
@stop