@extends('adminlte::page')

@section('title', 'Clientes Corretores')
@section('plugins.FullCalendar', true)

@section('content_header')
<div class="card-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('clientes.index')}}">Listar Clientes</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tarefas {{$cliente->nome}} </li>
            </ol>
        </nav>
    </div>  
@stop

@section('content')
   
    <div class="card">

        <div class="card-body">
            <div class="row">
                
                    
                
                
            
            
                <div class="col-3">
                    @if(count($cliente->tarefas) >= 1)
                        <h5 class="text-center cabecalho">Tarefas de {{$cliente->nome}}</h5>
                        <ul class="tarefas">
                            @foreach($cliente->tarefas as $t)
                                <li><p>{{$t->title}}</p> <p class="data">{{date("d/m/Y",strtotime($t->data))}}</p></li>
                            @endforeach
                        </ul>
                    @endif            



                    <h5 class="text-center cabecalho my-3">Agendar Tarefa</h5>
                    <form action="{{route('clientes.cadastrarTarefa')}}" method="post">
                        @csrf
                        <input type="hidden" name="cliente_id" id="cliente_id" value="{{$cliente->id}}">
                        <div class="form-group">
                            <label for="title">Titulo:</label>
                            <input type="text" name="title" id="title" class="form-control">
                            @if($errors->has('title'))
                                <p class="alert alert-danger">{{$errors->first('title')}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Data</label>
                            <input type="date" name="data" id="data" class="form-control">
                            @if($errors->has('data'))
                                <p class="alert alert-danger">{{$errors->first('data')}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="descricao">Descrição:</label>
                            <textarea name="descricao" id="descricao" class="form-control" rows="5"></textarea>
                            @if($errors->has('descricao'))
                                <p class="alert alert-danger">{{$errors->first('descricao')}}</p>
                            @endif
                        </div>
                        <input type="submit" class="btn btn-primary btn-block" value="Agendas Tarefa">
                    </form>
                    <hr>
                    <div id="list-tarefas"></div>
                </div>
                <div class="col-9">
                    <div id="fcalendar"></div>
                </div>
            </div>
        </div>   
    <div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Tarefa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('cliente.alterarClienteTarefaEspecifica')}}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="tarefa_id" id="tarefa_id">
                    <input type="hidden" name="cliente_id" id="cliente_id" value="{{$cliente->id}}">
                    <div class="form-group">
                        <label for="title">Titulo</label>
                        <input type="text" name="title" id="title_update" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Data</label>
                        <input type="date" name="data" id="data_update" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descrição:</label>
                        <textarea name="descricao" id="descricao_update" class="form-control" rows="5"></textarea>
                    </div>
                    <input type="submit" class="btn btn-primary btn-block" value="Agendas Tarefa">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm mr-auto deletar_tarefa" data-id="" data-cliente="{{$cliente->id}}">Deletar Tarefa</button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fechar</button>
            </div>
                
            </div>
            </div>
        </div>
    </div>
    
    

   
@stop
@section('js')
<script type="text/javascript">
        var token = '{{ csrf_token() }}';
        var id = $('input[name="cliente_id"]').val();
</script>
<script src="/vendor/fullcalendar/locales/pt-br.js"></script>
    <script>

        function adicionaZero(numero){
            if (numero <= 9) 
                return "0" + numero;
            else
                return numero; 
        }



        $(function(){
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            var fcalendar = document.getElementById('fcalendar');
            var Calendar = FullCalendar.Calendar
            var calendar = new Calendar(fcalendar, {
                locale: 'pt-br',
                navLinks: true,
                editable: true,
                headerToolbar: {
                    locale: 'pt-br',
                    left  : 'prev,next today',
                    center: 'title',
                    right : 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                themeSystem: 'bootstrap',
                
			      
                eventSources: [{
                    url: "{{route('cliente.tarefaEspecifica')}}",
                    method:"POST",
                    color: 'yellow',                    
                    startParam:"data",
                    endParam:"data",
                    textColor: 'black',
                    extraParams: {
                        '_token': token,
                        'id':id
                    }
                }],

                eventSourceSuccess: function(content, xhr) {

                    if(content.length >= 1) {
                        
                    } else {
                        console.log("Nada");
                    }
                },
                
                eventClick: function(info) {
                    $("#title_update").val(info.event.title);
                    $("#descricao_update").val(info.event.extendedProps.descricao);
                    $("#data_update").val(info.event.start.getFullYear()+"-"+adicionaZero(info.event.start.getMonth()+1)+"-"+adicionaZero(info.event.start.getDate()));
                    $("#tarefa_id").val(info.event.id);  
                    $(".deletar_tarefa").attr('data-id',info.event.id);  
                    $('#exampleModal').modal('show')
                },

                eventMouseEnter:function(info) {
                    info.el.style.cursor = "pointer";
                },

                eventDrop: function(e) {
                    $.ajax({
                        url:"{{route('cliente.eventdrop.edit')}}",
                        data:"id="+e.event.id+"&start="+e.event.start.getFullYear()+"-"+adicionaZero(e.event.start.getMonth()+1)+"-"+adicionaZero(e.event.start.getDate()),
                        method:"POST"
                    });		
                }
               
            });

            calendar.render();

        });

        $('body').on('click','.deletar_tarefa',function(){
            let id = $(this).attr('data-id');
            let cliente = $(this).attr('data-cliente');
            $.ajax({
                url:"{{route('cliente.deletarCliente')}}",
                data:"id="+id+"&cliente="+cliente,
                method:"POST",
                success:function(res) {
                    window.location.reload();
                }
            });

        });




    </script>  



@stop

@section('css')
    <style>   
    .cabecalho {
        font-weight: bold;
    }
    ul.tarefas {
        margin:0;
        padding:0;
        list-style: none;
        border-bottom:1px solid black;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        padding:5px 0;
    }
    ul.tarefas li {
        padding:5px 0;
        flex-basis: 48%;
        margin:0 3px 3px 0;
        border:1px solid black;
        text-align: center;
        /* padding:5px 0;
        border:1px solid black;
        text-align: center;
        flex-basis: 50%;
        display: flex;
        flex-wrap: wrap; */
    }
    
    ul.tarefas li .data {
        font-weight: bold;
        
    }
    </style>
@stop
