@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', 'Clientes')

@section('content_header')
@can('clientes_dos_corretores')
                    <a href="{{route('clientes.corretores')}}" class="text-info"><i class="fas fa-users"></i></a>
                @endcan     
    <div class="row">
        <h1>Clientes <a href="{{route('clientes.cadastrar')}}" class="btn btn-warning"><i class="fas fa-plus"></i></a></h1>    
        
        
        <div class="ml-auto">

            <!-- Filtrar Tarefas -->
            <div class="btn-group-vertical dropleft">
                <button type="button" class="btn btn-default dropdown-toggle ml-auto" data-toggle="dropdown" aria-expanded="false">Filtrar Tarefas</button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Dessa Semana</a></li>
                    <li><a class="dropdown-item" href="#">Mês que vem</a></li>
                    <li><a class="dropdown-item" href="#">Cliente(s) Sem Tarefa(s)</a></li>
                    <li><a class="dropdown-item" href="#">Atrasada(s)</a></li>
                    <li><a class="dropdown-item" href="#">Realizada(s)</a></li>
                    <div class="dropdown-divider"></div>
                    <li class="text-center">
                        <a class="dropdown-item listar-todos" href="#" style="color:black;">Listar Todas</a>
                    </li>
                </ul>    
            </div>
            <!-- Fim Filtrar Tarefas -->


            <!-- Filtrar Cliente -->
            <div class="btn-group-vertical dropleft">
                <button type="button" class="btn btn-default dropdown-toggle ml-auto" data-toggle="dropdown" aria-expanded="false">Filtrar Clientes</button>
                <ul class="dropdown-menu">
                    @if(count($etiquetas) >= 1)
                        @foreach($etiquetas as $et)
                            <li>
                                <a class="dropdown-item etiquetas" href="#" data-etiqueta="{{$et->id}}">
                                    <div style="display:flex;align-items: center;">
                                        <div style="width:20px;height:20px;border-radius:50%;background-color:{{$et->cor}}"></div> 
                                        &nbsp;{{$et->nome}}
                                    </div>    
                                </a>
                            </li>
                        
                        @endforeach
                    @endif
                    <div class="dropdown-divider"></div>
                    <li class="text-center">
                        <a class="dropdown-item listar-todos" href="#" style="color:black;">Listar Todos</a>
                    </li>
                </ul>    
            </div>
            <!-- Fim Filtrar Cliente -->





        </div>
       






    </div>
    
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            @if(count($clientes) >= 1)
                @foreach($clientes as $c)
                    <div style="border:1px solid black;display:flex;margin-bottom:5px;justify-content:space-between;padding:5px 0;box-sizing: border-box;align-items: center;">
                        <div style="flex-basis:3%;justify-content: flex-end;margin-left:5px;">
                            <div class="status" data-toggle="modal" data-target="#alterarModal" data-id="{{$c->etiqueta_id}}" data-cliente="{{$c->id}}" style="width:20px;height:20px;border-radius:50%;background-color:{{$c->cor}}"></div>
                        </div>
                    
                        <div style="flex-basis:25%;">
                            <div><b>{{$c->nome}}</b> | {{isset($c->user) && !empty($c->user) ? $c->user : ""}}</div>
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
                                <a href="{{route('clientes.agendarTarefa',$c->id)}}" style="color:white;width:80%;border-radius:10px;text-align: center;background-color:rgb(249,3,110);">
                                    Tarefa
                                </a>  
                                <span class="bg-danger" style="padding:3px;"><i class="fas fa-envelope"></i></span>  
                            </div>
                        </div>
                    
                    </div>
                    <hr />
                @endforeach
                <div>
                    Status:<br />
                    <div style="display:flex;">
                        @if(count($etiquetas) >= 1)
                            @foreach($etiquetas as $et)
                                <div style="display:flex;align-items: center;margin-left:5px;"><div style="width:20px;height:20px;border-radius:50%;background-color:{{$et->cor}}"></div> &nbsp;   <b>{{$et->nome}}</b></div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @else
                <h4 class="text-center">Sem Clientes há serem listados</h4>
            @endif
        </div>
    
    </div>
    
    
   
    </div>
    <div class="modal fade" id="alterarModal" tabindex="-1" aria-labelledby="alterarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="alterarModalLabel">Mudar Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('clientes.mudarStatus')}}" method="POST" name="alterar_valor" id="alterar_valor">
                                @csrf    
                                <input type="hidden" name="id" id="id">
                                <input type="hidden" name="cliente" id="cliente">
                                @foreach($etiquetas as $etique)
                                    <div class="d-flex align-items-center justify-content-between mb-2 border-bottom" style="width: 60%;">
                                        <div><input type="radio" value="{{$etique->id}}" name="status" id="status_{{$etique->id}}">{{$etique->nome}}</input></div>
                                        <div style="display:block;align-self:end;margin-left:15px;width:20px;height:20px;border-radius:50%;background-color:{{$etique->cor}}"></div>
                                    </div>
                                @endforeach
                                <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Alterar Dados</button>
                    </div>                    
                        </form>
                    </div>
                        
                </div>
            </div>
        </div>    
    
@stop
@section('js')
    <script>
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#alterarModal').on('show.bs.modal', function (event) {
                var alvo = $('input[name="id"]').val();
                
                
                $('input[type="radio"]').attr('checked',false);
                $('input[id="status_'+alvo+'"]').attr('checked',true);
                console.log(alvo);
            });
            $('.status').click(function(){
                let id = $(this).attr('data-id');
                let cliente = $(this).attr('data-cliente');
                $('input[name="id"]').val(id);
                $('input[name="cliente"]').val(cliente);
            });
            $("select[name='definir_status']").on('change',function(){
                let id_cliente = $(this).attr('data-id');
                let id_etiqueta = $(this).val();
                $.ajax({
                    url:"{{route('clientes.definirStatus')}}",
                    method:"POST",
                    data:"cliente="+id_cliente+"&etiqueta="+id_etiqueta,
                    success(res) {
                        window.location.reload();
                        //console.log(res);
                        //$('td[id="coluna_'+id_cliente+'"]').html(res);                   
                    }
                });
            });
            $('form[name="alterar_valor"]').on('submit',function(e){
                let action = $(this).attr('action');
               
                $.ajax({
                    url:action,
                    data:$(this).serialize(),
                    method:"POST",
                    success:function(res) {
                        window.location.reload();
                    }
                });
                
                return false;
            });

            $('body').on('click','.etiquetas',function(){
                
                let etiqueta = $(this).attr("data-etiqueta");
                $.ajax({
                    url:"{{route('cliente.listarPorEtiqueta')}}",
                    method:"POST",
                    data:"id="+etiqueta,
                    success:function(res) {
                        $('.card-body').slideUp('fast',function(){
                            $(this).html(res).slideDown('slow');
                        });
                    }
                    
                });
                return false;
            });

            $('body').on('click','.listar-todos',function(){
                $.ajax({
                    url:"{{route('cliente.listarPorEtiquetaAll')}}",
                    method:"POST",
                    success:function(res) {
                        $('.card-body').slideUp('fast',function(){
                            $(this).html(res).slideDown('slow');
                        });
                    }
                });
                return false;
            });





        });
    </script>  



@stop