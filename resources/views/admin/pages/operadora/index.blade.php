@extends('adminlte::page')

@section('title', 'Listar Operadora')

@section('content_header')
    <h1>Cadastrar Operadora <a href="{{route('operadora.create')}}" class="btn btn-warning">
    <i class="fas fa-plus"></i>
    </a></h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            @if(count($operadoras) >= 1)
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Editar/Deletar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($operadoras as $op)    
                        <form id="form_{{$op->id}}" action="{{route('operadora.destroy',$op->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                        <tr>
                            <td>{{$op->nome}}</td>     
                            <td>
                                <a href="{{route('operadora.edit',$op->id)}}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="#" onclick="document.getElementById('form_{{$op->id}}').submit()" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <h5 class="py-3 text-center">Nenhuma Operadora cadastrada!</h5>
            @endif
        </div>
    </div>




@stop
