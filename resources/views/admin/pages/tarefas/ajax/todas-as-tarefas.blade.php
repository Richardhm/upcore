<!DOCTYPE html>
<html lang="pt-br">
<head></head>
<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <h4>Todas as Tarefas</h4>
    <div class="wrapper">
    @can('configuracoes') 
        <table class="table todasastarefasrealizadasadministrador">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Corretor</th>
                    <th>Tarefa</th>
                    <th>Data</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    @else
    <table class="table todasastarefasrealizadas">
            <thead>
                <tr>
                    <th>Tarefa</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    @endif
    </div>    
<script>
    $(function(){
        $(".todasastarefasrealizadas").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('tarefas.getListarTodasAsTarefasAjax') }}",
                    "dataSrc": ""
                },
                "lengthMenu": [15,30,45,90],
                "ordering": true,
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                columns: [
                    {data:"title",name:"title"},
                    {data:"cliente",name:"cliente"},
                    {data:"criacao",name:"data"},
                    {data:"status",name:"status"}
                ],
                "columnDefs": [ {
                        "targets": 3,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            if(cellData) {
                                $(td).html("<input type='checkbox' data-id="+rowData.id+" name='status_tarefas' id='status_tarefas' checked>")
                            } else {
                                $(td).html("<input type='checkbox' data-id="+rowData.id+" name='status_tarefas' id='status_tarefas'>")
                            }
                            
                        }
                    }
                ]
                
            });

            $(".todasastarefasrealizadasadministrador").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('tarefas.getListarTodasAsTarefasAjax') }}",
                    "dataSrc": ""
                },
                "lengthMenu": [15,30,45,90],
                "ordering": true,
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                columns: [
                    {data:"cliente",name:"cliente"},
                    {data:"corretor",name:"corretor"},
                    
                    {data:"title",name:"title"},
                    {data:"criacao",name:"criacao"},
                    {data:"status",name:"realizada"},
                    
                ],
                "columnDefs": [ {
                        "targets": 4,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            if(cellData) {
                                $(td).html("<i class='fas fa-check text-success'></i>")
                            } else {
                                $(td).html("<i class='fas fa-times text-danger'></i>")
                            }
                            
                        }
                    }
                ]
                
            });




    });    
</script>