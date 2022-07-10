@extends('adminlte::page')

@section('title', 'Editar Etiqueta')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('etiquetas.index')}}">Listar Etiquetas</a></li>
        <li class="breadcrumb-item">Editar</li>
    </ol>    
@stop

@section('content')
    <div class="card">
        <div class="card-header"></div>
        <div class="card-body">
            <form action="{{route('etiquetas.update',$etiqueta->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" class="form-control" value="{{$etiqueta->nome}}">
                </div>
                <input type="submit" value="Editar" class="btn btn-primary btn-block">
            </form>   
        </div>
    </div>




@stop
