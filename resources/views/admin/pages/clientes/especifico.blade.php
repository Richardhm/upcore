@extends('adminlte::page')
@section('title', 'Contrato')
@section('content_header')
    <h3>Tarefas</h3>
@stop
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('clientes.index')}}">Listar Clientes</a></li>
        <li class="breadcrumb-item">Tarefas do cliente <b>{{$cliente}}</b></li>
    </ol>   
    @if(count($tarefas) >= 1)
        <div class="card">
            <div class="card-body">
            <table class="table">
            <thead>
                <tr>
                    <th>Titulo</th>
                    <th>Descrição</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tarefas as $tt)
                <tr>
                    <td>{{$tt->title}}</td>
                    <td>{{$tt->descricao}}</td>
                    <td>{{date("d/m/Y",strtotime($tt->data))}}</td>
                </tr>   
                @endforeach
            </tbody>
        </table>
            </div>

        </div>
    @else
        <h3 class="bg-secondary py-2 text-center rounded">Este Cliente não possui tarefas cadastradas</h3>
    @endif






  

@stop   
@section('js')

@stop
@section('css')
  


     
@stop
