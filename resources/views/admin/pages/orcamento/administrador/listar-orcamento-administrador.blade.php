@extends('adminlte::page')
@section('title', 'Meus Orçamento(s) Por Cliente')
@section('content_header')
    <h3>Orçamentos Por Cliente</h3>
@stop
@section('content')
    <div class="card">
        @if(count($clientes) >= 1)
            <table class="table">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Qtde. Orçamento</th>
                        <th>Visualizar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $d)
                    <tr>
                        <td>{{$d->nome}}</td>
                        <td>{{$d->quantidade}}</td>
                        <td><a href="{{route('orcamento.detalhes',$d->id)}}" class="btn btn-info"><i class="fas fa-eye"></i></a></td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h5 class="py-3 text-center">Não a orçamentos cadastrados!</h5>
        @endif
        
    </div>
@stop