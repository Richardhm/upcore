
<section class="container">
    <div class="container-header">
                <div class="d-flex align-items-center justify-content-between border-bottom py-1">
                        <h4 style="margin-bottom:0px;" class="text-white d-flex align-self-center ml-2">Histórico Cliente</h4>
                        <p style="margin-bottom:0px;" class="text-white d-flex align-self-center mr-2 total_tarefa">{{count($tarefas)}}</p>
                </div>
    </div>

    <div class="timeline mt-1 ml-1">
@foreach($tarefas as $t)
    
    <div class="time-label">
        <span class="bg-green">{{date('d/m/Y',strtotime($t->data))}}</span>
    </div>

    <div>
        @switch($t->titulo_id)
            @case(1)
                <i class="fas fa-envelope bg-blue"></i>
            @break
            @case(2)
                <i class="fas fa-phone bg-info"></i>
            @break
            @case(3)
                <i class="fab fa-whatsapp bg-success"></i>
            @break
            @case(4)
                <i class="fas fa-envelope bg-blue"></i>
            @break
            @case(5)
                <i class="fas fa-running"></i>
            @break
        @endswitch
        
        <div class="timeline-item" style="background-color:rgba(0,0,0,0.5);">
            <span class="time"><i class="fas fa-clock"></i> {{date('H:i',strtotime($t->created_at))}}</span>
            <h3 class="timeline-header"><a href="#">{{$t->titulo->titulo}}</a></h3>
            <div class="timeline-body" style="color:aliceblue;">
                {{$t->descricao}}
            </div>
           
        </div>
    </div> 

@endforeach
</div>
</section>