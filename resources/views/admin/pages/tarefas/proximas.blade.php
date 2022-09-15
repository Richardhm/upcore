<!DOCTYPE html>
<html lang="pt-br">
<head>
    <style>
        .truncate {
            max-width:10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
    <h4>Tarefa(s) Proximos 03 dias</h4>
    <div class="wrapper">
    @can('configuracoes') 
        <table class="table tarefasproximasclienteadministrador">
            <thead>
                <tr>
                    <th>Corretor</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Titulo</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    @else
    <table class="table tarefasproximascliente">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Titulo</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>     
    @endcan
    </div>    
<script>
    $(function(){
        $(".tarefasproximascliente").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('cliente.getTarefasProximo03Dias') }}",
                    "dataSrc": ""
                },
                "lengthMenu": [8,15,30],
                "ordering": true,
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                
                //order: [[3, "asc"]],
                columns: [
                    {data:"cliente",name:"cliente"},
                    {data:"criacao",name:"data"},
                    {data:"title",name:"tarefa"},
                    {data:"descricao",name:"descricao"}
                ],
                    "columnDefs": [
                        { "width": "10%", "targets": 0 },
                        { "width": "10%", "targets": 1 },
                        { "width": "10%", "targets": 2 },
                        { "width": "70%", "targets": 3,className:"truncate" }
                    ]
                
            });

            $(".tarefasproximasclienteadministrador").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('cliente.getTarefasProximo03Dias') }}",
                    "dataSrc": ""
                },
                "lengthMenu": [8,15,30],
                "ordering": true,
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                
                //order: [[3, "asc"]],
                columns: [
                    {data:"corretor",name:"corretor"},
                    {data:"cliente",name:"cliente"},
                    {data:"criacao",name:"data"},
                    {data:"title",name:"tarefa"},
                    {data:"descricao",name:"descricao"}
                ],
                    "columnDefs": [
                        { "width": "10%", "targets": 0 },
                        { "width": "15%", "targets": 1 },
                        { "width": "10%", "targets": 2 },
                        { "width": "10%", "targets": 3 },
                        { "width": "65%", "targets": 4,className:"truncate" }
                    ]
                
            });
    });    


</script>    




