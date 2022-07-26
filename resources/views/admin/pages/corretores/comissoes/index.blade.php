@extends('adminlte::page')
@section('title', 'Listar Comissoes')
@section('content_header')
   <h1>Cadastrar Comissoes: <a href="{{route('comissao.corretores.cadastrar',$corretor->id)}}" class="btn btn-warning">
    <i class="fas fa-plus"></i>
    </a></h1>
@stop
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('corretores.index')}}">Voltar Listagem de Colaboradores</a></li>
        <li class="breadcrumb-item">Listagem de Comissões do Corretor <b>{{$corretor->name}}</b></li>
    </ol>    
    <div class="card">
        @if(count($comissoes) >= 1)
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Administradora</th>
                            <th>Plano</th>
                            <th>Detalhes</th>
                            <th>Deletar</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($comissoes as $c)
                       <form id="form_{{$c->id}}" action="{{route('comissao.corretores.deletar',[$c->user_id,$c->id_plano,$c->id_administradora])}}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        <tr>
                            <td>{{$c->administradora}}</td>
                            <td>{{$c->plano}}</td>
                            <td>
                                <a href="{{route('comissao.corretores.detalhes',[$c->user_id,$c->id_plano,$c->id_administradora])}}">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </td>
                            <td>
                                <a onclick="document.getElementById('form_{{$c->id}}').submit()" href="#">
                                    <i class="fas fa-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        @else 
            <h5 class="py-3 text-center">Este Corretor Não possui comissões cadastradas!</h5>
        @endif     
    </div>
@stop