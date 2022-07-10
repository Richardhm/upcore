@extends('adminlte::page')

@section('title', 'Listar Administradores')

@section('content_header')
    <h1>Administradoras: <a href="{{route('administradora.create')}}" class="btn btn-warning">
    <i class="fas fa-plus"></i>
    </a></h1>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            @if(count($administradoras) >= 1) 
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Editar/Deletar</th>
                        </tr>    
                    </thead>
                    <tbody>
                        @foreach($administradoras as $a)
                            <form id="form_{{$a->id}}" action="{{route('administradora.destroy',$a->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                            <tr>
                                <td>{{$a->nome}}</td>
                                <td>
                                    <a href="{{route('administradora.edit',$a->id)}}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a onclick="document.getElementById('form_{{$a->id}}').submit()" href="#" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h5 class="py-3 text-center">Nenhuma Administradoras cadastrada!</h5>
            @endif
        </div>
    </div>
    


@stop
