@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Plano Individual</h1>
@stop

@section('content')
<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Dashboard</a></li>
        <li class="breadcrumb-item">Planos Individuais</li>
    </ol>    
        @if(count($dados) >= 1)
        <div class="card">
            <div class="card-body">
                <table class="table" style="font-size:0.9em;">
                    <thead>
                        <tr>
                            
                            <th>Cliente</th>
                            <th>Endereço</th>
                            <th>CPF</th>
                            <th>Administradora</th>
                            <th>Plano</th>
                            <th>Valor</th>
                            
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dados as $d)
                            <tr>
                                
                                <td>{{$d->clientes->nome}}</td>
                                <td>{{$d->clientes->endereco_financeiro}}</td>
                                <td>{{$d->clientes->cpf}}</td>
                                <td>{{$d->administradora->nome}}</td>
                                <td>{{$d->plano->nome}}</td>
                                <td>{{number_format($d->valor,2,",",".")}}</td>
                                
                                
                                <td>
                                <i class="far fa-thumbs-{{$d->financeiro_id == 1 ? 'down' : 'up'}} fa-2x status" 
                                data-toggleclass="far fa-thumbs-{{$d->financeiro_id == 1 ? 'up' : 'down'}} fa-2x status"  
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