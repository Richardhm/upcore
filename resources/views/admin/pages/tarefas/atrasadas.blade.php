@extends('adminlte::page')

@section('title', 'Clientes Corretores')
@section('plugins.FullCalendar', true)

@section('content_header')
<div class="card-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Sua Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Proximas Tarefas </li>
            </ol>
        </nav>
    </div>  
@stop

@section('content')
   
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Titulo</th>
                        <th>Descrição</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($tarefas as $t)
                    <tr>
                        <td>{{$t->cliente->nome}}</td>
                        <td>{{date("d/m/Y",strtotime($t->data))}}</td>
                        <td>{{$t->title}}</td>
                        <td>{{$t->descricao}}</td>
                        
                    </tr>
                    @endforeach

                </tbody>
            </table>

        </div>   
    <div>

    
    

   
@stop
@section('js')



@stop

@section('css')
   
@stop
