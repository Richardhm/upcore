<!DOCTYPE html>
<html lang="pt-br">
<head></head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
    <h4>Tarefa(s) Atrasadas</h4>
    <div class="wrapper">
    @can('configuracoes')
        <table class="table tarefasatrasadasclienteadministrador">
            <thead>
                <tr>
                    <th>Corretor</th>
                    <th>Tarefa</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    @else
        <table class="table tarefasatrasadascliente">
            <thead>
                <tr>
                    <th>Tarefa</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Marcar Realizada</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    @endcan
        
    </div>    
<script>
    $(function(){
        $(".tarefasatrasadascliente").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('cliente.getTarefasAtrasadasAjax') }}",
                    "dataSrc": ""
                },
                "lengthMenu": [15,30,45,90],
                "ordering": true,
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                //order: [[3, "asc"]],
                columns: [
                   
                    {data:"title",name:"tarefa"},
                    {data:"cliente",name:"cliente"},
                    {data:"criacao",name:"data"},
                    {data:"id",name:"status"}
                ],
                "columnDefs": [ {
                        "targets": 3,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).html("<input type='checkbox' name='mudarStatus' id='mudarStatus' data-id="+cellData+">")
                        }
                    }
                ]
                
            });

            $(".tarefasatrasadasclienteadministrador").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('cliente.getTarefasAtrasadasAjax') }}",
                    "dataSrc": ""
                },
                "lengthMenu": [15,30,45,90],
                "ordering": true,
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                //order: [[3, "asc"]],
                columns: [
                    {data:"corretor",name:"corretor"},
                    {data:"title",name:"tarefa"},
                    {data:"cliente",name:"cliente"},
                    {data:"criacao",name:"data"},
                    
                ]
                
            });








    });    
</script>
