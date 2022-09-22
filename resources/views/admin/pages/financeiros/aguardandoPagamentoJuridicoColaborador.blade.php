@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.jqueryUi', true)
@section('content_header')
    <h1>Aguardando Pagamento Jurídico</h1>
@stop

@section('content')
<div id="dialog-confirm" title="Deseja mesmo realizar essa operação?"></div>
<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Dashboard</a></li>
        <li class="breadcrumb-item">Aguardando Pagamento Jurídico</li>
    </ol>  
    
        @if(count($dados) >= 1)
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Proprietario</th>
                            <th>Razão Social</th>
                            <th>Cidade</th>
                            <th>CNPJ</th>
                            @if($admin == "sim")
                            <th>Vendedor</th>
                            @endif
                            <th class="text-center">Qte. Vidas</th>
                            <th>Valor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dados as $d)
                            <tr>
                                <td>{{$d->cliente->nome}}</td>
                                <td>{{$d->cliente->nome_empresa}}</td>
                                <td>{{$d->cliente->cidade->nome}}</td>
                                <td>{{$d->cliente->cnpj}}</td>
                                @if($admin == "sim")
                                <td>{{$d->cliente->user->name}}</td>
                                @endif
                                <td class="text-center">{{$d->quantidade_vidas}}</td>
                                <td>{{number_format($d->valor,2,",",".")}}</td>
                                <td>
                                <i class="far fa-thumbs-{{$d->status == 0 ? 'down' : 'up'}} fa-2x status" 
                                data-toggleclass="far fa-thumbs-{{$d->status == 4 ? 'up' : 'down'}} fa-2x status"  
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