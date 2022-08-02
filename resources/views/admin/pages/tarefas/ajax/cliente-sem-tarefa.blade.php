<!DOCTYPE html>
<html lang="pt-br">
<head>
  
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
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
                "lengthMenu": [8,15,30],
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
    });
</script>
</body>
</html>