<!DOCTYPE html>
<html lang="pt-br">
<head>
  
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    @can('configuracoes')
        <table class="table clientesemtarefasadministrador">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Corretor</th>
                                              
                    <th>Telefone</th>   
                    <th>Status</th>   
                    
                </tr>
            </thead>
            <tbody></tbody>                  
        </table>    
    @else
        <table class="table clientesemtarefas">
            <thead>
                <tr>
                    <th>nome</th>                          
                    <th>telefone</th>   
                    <th>status</th>   
                    <th></th>   
                </tr>
            </thead>
            <tbody></tbody>                  
        </table>
    @endcan
</div>
<script>
    $(function(){
        $(".clientesemtarefas").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('cliente.getClienteSemTarefaAjax') }}",
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
                    {data:"nome",name:"nome"},
                    {data:"telefone",name:"telefone"},
                    {data:"etiqueta",name:"status"},
                    {data:"id",name:"id"},
                ],
                "columnDefs": [ {
                        "targets": 2,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).html("<div style='width:20px;height:20px;border-radius:50%;background-color:"+cellData+"'></div>")
                        }
                    },
                    {
                        "targets": 3,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).html("<a href='/admin/clientes/"+cellData+"/tarefa' style='display:block;color:white;width:120px;border-radius:10px;text-align: center;background-color:rgb(249,3,110);'>Criar Tarefa</a>")
                        }
                    },
                ]
            });

            $(".clientesemtarefasadministrador").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('cliente.getClienteSemTarefaAjax') }}",
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
                    {data:"nome",name:"nome"},
                    {data:"corretor",name:"corretor"},
                    
                    {data:"telefone",name:"telefone"},
                    {data:"etiqueta",name:"status"},
                    
                ]
            });

    });
</script>
</body>
</html>