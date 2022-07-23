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
                        <i 
                                class="far fa-thumbs-{{$premiacao->status ? 'up' : 'down'}} fa-2x status-premiacao" 
                                
                                data-toggleclass="far fa-thumbs-{{$premiacao->status ? 'down' : 'up'}} fa-2x status-premiacao"  
                                data-id="{{$premiacao->id}}"
                                >
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

    <hr>
    <h4 class="text-center bg-navy py-4"><u>Corretora</u></h4>
    <hr>
    

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
                    @foreach($comissoesCorretora as $cc)
                    <tr>
                        <td>{{date('d/m/Y',strtotime($cc->data))}}</td>
                        <td>{{$cc->parcela}}</td>
                        <td>{{number_format($cc->valor,2,",",".")}}</td>
                       
                        <td>
                            <i 
                                class="far fa-thumbs-{{$cc->status ? 'up' : 'down'}} fa-2x status-corretora" 
                                
                                data-toggleclass="far fa-thumbs-{{$cc->status ? 'down' : 'up'}} fa-2x status-corretora"  
                                data-id="{{$cc->id}}"
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
                        <td>{{number_format($premiacoesCorretora->total,2,",",".")}}</td>
                        <td>
                        <i 
                                class="far fa-thumbs-{{$premiacoesCorretora->status ? 'up' : 'down'}} fa-2x status-premiacao-corretora" 
                                
                                data-toggleclass="far fa-thumbs-{{$premiacoesCorretora->status ? 'down' : 'up'}} fa-2x status-premiacao-corretora"  
                                data-id="{{$premiacoesCorretora->id}}"
                                >
                            </i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

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
           
           $('.status-corretora').on('click',function(){
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
                    
                })
           });





        });
   </script>
@stop
@section('css')

     
@stop
