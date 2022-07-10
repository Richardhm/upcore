@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Corretora {{$corretora->nome}}</h1>
@stop

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('corretora.index')}}">Listar Corretora</a></li>
    <li class="breadcrumb-item">Cadastrar</li>
</ol>
<div class="card">
        <div class="card-header">
          
        </div>
        <div class="card-body">
           <form action="{{route('corretora.update',$corretora->id)}}" method="post">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="nome">Nome*</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="{{$corretora->nome ?? old('nome')}}">
                    @if($errors->has('nome'))
                        <p class="alert alert-danger">{{$errors->first('nome')}}</p>
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{$corretora->email ?? old('email')}}">
                </div>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Editar Corretora</button>
           </form>
@stop

@section('js')
    <script src="{{asset('js/jquery.mask.min.js')}}"></script>
    <script>
        $(function(){
            $('#cep').mask('00000-000');
            $('#celular').mask('(000) 00000-0000');
            $('#telefone').mask('(000) 0000-0000');
            
        });
    </script>
@stop



