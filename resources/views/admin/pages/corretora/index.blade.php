@extends('adminlte::page')

@section('title', 'Corretora')

@section('content_header')
    <h1>Corretora</h1>
@stop

@section('content')
    <div class="card">
        
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$corretora->nome}}</td>
                    <td>
                        <a href="{{route('corretora.edit',$corretora->id)}}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
            </tbody>    
        </table>

    </div>
@stop
