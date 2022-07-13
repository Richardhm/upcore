@extends('adminlte::page')
@section('title', 'Contrato')
@section('content_header')
    <h3>Contrato</h3>
@stop
@section('content')


<div class="card">
    
    <div class="card-body">

        @if(count($contratos) >= 1)
            <table class="table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Cod. Externo</th>
                        <th>Cliente</th>
                        <th>Administradora</th>
                        <th>Acomodação</th>
                        <th>Cidade</th>
                        <th>Valor</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contratos as $c)
                        <tr>
                            <td>{{date('d/m/Y',strtotime($c->created_at))}}</td>
                            <td>{{$c->cotacao->codigo_externo}}</td>
                            <td>{{$c->nome}}</td>
                            <td>{{$c->cotacao->administradora->nome}}</td>
                            <td>{{$c->cotacao->acomodacao->nome}}</td>
                            <td>{{$c->cidade->nome}}</td>
                            <td>{{number_format($c->cotacao->valor,2,",",".")}}</td>
                            <td><a href="{{route('cotacao.comissao.detalhes',$c->id)}}">Detalhes</a></td>
                        </tr>
                        
                    @endforeach
                </tbody>
            </table>
        @else
            <h4 class="text-center">Sem Contratos a serem listados</h4>
        @endif




    </div>
</div>    

@stop   
@section('js')

    
@stop

