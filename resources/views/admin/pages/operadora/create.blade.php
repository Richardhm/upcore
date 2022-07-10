@extends('adminlte::page')

@section('title', 'Cadastrar Operadora')

@section('content_header')
    <h1>Cadastrar Operadora</h1>
@stop

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('operadora.index')}}">Listar Operadoras</a></li>
    <li class="breadcrumb-item">Cadastrar</li>
</ol>
<div class="card">
        <div class="card-header">
            <strong>*</strong> <small>Campo Obrigatorio</small>             
        </div>
        <div class="card-body">
           <form action="{{route('operadora.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                    <label for="nome">Nome*</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="{{old('nome')}}">
                    @if($errors->has('nome'))
                        <p class="alert alert-danger">{{$errors->first('nome')}}</p>
                    @endif
            </div>
            
            <div class="form-group">
                <label for="logo">Logo: *</label>
                <input type="file" class="form-control" id="logo" name="logo">
                @if($errors->has('logo'))
                    <p class="alert alert-danger">{{$errors->first('logo')}}</p>
                @endif
            </div>

           
           
            <button class="btn btn-primary btn-block" type="submit">Cadastrar Operadora</button>
           </form>
    




@stop
