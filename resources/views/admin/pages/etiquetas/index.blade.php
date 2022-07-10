@extends('adminlte::page')

@section('title', 'Listar Etiquetas')

@section('content_header')
    <h1>Cadastrar Etiquetas <a href="{{route('etiquetas.cadastrar')}}" class="btn btn-warning">
    <i class="fas fa-plus"></i>
    </a></h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            @if(count($etiquetas) >= 1)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Cor</th>
                            <th>Editar/Deletar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($etiquetas as $e)
                            <tr>
                                <td>{{$e->nome}} <span style="font-size:1.2em;font-weight:bold;">{{$e->padrao ? "*" : ""}}</span></td>
                                <td><div style="width:20px;height:20px;border-radius:50%;background-color:{{$e->cor}}"></div></td>
                                <td>
                                    <a href="{{route('etiquetas.edit',$e->id)}}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" onclick="document.getElementById('form_{{$e->id}}').submit()" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <form id="form_{{$e->id}}" action="{{route('etiquetas.destroy',$e->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endforeach
                    </tbody>
                </table>   
                 
            @else 
                <h5 class="py-3 text-center">Nenhuma etiqueta cadastrada!</h5>
            @endif
        </div>
    </div>
    
@stop