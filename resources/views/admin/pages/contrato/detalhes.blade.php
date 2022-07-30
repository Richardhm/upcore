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
        



    <div class="card-header">
        <h3>Comissões</h3>
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
            <h4 class="text-center">Sem Contratos a serem listados</h4>
        @endif




    </div>
</div>  


<div class="card">
    @if(!empty($premiacao))
    <div class="card-header">
        <h3>Premiação</h3>
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
                    <td>{{number_format($premiacao->total,2,",",".")}}</td>
                    <td><i class="far fa-thumbs-{{$premiacao->status ? 'up' : 'down'}} fa-2x status" data-toggleclass="far fa-thumbs-{{$premiacao->status ? 'down' : 'up'}} fa-2x status"  data-id="{{$c->id}}"></i></td>
                </tr>
            </tbody>
        </table> 
    </div>
    @else
        <h4 class="text-center">Não Premiações cadastradas para esse Corretor</h4>    
    @endif
</div>



@stop   
@section('js')

    
@stop

