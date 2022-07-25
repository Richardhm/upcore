@extends('adminlte::page')
@section('title', 'Listar Comissoes')
@section('content_header')
   



    <h1>Cadastrar Comissoes: <a href="{{route('comissao.corretores.cadastrar',$corretor->id)}}" class="btn btn-warning">
    <i class="fas fa-plus"></i>
    </a></h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('corretores.index')}}">Voltar Listagem de Colaboradores</a></li>
        <li class="breadcrumb-item">Listagem de Comissões</li>
    </ol>    


@stop
@section('content')
    <div class="card">
        @if(count($comissoes) >= 1)

            <div class="card-header">
                Listagem de Comissões do Corretor {{$corretor->name}}
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Administradora</th>
                            <th>Plano</th>
                            <th>Detalhes</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($comissoes as $c)
                        <tr>
                            <td>{{$c->administradora}}</td>
                            <td>{{$c->plano}}</td>
                            <td>
                                <a href="{{route('comissao.corretores.detalhes',[$c->user_id,$c->id_plano,$c->id_administradora])}}">
                                    <i class="fas fa-info-circle"></i>
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