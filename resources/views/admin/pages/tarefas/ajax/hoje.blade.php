<!DOCTYPE html>
<html lang="pt-br">
<head></head>
<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <h4>Tarefa(s) Hoje</h4>
    <div class="wrapper">
        <table class="table tarefashojemesmo">
            <thead>
                <tr>
                    <th>Tarefa</th>
                    <th>Cliente</th>
                    <th>Data Criação da Tarefa</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>    
<script>
    $(function(){
        $(".tarefashojemesmo").DataTable({
                "language": {
                    "url": "{{asset('traducao/pt-BR.json')}}"
                },
                ajax: {
                    "url":"{{ route('cliente.getTarefasParaHoje') }}",
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
                    {data:"title",name:"title"},
                    {data:"cliente",name:"cliente"},
                    {data:"criacao",name:"data"},
                    
                ]
                
            });
    });    
</script>    