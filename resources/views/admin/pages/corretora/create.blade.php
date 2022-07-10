@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cadastrar Corretora</h1>
@stop

@section('content')

<div class="card">
        <div class="card-header">
          
        </div>
        <div class="card-body">
           <form action="{{route('corretora.store')}}" method="post">
            @csrf
            
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="nome">Nome*</label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="{{old('nome')}}">
                    @if($errors->has('nome'))
                        <p class="alert alert-danger">{{$errors->first('nome')}}</p>
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{old('email')}}">
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Cadastrar Corretora</button>
           </form>
    




@stop
