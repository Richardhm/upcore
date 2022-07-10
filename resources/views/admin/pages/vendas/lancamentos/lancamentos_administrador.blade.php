@extends('adminlte::page')

@section('title', 'Vendas')

@section('content_header')
    <h1>Lançamentos</h1>
@stop

@section('content')
<table class="table">
    <thead>
        <tr>
            <th style="width:40px;">#</th>
            <th style="width:200px;text-align:center;">Data Inicial</th>
            <th style="width:200px;text-align:center;">Data Final</th>
            <th style="width:40px;">Vitalício</th>
            <th style="width:40px;" class="porcentagem">%</th>
            <th>Lançar</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$venda->id}}</td>
            <td>
                <input type="date" name="data_inicial" id="data_inicial" class="form-control">
            </td>
            <td>
                <input type="date" name="data_final" id="data_final" class="form-control">
            </td>
            <td style="margin-top:10px;display:flex;justify-content: center;">
                <input type="checkbox" name="vitalicio" id="vitalicio">
            </td>
            <td class="porcentagem">kkkkkkkk</td>
            <td>
                <button class="btn btn-secondary lancamento">Lançar</button>
            </td>
        </tr>
    </tbody>
</table>
@endsection

@section('css')
    <style>
        .porcentagem {
            display:none;
        }
    </style>
@stop

@section('js')
    <script>
        $(function(){
            $('.lancamento').click(function(){
                let data_inicial = $("#data_inicial").val();
                let data_final = $("#data_final").val();

            });

            $('#vitalicio').click(function(){
                let valor = $(this).prop('checked');
                if(valor) {
                    $('.porcentagem').css('display','block');                        
                } else {
                    $('.porcentagem').css('display','none');
                }
                
            }); 
        });
    </script>
@stop






