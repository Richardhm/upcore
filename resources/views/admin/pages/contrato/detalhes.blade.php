@extends('adminlte::page')
@section('title', 'Comissões')
@section('content_header')
    <h3>Contrato</h3>
@stop
@section('content')


<div class="card">
    
    <div class="card-body">

        @if(count($comissoes) >= 1)
            <table class="table">
                <thead>
                    <tr>
                        <th>Parcela</th>
                        
                        <th>Valor</th>
                        <th>Status</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($comissoes as $c)
                        <tr>
                            <td>Parcela {{$c->parcela}}</td>
                            <td>{{number_format($c->valor,2,",",".")}}</td>
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

@stop   
@section('js')

    
@stop

