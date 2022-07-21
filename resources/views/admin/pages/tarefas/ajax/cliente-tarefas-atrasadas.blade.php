@if(count($clientes) >= 1)
<h4>Tarefa(s) Atrasadas</h4>
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
        @foreach($clientes as $c)
        <tr>
            <td>{{$c->title}}</td>
            <td>{{$c->cliente->nome}}</td>
            <td>{{date('d/m/Y',strtotime($c->data))}}</td>
            <td width="200px;" align="center">
                <input type="checkbox" name="mudarStatus" id="mudarStatus" data-id="{{$c->id}}">
            </td>
            
        </tr>
        @endforeach

    </tbody>
</table>
@else
    <h3 class="alert alert-info text-center">Você não tem tarefas atrasadas!!</h3>
@endif