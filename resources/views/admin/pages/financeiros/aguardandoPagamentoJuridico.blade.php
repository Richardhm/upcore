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
                            <th>Vendedor</th>
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
                                <td>{{$d->cliente->user->name}}</td>
                                <td class="text-center">{{$d->quantidade_vidas}}</td>
                                <td>{{$d->valor}}</td>
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
                let classeAtual = $(this).attr('class')
                let toggle = $(this).attr('data-toggleclass');
                $(this).attr('class',toggle);
                $(this).attr('data-toggleclass', classeAtual);
                
                
                $.ajax({
                    method:"POST",
                    data:"id="+id,
                    url:"{{route('financeiro.setAguardandoPagamentoVigencia')}}",
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
                    url:"{{route('financeiro.backAguardandoPagamentoAdesaoColetivo')}}",
                    data:"id="+id,
                    method:"POST",
                    success:function(res) {
                        if(res == 0) {
                            $('.card').fadeOut('slow',function(){
                                $("#resultado").html('<h3 class="alert alert-secondary border text-center">Sem Dados a serem listados!</h3>')
                            });
                        }
                    }
                });
           }); 




        });
    </script>
@stop