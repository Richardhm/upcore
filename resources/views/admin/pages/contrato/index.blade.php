@extends('adminlte::page')
@section('title', 'Contrato')
@section('plugins.Datatables', true)
@section('content_header')
    <h3>Contrato</h3>
@stop
@section('content')
<div class="card">
    @if (session('success'))
        <div class="alert alert-success">
            <p class="text-center">{{ session('success') }}</p>
        </div>
    @endif    
    <div class="card-body">

        @can('configuracoes')
            <table class="table listarcontratosadministrador">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Cod. Externo</th>
                            <th>Cliente</th>
                            <th>Administradora</th>
                            <th>Acomodação</th>
                            <th>Cidade</th>
                            <th>Valor</th>
                            <th>Detalhes</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
        @else
                <table class="table listarcontratos">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Cod. Externo</th>
                            <th>Cliente</th>
                            <th>Administradora</th>
                            <th>Acomodação</th>
                            <th>Cidade</th>
                            <th>Valor</th>            
                            <th>Detalhes</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>   
        @endcan
    </div>
</div>    

@stop   
@section('js')
    <script>

        $(".listarcontratos").DataTable({
            "language": {
                "url": "{{asset('traducao/pt-BR.json')}}"
            },
            ajax: {
                "url":"{{ route('contratos.index.listagem') }}",
                "dataSrc": ""
            },
            "lengthMenu": [15,30,45],
            "ordering": true,
            "paging": true,
            "searching": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            columns: [
                {data:"created_at",name:"created_at",render:function(data, type, row, meta) {
                    return data.split("T")[0].split("-").reverse().join("/");
                }},
                {data:"cotacao.codigo_externo",name:"codigo"},
                {data:"nome",name:"cliente"},
                {data:"cotacao.administradora.nome",name:"administradora"},
                {data:"cotacao.acomodacao.nome",name:"acomodacao"},
                {data:"cidade.nome",name:"acomodacao"},
                {data:"cotacao.valor",name:"valor"},
                {data:"comissoes.id",name:"id"},
            ],
            "columnDefs": [{
                    "targets": 7,
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).html("<a href='/admin/cotacao/contrato/comissao/"+cellData+"'><i class='fas fa-eye'></i></a>")
                    }
                },
            ]
        });

        $(".listarcontratosadministrador").DataTable({
            "language": {
                "url": "{{asset('traducao/pt-BR.json')}}"
            },
            ajax: {
                "url":"{{ route('contratos.index.listagem') }}",
                "dataSrc": ""
            },
            "lengthMenu": [15,30,45],
            "ordering": true,
            "paging": true,
            "searching": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            columns: [
                {data:"created_at",name:"created_at",render:function(data, type, row, meta) {
                    return data.split("T")[0].split("-").reverse().join("/");
                }},
                {data:"cotacao.codigo_externo",name:"codigo"},
                {data:"nome",name:"cliente"},
                {data:"cotacao.administradora.nome",name:"administradora"},
                {data:"cotacao.acomodacao.nome",name:"acomodacao"},
                {data:"cidade.nome",name:"acomodacao"},
                {data:"cotacao.valor",name:"valor"},
                {data:"comissoes.id",name:"id"},
            ],
            "columnDefs": [{
                    "targets": 7,
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).html("<a href='/admin/cotacao/contrato/comissao/administrador/"+cellData+"'><i class='fas fa-eye'></i></a>")
                    }
                },
            ]
                
        });
    </script>
    
@stop

