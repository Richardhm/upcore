@extends('adminlte::page')
@section('title', 'Listar Corretores')
@section('content_header')
    <h1>Cadastrar Corretores: <a href="{{route('corretores.create')}}" class="btn btn-warning">
    <i class="fas fa-plus"></i>
    </a></h1>
@stop
@section('content')
    <div class="card">
        @if(count($corretores) >= 1)

            <div class="card-header"></div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Comissões</th>
                            <th>Premiações</th>
                            <th>Editar/Deletar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($corretores as $c)
                            <form id="form_{{$c->id}}" action="{{route('corretores.destroy',$c->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>    
                            <tr>
                                <td>{{$c->name}}</td>
                                <td><a href="{{route('comissao.corretores.index',$c->id)}}"><i class="fas fa-money-check-alt"></i></a></td>
                                <td><i class="fas fa-money-check-alt"></i></td>
                                <td>
                                    <a href="{{route('corretores.edit',$c->id)}}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" onclick="document.getElementById('form_{{$c->id}}').submit()" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>  
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        @else 
            <h5 class="py-3 text-center">Sem Corretores cadastrado ainda!</h5>
        @endif
    
    
                    
        
    </div>
@stop