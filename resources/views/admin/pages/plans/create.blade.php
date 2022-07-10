@extends('adminlte::page')

@section('title', 'Listar Planos')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('plano.index')}}">Listagem de Planos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cadastrar</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card">
        
        <div class="card-body">
            <form action="{{route('plano.store')}}" method="POST" action="">
                @csrf
                <div class="form-group">
                    <label for="nome">Plano</label>
                    <input type="text" name="nome" id="nome" class="form-control">
                    @if($errors->has('nome'))
                        <p class="alert alert-danger">{{$errors->first('nome')}}</p>
                    @endif
                </div>
                <input type="submit" value="Cadastrar" class="btn btn-primary btn-block">
            </form>
        </div>
    </div>
@stop
