@extends('adminlte::page')
@section('title', 'Listar Premiações')
@section('content_header')
    <h1>Cadastrar Premiações: <a href="{{route('premiacao.corretores.cadastrar',$corretor->id)}}" class="btn btn-warning">
    <i class="fas fa-plus"></i>
    </a></h1>
@stop
@section('content')
    <div class="card">
        @if(count($premiacoes) >= 1)

            <div class="card-header">
                Listagem de Premiações do Corretor {{$corretor->name}}
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Administradora</th>
                            <th>Plano</th>
                            <th>Valor</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($premiacoes as $c)
                        <tr>
                            <td>{{$c->administradora}}</td>
                            <td>{{$c->plano}}</td>
                            <td>
                                {{$c->valor}}
                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>


        @else 
            <h5 class="py-3 text-center">Este Corretor Não possui premiações cadastradas!</h5>
        @endif
    
    
                    
        
    </div>
@stop