@extends('adminlte::page')

@section('title', 'Cadastrar Etiquetas')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('etiquetas.index')}}">Listar Etiquetas</a></li>
        <li class="breadcrumb-item">Cadastrar</li>
    </ol>    
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            <form action="{{route('etiquetas.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" class="form-control" value="{{old('nome')}}">
                    @if($errors->has('nome'))
                        <p class="alert alert-danger">{{$errors->first('nome')}}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="cor">Cor:</label>
                    <input type="color" name="cor" id="cor">
                    @if($errors->has('cor'))
                        <p class="alert alert-danger">{{$errors->first('cor')}}</p>
                    @endif
                </div>
               
                <input type="submit" value="Cadastrar" class="btn btn-primary btn-block">
            </form>   
        </div>
    </div>




@stop
