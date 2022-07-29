@extends('adminlte::page')

@section('title', 'Listar Etiquetas')

@section('content_header')
  
        <a href="{{url()->previous()}}" class="text-dark"><i class="fas fa-arrow-left fa-lg"></i></a>
     
@stop

@section('content')
    <div class="card">
    <table class="table table-striped table-bordered table-hover">
    <caption>Usuarios status <b>{{$nome}}</b></caption>
    <thead class="thead-dark">
            <tr>
                <th>Data</th>
                <th>Nome</th>
                <th>Cidade</th>
                <th>Telefone</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $c)
                <tr>
                    <td>{{date("d/m/Y",strtotime($c->created_at))}}</td>
                    <td>{{$c->nome}}</td>
                    <td>{{$c->cidade->nome}}</td>
                    <td>{{$c->telefone}}</td>
                    <td>{{$c->email}}</td>
                </tr>
            @endforeach
        </tbody>
   </table>
    </div>
   
    
@stop

@section('js')
    <script>
        $(function(){
            $('body').addClass('sidebar-hidden')
        })
    </script>
    
@stop