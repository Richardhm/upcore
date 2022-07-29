@if(count($tarefas) >= 1)
<h4>Tarefa(s) Realizadas</h4>
<hr>
<table class="table">
    <thead>
        <tr>
            <th>Tarefa</th>
            <th>Cliente</th>
            <th>Data</th>
            <th>Realizada/Não Realizada</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tarefas as $c)
        <tr>
            <td>{{$c->title}}</td>
            <td>{{$c->cliente->nome}}</td>
            <td>{{date('d/m/Y',strtotime($c->data))}}</td>
            <td>
                <input type="checkbox" data-id="{{$c->id}}" name="status_tarefas" id="status_tarefas" {{$c->status ? 'checked' : ''}}>
            </td>
            
        </tr>
        @endforeach

    </tbody>
</table>
@else
    <h3 class="alert alert-warning text-center text-white">Nenhum Tarefa Para Listar!!</h3>
@endif