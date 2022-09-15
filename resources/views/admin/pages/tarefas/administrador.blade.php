@extends('adminlte::page')

@section('title', 'Tarefas Corretores')
@section('content_header')
@stop

@section('content')
<h4 class="py-3 text-center">Tarefas</h4>
<ol class="breadcrumb py-3">
    <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Dashboard</a></li>
    <li class="breadcrumb-item">Tarefas</li>
</ol>


    
    <div class="row">
        @foreach($users as $u)
            
            <div class="col-4">
                <a href="{{route('tarefas.tarefasDetalhes',$u->id)}}">
                    <div class="card text-dark">
                        <div class="card-head border-bottom">
                            <div class="d-flex justify-content-around align-items-center"><h5 class="mt-1">{{$u->name}}</h5> <span>{{$u->tarefas_total}}</span></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 d-flex justify-content-between p-1"><span>Preço:</span> <b>{{$u->preco}}</b></div>
                                <div class="col-6 d-flex justify-content-between p-1"><span>Tem Plano:</span> <b>{{$u->ja_tem_plano}}</b></div>
                                <div class="col-6 d-flex justify-content-between p-1"><span>Fez Unimed:</span> <b>{{$u->fez_unimed}}</b></div>
                                <div class="col-6 d-flex justify-content-between p-1"><span>Sem Interesse:</span> <b>{{$u->sem_interesse}}</b></div>
                                <div class="col-6 d-flex justify-content-between p-1"><span>Total Clientes:</span> <b>{{$u->total_clientes}}</b></div>
                            </div>
                        </div>
                    </div>
                </a>  
            </div>
        @endforeach
    </div>
        
@stop
@section('js')


@stop

@section('css')
   
@stop
