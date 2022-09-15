@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
    <h1>Aguardando Boleto Pagamento Coletivo</h1>
@stop
@section('content')
<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Dashboard</a></li>
        <li class="breadcrumb-item">Boleto Coletivos</li>
    </ol>  
        @if(count($dados) >= 1)
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Corretor</th>
                            <th>Administradora</th>
                            <th>Valor</th>
                            <th>Data</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dados as $d)
                            <tr>
                                <td>{{$d->clientes->nome}}</td>
                                <td>{{$d->user->name}}</td>
                                <td>{{$d->administradora->nome}}</td>
                                <td>{{number_format($d->valor,2,",",".")}}</td>
                                <td>{{date('d/m/Y',strtotime($d->clientes->data_boleto))}}</td>
                                <td>
                                <i class="far fa-thumbs-{{$d->financeiro_id == 2 ? 'down' : 'up'}} fa-2x status" 
                                data-toggleclass="far fa-thumbs-{{$d->financeiro_id == 2 ? 'up' : 'down'}} fa-2x status"  
                                data-id="{{$d->id}}">
                                </i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>    
        @else
            <h3 class="alert alert-secondary border text-center">Sem Dados a serem listados!</h3>
        @endif
    
        <div id="resultado"></div>

@stop
@section('js')
    <script>
        
    </script>
@stop