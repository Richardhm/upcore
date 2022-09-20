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
        <div style="flex-basis:20%;justify-content: space-between;display:flex;flex-direction: column;">
            <div style="display:flex;justify-content: space-between;">
                <a class="" href="{{route('cotacao.orcamento',$c->id)}}" style="background-color:green;color:white;width:80%;border-radius:10px;text-align: center;background-color:rgb(43,128,0);">Orçamento</a>
                <span style="padding:3px;" class="bg-info"><i class="fas fa-phone"></i></span>
            </div>
            <div style="display:flex;justify-content: space-between;margin:2px 0">
                <a class="" href="{{route('cotacao.contrato',$c->id)}}" style="background-color:blue;color:white;width:80%;border-radius:10px;text-align: center;background-color:rgb(0,39,251);">Contrato</a>
                <span class="bg-success" style="padding:4px;"><i class="fab fa-whatsapp"></i></span>
            </div>
            <div style="display:flex;justify-content: space-between;">
                <a href="" style="color:white;width:80%;border-radius:10px;text-align: center;background-color:rgb(249,3,110);">
                    Tarefa
                </a>  
                <span class="bg-danger" style="padding:3px;"><i class="fas fa-envelope"></i></span>  
            </div>
        </div>
    
    </div>
    <hr />
@endforeach