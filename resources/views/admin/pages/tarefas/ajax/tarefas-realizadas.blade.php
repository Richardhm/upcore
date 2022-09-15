<!DOCTYPE html>
<html lang="pt-br">
<head></head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
    <h4>Tarefa(s) Realizadas</h4>
    <div class="wrapper">
    @can('configuracoes')    
        <table class="table tarefasrealizadasadministrador">
            <thead>
                <tr>
                    <th>Corretor</th>
                    <th>Tarefa</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Tarefa Realizada</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    @else
    <table class="table tarefasrealizadas">
            <thead>
                <tr>
                    <th>Tarefa</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Tarefa Realizada</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    @endcan
    </div>    
<script>
    $(function(){
        $(".tarefasrealizadas").DataTable({
            "language": {
                "url": "{{asset('traducao/pt-BR.json')}}"
            },
            ajax: {
                "url":"{{ route('tarefa.getTarefasRealizadasAjax') }}",
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
                {data:"title",name:"tarefa"},
                {data:"cliente",name:"cliente"},
                {data:"data",name:"data"},
                {data:"realizada",name:"realizada"},
            ]
                
        });

        $(".tarefasrealizadasadministrador").DataTable({
            "language": {
                "url": "{{asset('traducao/pt-BR.json')}}"
            },
            ajax: {
                "url":"{{ route('tarefa.getTarefasRealizadasAjax') }}",
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
                {data:"title",name:"tarefa"},
                {data:"cliente",name:"cliente"},
                {data:"data",name:"data"},
                {data:"realizada",name:"realizada"},
            ]
                
        });




    });    
</script>
