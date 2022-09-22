@foreach($clientes as $c)
    <div style="border:1px solid black;display:flex;margin-bottom:5px;justify-content:space-between;padding:5px 0;box-sizing: border-box;align-items: center;">
        <div style="flex-basis:3%;justify-content: flex-end;margin-left:5px;">
            <div class="status" data-toggle="modal" data-target="#alterarModal" data-id="{{$c->etiqueta_id}}" data-cliente="{{$c->id}}" style="width:20px;height:20px;border-radius:50%;background-color:{{$c->cor}}"></div>
        </div>
    
        <div style="flex-basis:25%;">
            <div>
                <b>{{$c->nome}}</b>
                @can('configuracoes') | {{$c->user}} @endcan
            </div>
            <div>{{$c->email}}</div>
            <div style="display:flex;">
                <span>{{date('d/m/Y',strtotime($c->created_at))}}</span>
                <span style="margin-left:50px;">{{date('d/m/Y',strtotime($c->ultimo_contato))}}</span>
            </div>
        </div>
        <div style="flex-basis:25%;margin-right:2px;">
            <div>{{$c->cidade}}</div>
            <div>{{$c->telefone}}</div>
            <div>
                @if($c->tarefas_quantidade >= 1) 
                    <span>Com Tarefa</span>
                @else
                    <span>Sem Tarefa</span>
                @endif
            </div>
        </div>
        <div style="flex-basis:15%;">
            <div>Vidas {{$c->quantidade}}</div>
            <div>{{$c->pessoa_fisica == 1 ? "Pessoa Física" : "Pessoa Jurídico"}}</div>
            <div>{{$c->nome_etiqueta}}</div>
        </div>
        
    
    </div>
    <hr />
@endforeach