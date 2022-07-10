@extends('adminlte::page')
@section('title', 'Vincular Cidades Administradoras')
@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('cidades.index')}}">Listar Cidades</a></li>
        <li class="breadcrumb-item">Vincular/Desvincular</li>
    </ol>       
@stop
@section('content')
    <div class="card">
        <div class="card-header">
            <h5>Cidade {{$cidade->nome}}</h5>
        </div>
        <div class="card-body">
            @if(count($administradoras) >= 1)
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:5px;">#</th>
                            <th>Administradora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form action="{{route('cidade.vincular.administradora',$cidade->id)}}" method="POST">
                            @csrf                     
                            @foreach($administradoras as $a)
                                <tr>
                                    <td><input type="checkbox" name="administradora_id[]" {{in_array($a->id,$marcados) ? 'checked' : ''}} value="{{$a->id}}" /></td>
                                    <td>{{$a->nome}}</td>
                                </tr>
                            @endforeach
                            <tr class="d-flex justify-content-center">
                                <td colspan="500"><input type="submit" class="btn btn-primary btn-block text-center" value="Vincular/Desvincular Administradora a cidade de {{$cidade->nome}}"></td>
                            </tr>    
                        </form>
                    </tbody>
                </table>
            @else
                <h3 class="text-center py-3">Nenhum administradora cadastrada ainda</h3>
            @endif
        </div>
    </div>
@stop