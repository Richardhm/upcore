@if(count($tarefas) >= 1)
<h4>Tarefa(s) Proximos 03 dias</h4>
<hr>
<table class="table">
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Data</th>
            <th>Titulo</th>
            <th>Descrição</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tarefas as $t)
        <tr>
            <td>{{$t->cliente->nome}}</td>
            <td>{{date("d/m/Y",strtotime($t->data))}}</td>
            <td>{{$t->title}}</td>
            <td>{{$t->descricao}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
    <p>Sem Nenhum tarefa para os proximos 03 dias</p>
@endif
