@extends('adminlte::page')
@section('title', 'Dashboard')
@section('plugins.jqueryUi', true)
@section('content_header')
    <h1>Aguardando Boleto Pagamento Coletivo</h1>
@stop
@section('content')
<div id="dialog-confirm" title="Deseja mesmo realizar essa operação?"></div>
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
                            <th>Voltar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dados as $d)
                        
                            <tr class="{{$d->clientes->data_boleto < date('Y-m-d') ? 'bg-danger' : ''}}" data-linha="{{$d->id}}">
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
                                <td>
                                <i class="fas fa-arrow-left fa-2x back" data-id="{{$d->id}}"></i>
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
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.status').on('click',function(){
                let id = $(this).attr('data-id');

                $( "#dialog-confirm" ).dialog({
                    resizable: false,
                    height: "auto",
                    width: 400,
                    modal: true,
                    buttons: {
                        "Sim": function() {
                            
                            confirmado(id);
                            $(this).dialog( "close" );
                        },
                        'Não': function() {
                            $(this).dialog( "close" );
                            
                        }
                    }
                });                



                
           });  

           function confirmado(id) {
                let classeAtual = $(this).attr('class');
                let toggle = $(this).attr('data-toggleclass');
                $(this).attr('class',toggle);
                $(this).attr('data-toggleclass', classeAtual);
                $.ajax({
                    method:"POST",
                    data:"id="+id,
                    url:"{{route('financeiro.setAguardandoPagamentoboletocoletivo')}}",
                    success:function(res) {
                        if(res == 0) {
                            $('.card').fadeOut('slow',function(){
                                $("#resultado").html('<h3 class="alert alert-secondary border text-center">Sem Dados a serem listados!</h3>')
                            });
                        }
                    }
                });
                $(this).closest('tr').fadeOut('slow');
           }



           $(".back").on('click',function(){
                let id = $(this).attr('data-id');
                $.ajax({
                    url:"{{route('financeiro.backAguardandoBoletoColetivo')}}",
                    data:"id="+id,
                    method:"POST",
                    success:function(res) {
                        if(res == 0) {
                            $('.card').fadeOut('fast',function(){
                                $("#resultado").html('<h3 class="alert alert-secondary border text-center">Sem Dados a serem listados!</h3>')
                            });
                        }
                    }
                });
           });


        });
    </script>
@stop