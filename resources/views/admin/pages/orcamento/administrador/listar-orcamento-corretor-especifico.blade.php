@extends('adminlte::page')
@section('title', 'Orçamento Corretores')
@section('content_header')
    <h3>Orçamento corretor {{$corretor->name}}</h3>
@stop
@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('orcamentos.por.corretores',[auth()->user()->corretora_id,auth()->user()->id])}}">Listar Orçamentos dos Corretores</a></li>
    <li class="breadcrumb-item">Orçamentos de {{$corretor->name}}</li>
</ol>
    <div class="card">
        <div class="card-header">
            <form action="" class="form-inline" method="POST">
                @csrf
                <input type="text" placeholder="Operadora/Cliente" name="filter" id="filter" class="form-control">
                <button class="btn btn-warning">Pesquisar</button>
            </form>     
        </div>

        <div class="card-body">
            @if(count($orcamentos) >= 1)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Operadora</th>
                            <th>Cliente</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th>Detalhes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orcamentos as $o)
                            <tr>
                                <td>
                                    <img src="{{\Illuminate\Support\Facades\Storage::url($o->administradora->logo)}}" width="100" height="40" alt="">
                                </td>
                                <td>{{$o->cliente}}</td>
                                <td>
                                    @switch($o->status)
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
                                            <span class="badge badge-warning">Sem Interesse</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>{{date('d/m/Y H:i:s',strtotime($o->created_at))}}</td>
                                <td>
                                    <a class="btn btn-info" href="{{route('orcamento.detalhe.corretor',$o->id)}}"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h5 class="py-3 text-center">Não a orçamentos cadastrados!</h5>
            @endif
        </div>
        
    </div>
@stop