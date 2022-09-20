<input type="hidden" name="tarefa_cadastrada_id" id="tarefa_cadastrada_id" value="{{$tarefa ?? ''}}">
<h4 class="text-center m-0 py-2" style="color:#FFF;border-bottom:2px solid #FFF;font-weight:bold;">
    @switch($titulo)
        @case("atraso")
            <span class="d-block my-3">Tarefas Atrasado</span>    
        @break;
        @case("hoje")
            <span>Tarefas Hoje</span>    
        @break;
        @case("semana")
            <span>Tarefas para essa semana</span>    
        @break;
        @case("mes")
            <span>Tarefas para esse mês</span>    
        @break;
        @case("datas")
            <span>Intervalo</span>
        @break;
    @endswitch
</h4>
@foreach($tarefas as $tt)
    <div data-id="{{$tt->id}}" class="alvo" data-cliente="{{$tt->cliente->id}}">
        <p>{{$tt->title}} - {{$tt->cliente->nome}} - {{date("d/m/Y",strtotime($tt->data))}}</p>
    </div>
@endforeach