@extends('adminlte::page')
@section('title', "Orçamento do(a) cliente {$cliente->nome}")
@section('content_header')
    <h5>Orçamento(s) cliente {{$cliente->nome}}</h5>
@stop
@section('content')
<ol class="breadcrumb py-3">
    @if(auth()->user()->admin)
    <li class="breadcrumb-item"><a href="{{route('orcamento.admin.show',$cliente->user_id)}}">Listar Meus Clientes</a></li>
    @else
    <li class="breadcrumb-item"><a href="{{route('orcamento.corretor.show',$cliente->user_id)}}">Listar Meus Clientes</a></li>
    @endif
    
    <li class="breadcrumb-item">Orçamentos cliente {{$cliente->nome}}</li>
    
</ol>
    <div class="card">
        @if(count($orcamentos) >= 1)
            <table class="table">
                <thead>
                    <tr>
                        <th>Administradora</th>
                        <th>Coparticipacao</th>
                        <th>Odonto</th>
                        <th width="120px;">Status</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orcamentos as $d)
                    <tr>
                        <td><img src="{{\Illuminate\Support\Facades\Storage::url($d->administradora->logo)}}" class="img-fluid" width="120" height="60" alt=""></td>
                        <td>{{$d->coparticipacao}}</td>
                        <td>{{$d->odonto}}</td>
                        <td width="120px;">
                            @switch($d->status)
                                @case(1)
                                    <span class="badge badge-primary">Em Aberto</span>
                                @break
                                @case(2)
                                    <span class="badge badge-success">Finalizado</span>
                                @break
                                @case(3)
                                    <span class="badge badge-info">Vai Fechar</span>
                                @break
                                @case(4)
                                    <span class="badge badge-danger">Sem Interesse</span>
                                    
                                @break
                                @case(5)
                                    <span class="badge badge-warning">Aguardando Documentação</span>
                                    
                                @break
                            @endswitch
                        </td>
                        <td><a href="{{route('orcamentos.show.detalhe',$d->id)}}" class="btn btn-info btn-sm"><i class="fas fa-asterisk"></i></a></td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h5 class="py-3 text-center">Não a orçamentos cadastrados!</h5>
        @endif
        
    </div>
@stop