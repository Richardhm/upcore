@extends('adminlte::page')
@section('title', 'Comissões')
@section('content_header')
    <h3>Detalhes</h3>
@stop
@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{route('contratos.index')}}">Listar Contratos</a></li>
    <li class="breadcrumb-item">Detalhes</li>
</ol>
<div class="card">
    <div class="card-header bg-navy text-center">
        <h3>Corretor - Comissão</h3>
    </div>
    <div class="card-body">   
        @if(count($comissoes) >= 1)
            <table class="table">
                <thead>
                    <tr>
                        <th>Parcela</th>
                        <th>Valor</th>
                        <th>Data</th>
                        <th>Status</th>                      
                    </tr>
                </thead>
                <tbody>
                    @foreach($comissoes as $c)
                        <tr>
                            <td>Parcela {{$c->parcela}}</td>
                            <td>{{number_format($c->valor,2,",",".")}}</td>
                            <td>{{date('d/m/Y',strtotime($c->data))}}</td>
                            <td>
                            <i 
                                class="far fa-thumbs-{{$c->status ? 'up' : 'down'}} fa-2x status" 
                                data-toggleclass="far fa-thumbs-{{$c->status ? 'down' : 'up'}} fa-2x status"  
                                data-id="{{$c->id}}"
                                >
                            </i>
                        </td>                          
                        </tr>                     
                    @endforeach
                </tbody>
            </table>
        @else
            <h4 class="text-center">Sem Comissões a serem listados para esse corretor</h4>
        @endif
    </div>
</div>  
<div class="card">
    <div class="card-header text-center bg-navy">
        <h3>Corretor - Premiação</h3>
    </div>
    @if(count($premiacao) >= 1)
    
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Valor</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($premiacao as $pp)
                    <tr>
                        <td>{{number_format($pp->total,2,",",".")}}</td>
                        <td>
                        <i 
                            class="far fa-thumbs-{{$pp->status ? 'up' : 'down'}} fa-2x status" 
                            data-toggleclass="far fa-thumbs-{{$pp->status ? 'down' : 'up'}} fa-2x status"  
                            data-id="{{$pp->id}}"
                                >
                            </i>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table> 
    </div>
    @else
        <h4 class="text-center py-3">Não Premiações cadastradas para esse Corretor</h4>    
    @endif
</div>
<div class="card">
    <div class="card-header bg-navy">
        <h3 class="text-center">Corretora - Comissão</h3>
    </div>
    <div class="card-body">   
        @if(count($comissao_corretora) >= 1)
            <table class="table">
                <thead>
                    <tr>
                        <th>Parcela</th>
                        <th>Valor</th>
                        <th>Data</th>
                        <th>Status</th>                      
                    </tr>
                </thead>
                <tbody>
                    @foreach($comissao_corretora as $cc)
                        <tr>
                            <td>Parcela {{$cc->parcela}}</td>
                            <td>{{number_format($cc->valor,2,",",".")}}</td>
                            <td>{{date('d/m/Y',strtotime($cc->data))}}</td>
                            <td>
                            <i 
                                class="far fa-thumbs-{{$cc->status ? 'up' : 'down'}} fa-2x status" 
                                data-toggleclass="far fa-thumbs-{{$cc->status ? 'down' : 'up'}} fa-2x status"  
                                data-id="{{$cc->id}}"
                                >
                            </i>
                        </td>                          
                        </tr>                     
                    @endforeach
                </tbody>
            </table>
        @else
            <h4 class="text-center">Sem Contratos a serem listados</h4>
        @endif
    </div>
</div>

<div class="card">
    @if(!empty($premiacao_corretora))
    <div class="card-header text-center bg-navy">
        <h3>Premiação - Corretora</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Valor</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{number_format($premiacao_corretora->total,2,",",".")}}</td>
                    <td>
                        <i 
                        class="far fa-thumbs-{{$premiacao_corretora->status ? 'up' : 'down'}} fa-2x status" 
                        data-toggleclass="far fa-thumbs-{{$premiacao_corretora->status ? 'down' : 'up'}} fa-2x status"  
                        data-id="{{$premiacao_corretora->id}}"
                        >
                        </i>
                    </td>
                </tr>

            </tbody>
        </table> 
    </div>
    @else
        <h4 class="text-center py-2">Não Premiações cadastradas para esse Corretor</h4>    
    @endif
</div>
@stop   
@section('js')
@stop