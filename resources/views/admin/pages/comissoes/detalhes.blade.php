@extends('adminlte::page')
@section('title', 'Comissões')
@section('content_header')
    <h3></h3>
@stop
@section('content')
    <h4 class="text-center bg-navy py-4"><u>Corretor</u></h4>
    @if(count($comissoes) >= 1)
    <div class="card">
        <div class="card-body">
            <h4>Comissão</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Parcela</th>
                        <th>Valor</th>
                        <th>Status</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($comissoes as $c)
                    <tr>
                        <td>{{date('d/m/Y',strtotime($c->data))}}</td>
                        <td>{{$c->parcela}}</td>
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
            <hr>    
        </div>
    </div>
    @else
        <div class="card bg-warning">
            <div class="card-body">
                <h5 class="text-center text-white"><u>Este Corretor Não Possui Comissões Cadastradas</u></h5>      
            </div>
        </div>
    @endif

    @if(!empty($premiacao) && $premiacao != "")

    <div class="card">
        <div class="card-header">
            <h3>Premiação</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Premiacao</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{number_format($premiacao->total,2,",",".")}}</td>
                        <td>
                        <i class="far fa-thumbs-{{$premiacao->status ? 'up' : 'down'}} fa-2x status-premiacao" data-toggleclass="far fa-thumbs-{{$premiacao->status ? 'down' : 'up'}} fa-2x status-premiacao" data-id="{{$premiacao->id}}">
                            </i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @else
        <div class="card bg-warning">
            <div class="card-body">
                <h5 class="text-center text-white"><u>Este Corretor Não Possui Premiações Cadastradas</u></h5>
            </div>
        </div>
    @endif

    @can('configuracoes')

        <h4 class="text-center bg-navy py-4"><u>Corretora</u></h4>

        <div class="card">
            <div class="card-body">
                <h4>Comissão</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Parcela</th>
                            <th>Valor</th>
                            <th>Status</th>    
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comissoesCorretora as $c)
                            <tr>
                                <td>{{date('d/m/Y',strtotime($c->data))}}</td>
                                <td>{{$c->parcela}}</td>
                                <td>{{number_format($c->valor,2,",",".")}}</td>
                                <td><i class="far fa-thumbs-{{$c->status ? 'up' : 'down'}} fa-2x status-comissoes-corretora" data-toggleclass="far fa-thumbs-{{$c->status ? 'down' : 'up'}} fa-2x status-comissoes-corretora" data-id="{{$c->id}}"></i></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>    
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Premiação</h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Premiacao</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{number_format($premiacaoCorretora->total,2,",",".")}}</td>
                            <td>
                            <i class="far fa-thumbs-{{$premiacaoCorretora->status ? 'up' : 'down'}} fa-2x status-premiacao-corretora" data-toggleclass="far fa-thumbs-{{$premiacaoCorretora->status ? 'down' : 'up'}} fa-2x status-premiacao-corretora" data-id="{{$premiacaoCorretora->id}}">
                                </i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>    
    @endcan
@stop   
@section('js')
   <script>
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           $('.status').on('click',function(){
                let classeAtual = $(this).attr('class')
                let toggle = $(this).attr('data-toggleclass');
                $(this).attr('class',toggle);
                $(this).attr('data-toggleclass', classeAtual);
                let id = $(this).attr('data-id');
                $.ajax({
                    method:"POST",
                    data:"id="+id,
                    url:"{{route('comissoes.mudarStatus')}}"     
                })
           });  

           $('.status-premiacao').on('click',function(){
                let classeAtual = $(this).attr('class')
                let toggle = $(this).attr('data-toggleclass');
                $(this).attr('class',toggle);
                $(this).attr('data-toggleclass', classeAtual);
                let id = $(this).attr('data-id');
                $.ajax({
                    method:"POST",
                    data:"id="+id,
                    url:"{{route('comissoes.mudarStatusPremiacao')}}"      
                })
           });

           $('.status-comissoes-corretora').on('click',function(){
                let classeAtual = $(this).attr('class')
                let toggle = $(this).attr('data-toggleclass');
                $(this).attr('class',toggle);
                $(this).attr('data-toggleclass', classeAtual);
                let id = $(this).attr('data-id');
                $.ajax({
                    method:"POST",
                    data:"id="+id,
                    url:"{{route('comissoes.mudarStatusCorretora')}}"     
                })                    
           });

           $('.status-premiacao-corretora').on('click',function(){
                let classeAtual = $(this).attr('class')
                let toggle = $(this).attr('data-toggleclass');
                $(this).attr('class',toggle);
                $(this).attr('data-toggleclass', classeAtual);
                let id = $(this).attr('data-id');
                
                $.ajax({
                    method:"POST",
                    data:"id="+id,
                    url:"{{route('comissoes.mudarStatusCorretoraPremiacao')}}"     
                });    
           });  








        });
   </script>
@stop
@section('css')

     
@stop
