@extends('adminlte::page')

@section('title', 'Editar Operadora')

@section('content_header')
    <h1>Editar Operadora</h1>
@stop

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('operadora.index')}}">Listar Operadoras</a></li>
    <li class="breadcrumb-item">Editar</li>
</ol>
<div class="card">
    <div class="card-header">
        <div class="my-3">
            <img src="{{\Illuminate\Support\Facades\Storage::url($operadora->logo)}}" alt="Logo" width="80" height="80">
        </div>
    </div>
    <div class="card-body">
        <form action="{{route('operadora.update',$operadora->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="nome">Nome*</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="{{$operadora->nome ?? old('nome')}}">
                    @if($errors->has('nome'))
                        <p class="alert alert-danger">{{$errors->first('nome')}}</p>
                    @endif
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="logo">Logo <small>(Preencher caso queira modificar a imagem da operadora)</small></label>
                    <input type="file" class="form-control" id="logo" name="logo">
                </div>
            </div>
            
            <button class="btn btn-primary btn-block" type="submit">Editar Operadora</button>
        </form>
    </div>
</div>                   
@stop